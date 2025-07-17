@extends('layout.layoutUser')

@section('title')
  <title>Gantt Chart for Groupe</title>
@endsection

@section('content')
    <div id="gantt" style="height: 70vh;"></div>
@endsection

@section('scripts')
  @vite('resources/js/app.js')
  <script>
    const etatToProgress = {
      'nouveau': 0,
      'planifie': 33,
      'en_cours': 66,
      'termine': 100
    };
    window.appTasks = @json($taches);
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Tasks loaded:', window.appTasks);
        if (window.appTasks) {
            const formattedTasks = window.appTasks.map(task => ({
                id: task.id.toString(),
                name: task.titre,
                start: task.date_debut,
                end: task.date_fin,
                dependencies: task.dependencies ? task.dependencies.split(',').map(dep => dep.trim()) : [],
                proprietaire: task.user ? task.user.nom : 'Aucun',
                progress: etatToProgress[task.etat] ?? 0,
                etat: task.etat
            }));
            const gantt = new Gantt("#gantt", formattedTasks, {
                view_mode: 'Day',
                language: 'fr',
                popup_on : 'hover',
                infinite_padding: false,
                lines: 'horizontal',
                on_click: (task) => {
                    window.location.href = `/user/task/${task.id}`;
                },
                on_date_change: (task, start, end) => {
                    const startDate = new Date(start).toISOString().slice(0, 19).replace('T', ' ');
                    const endDate = new Date(end).toISOString().slice(0, 19).replace('T', ' ');

                    console.log('Nouvelles dates formatées pour Laravel :', startDate, endDate);

                    fetch(`/tache/${task.id}/update-dates`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            start: startDate,
                            end: endDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Mise à jour réussie', data);
                    })
                    .catch(error => {
                        console.error('Erreur lors de la mise à jour', error);
                    });
                },
            });
            const container = document.querySelector(".gantt-container");
            if (container) {
                const height = container.offsetHeight;
                container.style.height = `${height + 50}px`;
                container.style.maxHeight = "100%";
            }
        } else {
            console.error('No tasks found');
        }
    });
    </script>

@endsection