<?php

namespace App\Console\Commands;
use App\Models\Rappel;

use Illuminate\Console\Command;

class EnvoyerRappel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rappel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';



    public function handle()
    {
        $this->RappelQuotidien();
        $this->RappelHebdomadaire();
        $this->RappelUnique();
    }


    /**
     * Execute the console command.
     */
    public function RappelQuotidien()
    {
       $notif = Rappel::where('frequence', 'quotidien')
                        ->whereDate('date_rappel', '<=', now())
                        ->whereHas('tache', function ($query) {
                            $query->where('date_fin', '>', now());
                        })
                        ->get();
        foreach ($notif as $rappel) {
            $this->line("Rappel quotidien envoyé pour  la tache: " . $rappel->id);
        }
    }

   public function RappelHebdomadaire()
    {
        $notif = Rappel::where('frequence', 'hebdomadaire')
            ->whereDate('date_rappel', '<=', today())
            ->whereHas('tache', function ($query) {
                $query->where('date_fin', '>', now());
            })
            ->whereRaw('DATEDIFF(?, date_rappel) % 7 = 0', [today()->toDateString()])
            ->get();
        foreach ($notif as $rappel) {
            $this->line("Rappel hebdomadaire envoyé pour la tâche : " . $rappel->tache_id);
        }
    }

    public function RappelUnique()
    {
        $notif = Rappel::where('frequence', 'une_fois')
                        ->whereDate('date_rappel', '=', today())
                        ->whereHas('tache', function ($query) {
                            $query->where('date_fin', '>', now());
                        })
                        ->get();
        foreach ($notif as $rappel) {
            $this->line("Rappel unique envoyé pour la tache: " . $rappel->id);
        }
    }
}
