@extends('layout.layoutUser')

@section('title')
  <title></title>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')

@foreach ($tasks as $task)
    <div>
        <h3>{{ $task->titre }}</h3>
        <p>{{ $task->description }}</p>
        <p>À faire avant le : {{ $task->date_fin }}</p>
    </div>
@endforeach


@endsection

@section('script')
    <script src="{{ asset('js/newTask.js') }}"></script>
@endsection
