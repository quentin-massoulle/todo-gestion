@extends('layout')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
Mes Tâches
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/Tache.css') }}">
<link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
@endsection

@section('content')

<div class="max-w-7xl mx-auto py-4 px-4 w-full">
    <h2 class="text-xl font-bold mb-1 text-center text-gray-800">Liste des Tâches</h2>
        
    <div class="flex justify-end mb-1">
        <button id="openTaskModal" 
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded shadow transition duration-200">
            {{__('task.new')}}
        </button>
    </div>

    @include('task.taskFormModal')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
    @foreach (['nouveau', 'planifie', 'en_cours', 'termine'] as $etat)
            <div class="p-4 rounded shadow task-column">
                <h3 class="text-lg font-bold mb-4 capitalize text-center text-gray-700">
                    {{ __("task.etat.$etat") }}
                </h3>

                <div id="column-{{ $etat }}" data-etat="{{ $etat }}" class="space-y-4 min-h-[100px] max-h-[380px] overflow-y-auto">
                    @foreach($tasks->get($etat, collect()) as $task)
                        <div class="bg-white p-5 rounded shadow hover:shadow-md task-card" data-id="{{ $task->id }}">
                            <div class="flex justify-between items-center">
                                <h4 class="font-semibold text-gray-900 w-9/10">{{ $task->titre }}</h4>
                                @if($task->groupe_id != null && $groupe != null)
                                    <img src="{{ $task->user->profilePicture() }}" alt="Photo de profil" class="profile-picture w-1/10">
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="mt-2"> 
                                    <span class="{{ $task->couleur_temps }} text-[10px] font-bold px-3 py-1 rounded-full uppercase shadow-sm inline-block" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);">
                                        Fin: {{ \Carbon\Carbon::parse($task->date_fin)->format('d/m/Y') }}
                                    </span>
                                </div>
                                <a href="javascript:void(0)" 
                                class="text-blue-600 hover:text-blue-800 text-sm editTaskBtn"
                                data-id="{{ $task->id }}"
                                data-titre="{{ $task->titre }}"
                                data-description="{{ $task->description }}"
                                data-user-id="{{ $task->user_id }}"
                                data-debut="{{ $task->date_debut ? $task->date_debut->format('Y-m-d') : '' }}"
                                data-fin="{{ $task->date_fin ? $task->date_fin->format('Y-m-d') : '' }}"
                                data-rappel-active="{{ $task->rappel_active ? '1' : '0' }}"
                                data-rappel-date="{{ $task->Rappels->first()?->date_rappel ? \Carbon\Carbon::parse($task->Rappels->first()->date_rappel)->format('Y-m-d') : '' }}"
                                data-rappel-frequence="{{ $task->Rappels->first()?->frequence ?? 'une_fois' }}">
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
<script src="{{ asset('js/pop-up.js') }}" defer></script>
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
