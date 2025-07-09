@extends('layout.layoutUser')

@section('title')
  <title>Gantt Chart for Groupe</title>
@endsection

@section('content')
  <div class=>
    <h1 class="text-3xl font-semibold mb-4">Gantt Chart for Groupe: {{ $groupe->name }}</h1>
    <div id="gantt"></div>
  </div>
@endsection

@section('scripts')
  @vite('resources/js/app.js')
  <script>
    window.appTasks = @json($taches);

    document.addEventListener('DOMContentLoaded', () => {
        if (window.appTasks) {
            const formattedTasks = window.appTasks.map(task => ({
                id: task.id.toString(),
                name: task.titre,
                start: task.date_debut,
                end: task.date_fin,
                dependencies: task.dependencies || '',
                proprietaire: task.user ? task.user.name : 'Aucun',
            }));

            const gantt = new Gantt("#gantt", formattedTasks, {
                view_mode: 'Day',
                language: 'fr',
                on_date_change: (task, start, end) => {
                    // Formater les dates pour MySQL : 'YYYY-MM-DD HH:MM:SS'
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
        } else {
            console.error('No tasks found');
        }
    });
    </script>

@endsection