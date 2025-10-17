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
    <div class="section">
      <img src="https://via.placeholder.com/120" alt="Avatar">
    </div>

    <h3>Informations</h3>
    <br>
    <div class="section">
      <div class="info">
        <h4>Nom :</h4>
        <p>—</p>   
      </div>
      <div class="info">
        <h4>Prénom :</h4>
        <p>—</p>
      </div>
      <div class="info">
        <h4>Email :</h4>
        <p>—</p>
      </div>
    </div>
  </div>
  <h3>Statistiques</h3>
    <br>
    <div class="section">
      <div class="info">
        <h4>Tâches finies :</h4>
        <p>—</p>   
      </div>
      <div class="info">
        <h4>Tâches en cours :</h4>
        <p>—</p>
      </div>
      <div class="info">
        <h4>Tâches à faire :</h4>
        <p>—</p>
      </div>
      <div class="info">
        <h4>Nombre de groupes :</h4>
        <p>—</p>
      </div>
    </div>
    <br><br><br>
  </div>
</div>


@endsection