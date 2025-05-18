@extends('layout.layoutUser')

@section('title')
  <title>Mes Tâches</title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
@if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 5000)" 
        x-show="show" 
        class="fixed top-4 left-4 bg-green-100 border border-green-400 text-green-700 text-sm px-4 py-2 rounded shadow-md z-50 transition duration-500 ease-in-out"
    >
        <div class="flex items-center justify-between space-x-2">
            <div>
                <strong class="font-semibold">Succès :</strong>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-700 hover:text-green-900">
                &times;
            </button>
        </div>
    </div>
@endif
<div class="max-w-6xl mx-auto py-8 px-4">
  <h2 class="text-xl font-bold mb-6 text-center text-gray-800">Liste des Tâches</h2>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100 text-gray-700 text-sm font-semibold ">
              <tr>
                  <th scope="col" class="px-6 py-4">{{__('task.titre')}}</th>
                  <th scope="col" class="px-6 py-4">{{__('task.description')}}</th>
                  <th scope="col" class="px-6 py-4">{{__('task.date_fin')}}</th>
                  <th class="px-6 py-4 text-center">{{__('task.action')}}</th>
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
