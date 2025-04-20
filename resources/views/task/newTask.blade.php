@extends('layout.layoutUser')

@section('title')
  <title>Nouvelle Tâche</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-xl mt-10">
    <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Créer une nouvelle tâche</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="" method="POST" class="space-y-6">
        @csrf

        <!-- Titre -->
        <div>
            <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="titre" id="titre" required
                class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" style="resize: none" 
                class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
        </div>

        <!-- Date de fin sur la même ligne -->
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="description" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Rappel actif sur la même ligne -->
            <div class="w-1/2 flex items-center">
                <input type="checkbox" name="rappel_active" id="rappel_active"
                    class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-200">
                <label for="rappel_active" class="ml-2 text-sm text-gray-700">Activer le rappel</label>
            </div>
        </div>

        <!-- Fréquence et date de rappel sur la même ligne -->
        <div class="flex gap-4">
            <div class="w-1/2" id="frequence-container" class="hidden">
                <label for="frequence" class="block text-sm font-medium text-gray-700">Fréquence du rappel</label>
                <select name="frequence" id="frequence"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="une_fois">Une seule fois</option>
                    <option value="quotidien">Tous les jours</option>
                    <option value="hebdomadaire">Chaque semaine</option>
                </select>
            </div>

            <div class="w-1/2" id="date-container-solo" class="hidden">
                <label for="date_rappel_solo" class="block text-sm font-medium text-gray-700">Date du rappel</label>
                <input type="date" name="date_rappel_solo" id="date_rappel_solo"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>
        </div>
        
        <!-- Date du rappel multiple sur la même ligne -->
        <div class="flex gap-4">
            <div class="w-1/2" id="date-container-multiple" class="hidden">
                <label for="date_rappel_multiple" class="block text-sm font-medium text-gray-700">Date du premier rappel</label>
                <input type="date" name="date_rappel_multiple" id="date_rappel_multiple"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>
        </div>

        <!-- Bouton de soumission -->
        <div class="text-center">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition duration-200">
                Enregistrer la tâche
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/newTask.js') }}"></script>
@endsection
