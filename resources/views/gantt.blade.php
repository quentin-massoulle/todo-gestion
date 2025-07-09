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
  </script>
@endsection