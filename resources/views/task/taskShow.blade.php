@extends('layout')

@section('title')
  Nouvelle Tâche
@endsection


@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
  <link rel="stylesheet" href="{{ asset('css/Tache.css') }}">
  <link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')
<div style="display: flex; flex-direction: row; gap: 10px;">


    <div class="w-full max-h-[70vh] flex flex-row">
<div class="w-1/2 mx-auto p-4 bg-white rounded-lg shadow-xl h-fit">
            <div class="card-header">
                <i class="fa-solid fa-circle-check header-icon" style="padding-right: 10px; padding-left: 10px;"></i>
                <div>
                    <h2>{{ isset($task) ? 'Modifier la tâche' : 'Nouvelle Tâche' }}</h2>
                </div>
            </div>

            <form method="POST" class="modern-form">
                @csrf
                @if(isset($groupe)) <input type="hidden" name="groupe" value="{{ $groupe->id }}"> @endif
                @if(isset($task)) <input type="hidden" name="TaskId" value="{{ $task->id }}"> @endif

                <div class="form-group">
                    <label>{{ __('task.titre') }}</label>
                    <input type="text" name="titre" required placeholder="Titre de la mission" value="{{ old('titre', $task->titre ?? '') }}">
                </div>

                <div class="form-group">
                    <label>{{ __('task.description') }}</label>
                    <textarea name="description" placeholder="Description détaillée...">{{ old('description', $task->description ?? '') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fa-regular fa-calendar"></i> {{ __('task.date_debut') }}</label>
                        <input type="date" name="date_debut" value="{{ old('date_debut', $task->date_debut ? $task->date_debut->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label><i class="fa-solid fa-calendar-check"></i> {{ __('task.date_fin') }}</label>
                        <input type="date" name="date_fin" value="{{ old('date_fin', $task->date_fin ? $task->date_fin->format('Y-m-d') : '') }}">
                    </div>
                </div>

                @if(isset($listeTache))
                <div class="form-group">
                    <label><i class="fa-solid fa-link"></i> {{ __('task.dependance') }}</label>
                    <select class="select2" name="dependance[]" multiple="multiple" style="max-height: 30px !important;">
                        @foreach ($listeTache as $item)
                            @if(isset($task) && $item->id != $task->id)
                                <option value="{{ $item->id }}" @if(isset($task) && collect($task->dependance->pluck('id'))->contains($item->id)) selected @endif>
                                    {{ $item->titre }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="notification-card">
                    <div class="notif-info">
                        <div class="notif-icon"><i class="fa-solid fa-bell"></i></div>
                        <div style="display: flex; flex-direction: row; gap: 10px;">
                            <strong>Notification</strong>
                            <span>Activer les rappels automatiques</span>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="rappel_active" id="rappel_active" {{ old('rappel_active', $task->rappel_active ?? false) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
                <div id="rappel-options" class="space-y-4 mb-6 {{ old('rappel_active', $task->rappel_active ?? false) ? '' : 'hidden' }}">
                    <div class="form-row">
                        <div class="form-group" id="frequence-container">
                            <label for="frequence">{{ __('task.frequence_du_rappel') }}</label>
                            <select name="frequence" id="frequence" class="modern-input">
                                @php 
                                    $currentFreq = old('frequence', $task->rappels->first()?->frequence ?? 'une_fois'); 
                                @endphp
                                <option value="une_fois" {{ $currentFreq == 'une_fois' ? 'selected' : '' }}>{{ __('task.une_seule_fois') }}</option>
                                <option value="quotidien" {{ $currentFreq == 'quotidien' ? 'selected' : '' }}>{{ __('task.tous_les_jours') }}</option>
                                <option value="hebdomadaire" {{ $currentFreq == 'hebdomadaire' ? 'selected' : '' }}>{{ __('task.chaque_semaine') }}</option>
                            </select>
                        </div>

                        @php
                            $rappel = $task->rappels->first();
                            $dbDate = '';

                            if ($rappel && $rappel->date_rappel) {
                                $dbDate = \Carbon\Carbon::parse($rappel->date_rappel)->format('Y-m-d');
                            }
                        @endphp
                        
                        <div class="form-group" id="date-container-solo">
                                <label for="date_rappel_solo">{{ __('task.date_du_rappel') }}</label>
                                <input type="date" name="date_rappel_solo" id="date_rappel_solo" class="modern-input" 
                                    value="{{ filled(old('date_rappel_solo')) ? old('date_rappel_solo') : $dbDate }}">
                            </div>
                        
                            <div class="form-group hidden" id="date-container-multiple">
                                <label for="date_rappel_multiple">{{ __('task.date_du_premier_rappel') }}</label>
                                <input type="date" name="date_rappel_multiple" id="date_rappel_multiple" class="modern-input"
                                    value="{{ filled(old('date_rappel_multiple')) ? old('date_rappel_multiple') : $dbDate }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-paper-plane"></i> {{ __('task.enregistrer_la_tache') }}
                    </button>
                </form>
            </div>
        </div>
        @if($task->groupe_id != null)
                @include('message.messageBox')
            @endif

    </div>
    @endsection
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('rappel_active');
                const optionsContainer = document.getElementById('rappel-options');
                const frequenceSelect = document.getElementById('frequence');
                const dateSoloContainer = document.getElementById('date-container-solo');
                const dateMultipleContainer = document.getElementById('date-container-multiple');

                function toggleRappelOptions() {
                    if (checkbox.checked) {
                        optionsContainer.classList.remove('hidden');
                        updateDateFields();
                    } else {
                        optionsContainer.classList.add('hidden');
                }
            }

            function updateDateFields() {
                const frequence = frequenceSelect.value;
                
                if (frequence === 'une_fois') {
                    dateSoloContainer.classList.remove('hidden');
                    dateMultipleContainer.classList.add('hidden');
                    document.getElementById('date_rappel_solo').setAttribute('required', 'required');
                    document.getElementById('date_rappel_multiple').removeAttribute('required');
                } else {
                    dateSoloContainer.classList.add('hidden');
                    dateMultipleContainer.classList.remove('hidden');
                    document.getElementById('date_rappel_solo').removeAttribute('required');
                    document.getElementById('date_rappel_multiple').setAttribute('required', 'required');
                }
            }

            checkbox.addEventListener('change', toggleRappelOptions);
            frequenceSelect.addEventListener('change', updateDateFields);

            // Initial check
            toggleRappelOptions();
        });
    </script>
    <script>
        window.urlPost = '/message/addMessage';
        window.urlGet  = '/message/getMessage';
    </script>
    <script src="{{ asset('js/message.js') }}" type="module"></script>
@endsection
