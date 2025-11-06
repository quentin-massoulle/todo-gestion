@extends('layout.layoutUser')

@section('title')
  <title>Profil Utilisateur</title>
@endsection
@section('style')
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="carte">
  <div class="carteInner">
    <h3>Informations</h3>
    <br>
    <div class="section">
      <div class = "avatar-section">
        <img src="{{ asset('storage/users/' . $user->id . '.jpg') }}" alt="Photo de profil" class="profile-picture">
      </div>
      <div class="info">
        <h4>Nom :</h4>
        <p>{{ $user->nom }}</p>   
      </div>
      <div class="info">
        <h4>Prénom :</h4>
        <p>{{ $user->prenom }}</p>
      </div>
      <div class="info">
        <h4>Email :</h4>
        <p>{{ $user->email }}</p>
      </div>
    </div>
  </div>
  <h3>Statistiques</h3>
    <br>
    <div class="section">
      <div class="info">
        <h4>Tâches finies :</h4>
        <p>{{ count($user->tasks->where('etat', 'termine')) }}</p>
      </div>
      <div class="info">
        <h4>Tâches en cours :</h4>
        <p>{{ count($user->tasks->where('etat', 'en_cours')) }}</p>
      </div>
      <div class="info">
        <h4>Tâches à faire :</h4>
        <p>{{ count($user->tasks->where('etat', 'planifie')) }}</p>
      </div>
      <div class="info">
        <h4>Nombre de groupes :</h4>
        <p>{{ count($user->groupe) }}</p>
      </div>
    </div>
    <br><br><br>
  </div>
</div>


@endsection