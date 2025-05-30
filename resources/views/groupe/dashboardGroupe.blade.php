@extends('layout.layoutUser')

@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardGroupe.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
<section class="hero">
    <div class="mx-auto">
        <h2 class="text-4xl font-semibold mb-4">Bienvenue dans vos groupes {{ Auth::user()->nom }}</h2>
    </div>
</section>

<h2 class="text-3xl font-semibold mb-4">Liste des groupes et utilisateurs</h2>
<div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8m min-h-[100px] max-h-[400px] overflow-y-auto">
    @foreach($groupes as $groupe)
        <div class="etiquette">
            <h3 class="text-2xl font-bold mb-2">{{ $groupe->nom }}</h3>
            <p class="text-gray-600 mb-4">Utilisateurs du groupe :</p>
            <ul>
                @foreach($groupe->users as $user)
                    <li>{{ $user->nom }} {{$user->prenom}}</li>
                @endforeach
            </ul>
            <button class="btn">
                <i>
                    <a href="/groupe/{{$groupe->id}}"> acceder au groupe </a>
                </i>
            </button>
        </div>
    @endforeach
</div>
@endsection
