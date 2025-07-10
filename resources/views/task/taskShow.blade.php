@extends('layout.layoutUser')

@section('title')
  <title>Nouvelle Tâche</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardTask.css') }}">
@endsection

@section('content')
<div class="w-full h-[70vh] flex flex-row p-2">
    <div class="w-1/2 mx-auto p-2 bg-white rounded-lg shadow-xl">
        <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">@if(isset($task))Modifier une tâche existante @else Créer une nouvelle tâche @endif</h2>

        <form method="POST" class="space-y-2">
            @csrf
            @if(isset($groupe))
                <input type="hidden" name="groupe" value="{{ $groupe->id }}">
            @endif
            @if(isset($task))
                <input type="hidden" name="TaskId" value="{{ $task->id }}">
            @endif
        
            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700">{{ __('task.titre') }}</label>
                <input 
                    type="text" 
                    name="titre" 
                    id="titre" 
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="{{ old('titre', $task->titre ?? '') }}"
                >
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">{{ __('task.description') }}</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    style="resize: none" 
                    class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                >{{ old('description', $task->description ?? '') }}</textarea>
            </div>
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label for="date" class="block text-sm font-medium text-gray-700">{{ __('task.date_debut') }}</label>
                    <input 
                        type="date" 
                        name="date_debut" 
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        value="{{ old('date_debut', $task->date_debut ?? '') }}"
                    >
                </div>
                @if(isset($listeTache))
                    <div class="w-1/2">
                        <label for="priorite" class="block text-sm font-medium text-gray-700">{{ __('task.dependance') }}</label>
                    
                        <select class="select2" name="dependance[]" multiple=true style="width: 100%;" >
                            @foreach ($listeTache as $dependance)
                               @if ($dependance->id != $task->id)
                                    <option value="{{$dependance->id}}" 
                                        @if(isset($task) && $task->dependance->contains($dependance->id)) selected @endif>
                                        {{$dependance->titre}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label for="date" class="block text-sm font-medium text-gray-700">{{ __('task.date_fin') }}</label>
                    <input 
                        type="date" 
                        name="date_fin" 
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        value="{{ old('date_fin', $task->date_fin ?? '') }}"
                    >
                </div>
                <div class="w-1/2 flex items-center">
                    <input type="checkbox" name="rappel_active" id="rappel_active"
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-200"
                        {{ old('rappel_active', $task->rappel_active ?? false) ? 'checked' : '' }}>
                    <label for="rappel_active" class="ml-2 text-sm text-gray-700">{{ __('task.activer_le_rappel') }}</label>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-1/2" id="frequence-container" class="hidden">
                    <label for="frequence" class="block text-sm font-medium text-gray-700">{{ __('task.frequence_du_rappel') }}</label>
                    <select name="frequence" id="frequence"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="une_fois">{{ __('task.une_seule_fois') }}</option>
                        <option value="quotidien">{{ __('task.tous_les_jours') }}</option>
                        <option value="hebdomadaire">{{ __('task.chaque_semaine') }}</option>
                    </select>
                </div>

                <div class="w-1/2" id="date-container-solo" class="hidden">
                    <label for="date_rappel_solo" class="block text-sm font-medium text-gray-700">{{ __('task.date_du_rappel') }}</label>
                    <input type="date" name="date_rappel_solo" id="date_rappel_solo"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>
            </div>
            
            <div class="flex gap-4" >
                <div class="w-1/2" id="date-container-multiple" class="hidden">
                    <label for="date_rappel_multiple" class="block text-sm font-medium text-gray-700">{{ __('task.date_du_premier_rappel') }}</label>
                    <input type="date" name="date_rappel_multiple" id="date_rappel_multiple"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>
            </div>
            <div class="text-center">
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition duration-200">
                    {{ __('task.enregistrer_la_tache') }}
                </button>
            </div>
        </form>
    </div>
    @if(isset($groupe) || isset($task))
        @include('message.messageBox')
    @endif
</div>

@endsection

@section('script')
    <script>
        window.urlPost = '/message/addMessage';
        window.urlGet  = '/message/getMessage';
    </script>
    <script src="{{ asset('js/newTask.js') }}" defer></script>
    <script  src="{{ asset('js/message.js') }}" defer></script>
@endsection
