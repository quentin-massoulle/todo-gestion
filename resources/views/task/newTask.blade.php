@extends('layout.layoutUser')

@section('title')
  <title>Nouvelle Tâche</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-2xl shadow-lg mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer une nouvelle tâche</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="titre" id="titre" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        
        <div class="flex flex-col gap-4">
            <div class="flex items-center">
                <input type="checkbox" name="rappel_active" id="rappel_active"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="rappel_active" class="ml-2 block text-sm text-gray-700">
                    Activer le rappel
                </label>
            </div>
        
            <div id="frequence-container" class="hidden">
                <label for="frequence" class="block text-sm font-medium text-gray-700">Fréquence du rappel</label>
                <select name="frequence" id="frequence"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="une_fois">Une seule fois</option>
                    <option value="quotidien">Tous les jours</option>
                    <option value="hebdomadaire">Chaque semaine</option>
                </select>
            </div>
        
            <div id="date-container" class="hidden">
                <label for="date_rappel" class="block text-sm font-medium text-gray-700">Date du rappel</label>
                <input type="date" name="date_rappel" id="date_rappel"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="text-center">
            <button type="submit"
                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                Enregistrer la tâche
            </button>
        </div>
    </form>
</div>


@section('script')
    <script src="{{ asset('js/newTask.js') }}"></script>
@endsection
@endsection
