<?php

namespace App\Console\Commands;

use App\Models\Rappel;
use App\Mail\DeadlineReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
    protected $description = 'Envoie un e-mail récapitulatif par utilisateur contenant les tâches dont le rappel correspond à aujourd\'hui.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Début du traitement des rappels d'échéances...");

        $today = now()->startOfDay();

        // 1. Rappels quotidiens
        $daily = Rappel::where('frequence', 'quotidien')
            ->whereDate('date_rappel', '<=', $today)
            ->whereHas('tache', function ($query) {
                $query->where('etat', '!=', 'termine')
                      ->where('rappel_active', true)
                      ->whereNotNull('user_id');
            })
            ->with(['tache.user'])
            ->get();

        // 2. Rappels hebdomadaires
        $weekly = Rappel::where('frequence', 'hebdomadaire')
            ->whereDate('date_rappel', '<=', $today)
            ->whereRaw('DATEDIFF(?, date_rappel) % 7 = 0', [$today->toDateString()])
            ->whereHas('tache', function ($query) {
                $query->where('etat', '!=', 'termine')
                      ->where('rappel_active', true)
                      ->whereNotNull('user_id');
            })
            ->with(['tache.user'])
            ->get();

        // 3. Rappels uniques
        $unique = Rappel::where('frequence', 'une_fois')
            ->whereDate('date_rappel', '=', $today)
            ->whereHas('tache', function ($query) {
                $query->where('etat', '!=', 'termine')
                      ->where('rappel_active', true)
                      ->whereNotNull('user_id');
            })
            ->with(['tache.user'])
            ->get();

        // Fusion de tous les rappels
        $allReminders = $daily->concat($weekly)->concat($unique);

        // Regroupement par utilisateur
        $tasksByUser = [];

        foreach ($allReminders as $rappel) {
            $tache = $rappel->tache;
            if ($tache && $tache->user) {
                $userId = $tache->user->id;
                if (!isset($tasksByUser[$userId])) {
                    $tasksByUser[$userId] = [
                        'user' => $tache->user,
                        'tasks' => collect(),
                    ];
                }
                // Éviter les doublons
                if (!$tasksByUser[$userId]['tasks']->contains('id', $tache->id)) {
                    $tasksByUser[$userId]['tasks']->push($tache);
                }
            }
        }

        if (count($tasksByUser) === 0) {
            $this->info("Aucun rappel à envoyer aujourd'hui.");
            return 0;
        }

        $sentCount = 0;
        foreach ($tasksByUser as $data) {
            $user = $data['user'];
            $tasks = $data['tasks'];

            try {
                Mail::to($user->email)->send(new DeadlineReminderMail($user, $tasks));
                $this->info("E-mail de rappel envoyé avec succès à {$user->email} ({$tasks->count()} tâches).");
                $sentCount++;
            } catch (\Exception $e) {
                $this->error("Erreur lors de l'envoi du mail à {$user->email} : " . $e->getMessage());
            }
        }

        $this->info("Traitement terminé : {$sentCount} e-mail(s) envoyé(s).");
        return 0;
    }
}
