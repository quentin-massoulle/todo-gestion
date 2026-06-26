<?php

namespace App\Console\Commands;

use App\Models\Rappel;
use App\Mail\DeadlineReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Exception;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un e-mail récapitulatif par utilisateur contenant le nombre de tâches dont le rappel correspond à aujourd\'hui.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("Début du traitement des rappels d'échéances...");

        $today = now()->startOfDay();

        // Une seule requête SQL optimisée pour récupérer tous les rappels correspondants
        $reminders = Rappel::whereHas('tache', function ($query) {
                $query->where('etat', '!=', 'termine')
                      ->where('rappel_active', true)
                      ->whereNotNull('user_id');
            })
            ->where(function ($query) use ($today) {
                $query->where(function ($q) use ($today) {
                    // Rappels quotidiens
                    $q->where('frequence', 'quotidien')
                      ->whereDate('date_rappel', '<=', $today);
                })
                ->orWhere(function ($q) use ($today) {
                    // Rappels hebdomadaires
                    $q->where('frequence', 'hebdomadaire')
                      ->whereDate('date_rappel', '<=', $today)
                      ->whereRaw('DATEDIFF(?, date_rappel) % 7 = 0', [$today->toDateString()]);
                })
                ->orWhere(function ($q) use ($today) {
                    // Rappels uniques
                    $q->where('frequence', 'une_fois')
                      ->whereDate('date_rappel', '=', $today);
                });
            })
            ->with(['tache.user'])
            ->get();

        // Regrouper les tâches uniques par utilisateur
        $tasksByUser = $reminders
            ->map(fn ($rappel) => $rappel->tache)
            ->filter(fn ($tache) => $tache && $tache->user)
            ->unique('id')
            ->groupBy(fn ($tache) => $tache->user->id);

        if ($tasksByUser->isEmpty()) {
            $this->info("Aucun rappel à envoyer aujourd'hui.");
            return 0;
        }

        $sentCount = 0;
        foreach ($tasksByUser as $userId => $userTasks) {
            $user = $userTasks->first()->user;

            try {
                Mail::to($user->email)->send(new DeadlineReminderMail($user, $userTasks));
                $this->info("E-mail de rappel envoyé avec succès à {$user->email} ({$userTasks->count()} tâches).");
                $sentCount++;
            } catch (Exception $e) {
                $this->error("Erreur lors de l'envoi du mail à {$user->email} : " . $e->getMessage());
            }
        }

        $this->info("Traitement terminé : {$sentCount} e-mail(s) envoyé(s).");
        return 0;
    }
}
