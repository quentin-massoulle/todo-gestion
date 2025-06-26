@extends('layout.layoutUser')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
  <title>Mes Tâches</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')

<div class="max-w-6xl mx-auto py-8 px-4">
  <h2 class="text-xl font-bold mb-6 text-center text-gray-800">Liste des Tâches</h2>

  <div class="flex justify-end mb-4">
        <a href="{{ route('user.task.show', ['id' => 0])}}?groupe={{$groupe}}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-200">
            {{__('task.new')}}
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
       @foreach (['nouveau', 'planifie', 'en_cours', 'termine'] as $etat)
            <div class="bg-gray-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold mb-4 capitalize text-center text-gray-700">
                    {{ __("task.etat.$etat") }}
                </h3>

                <div id="column-{{ $etat }}" data-etat="{{ $etat }}" class="space-y-4 min-h-[250px] max-h-[450px] overflow-y-auto">
                    @foreach($tasks->get($etat, collect()) as $task)
                        <div class="bg-white p-3 rounded shadow hover:shadow-md" data-id="{{ $task->id }}">
                            <h4 class="font-semibold text-gray-900">{{ $task->titre }}</h4>
                            <p class="text-gray-600 text-sm mb-2">{{ $task->description }}</p>
                            <p class="text-gray-500 text-xs">Fin: {{ \Carbon\Carbon::parse($task->date_fin)->format('d/m/Y') }}</p>
                            <div class="text-right mt-2">
                                <a href="{{ route('user.task.show', ['id' => $task->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-pen"></i> {{ __('task.modifier') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const etats = ['nouveau', 'planifie', 'en_cours', 'termine'];

        etats.forEach(etat => {
            const container = document.getElementById('column-' + etat);
            new Sortable(container, {
                group: 'kanban',
                animation: 150,
                onAdd: function (evt) {
                    const taskId = evt.item.dataset.id;
                    const newEtat = evt.to.dataset.etat;

                    fetch(`/user/tasks/${taskId}/update-etat`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ etat: newEtat })
                    }).then(res => {
                        if (!res.ok) console.error('Erreur lors de la mise à jour de l\'état');
                    });
                }
            });
        });
    });
</script>

@endsection
