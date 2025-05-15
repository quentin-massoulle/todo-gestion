@extends('layout.layoutUser')

@section('title')
  <title>Mes Tâches</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
  <h2 class="text-xl font-bold mb-6 text-center text-gray-800">Liste des Tâches</h2>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100 text-gray-700 text-sm font-semibold ">
              <tr>
                  <th scope="col" class="px-6 py-4">Titre</th>
                  <th scope="col" class="px-6 py-4">Description</th>
                  <th scope="col" class="px-6 py-4">Date de fin</th>
                  <th class="px-6 py-4 text-center">Actions</th>
              </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 text-sm">
              @forelse ($tasks as $task)
                  <tr class="hover:bg-gray-50">
                      <td class="px-6 py-4 text-gray-900 ">{{ $task->titre }}</td>
                      <td class="px-6 py-4 text-gray-700 ">{{ $task->description }}</td>
                      <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($task->date_fin)->format('d/m/Y') }}</td>
                      <td class="px-6 py-4 text-center">
                        <a href="{{ route('user.task.show',['id' => $task->id]) }}"  class="text-blue-600 hover:text-blue-800" title="Modifier">
                          <i class="fas fa-pen"></i>
                        </a>
                    </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune tâche trouvée.</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
  </div>
</div>


@endsection

@section('script')
    <script src="{{ asset('js/newTask.js') }}"></script>
@endsection
