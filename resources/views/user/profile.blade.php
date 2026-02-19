@extends('layout')

@section('title')
  Profil Utilisateur
@endsection
@section('style')
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="carte">
  <div class="carteInner">
    <h1>Informations</h1>
    <br>
    <div class="section">
     <div class="avatar-section" onclick="document.getElementById('uploadProfile').click();">
        <img src="{{ asset('storage/users/' . $user->id . '.jpg') }}"
            alt="Photo de profil" 
            class="profile-picture">
      </div>
      <div class="info">
        <div class="info-item">
          <i class="fas fa-id-card fa-2x"></i>
          <p><strong>Nom :</strong> {{ $user->nom }}</p>
        </div> 
      </div>
      <div class="info">
       <div class="info-item">
          <i class="fas fa-user-tag fa-2x"></i>
          <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
        </div>
      </div>
      <div class="info">
        <div class="info-item">
          <i class="fas fa-envelope fa-2x"></i>
          <p><strong>Email :</strong> {{ $user->email }}</p>
        </div>
      </div>
    </div>
  </div>
  <h1>Statistiques</h1>
    <br>
    <div class="section-stats">
      <div class="section-inner">
        <div class="info">
          <div class="info-item">
            <i class="fas fa-tasks fa-2x"></i>
            <p><strong>Nombre total de tâches :</strong> {{ count($user->tasks) }}</p>
          </div>
        </div>
        <div class="info">
          <div class="info-item">
            <i class="fas fa-check-circle fa-2x"></i>
            <p><strong>Nombre total de tâches terminées :</strong> {{ count($user->tasks->where('etat', 'termine')) }}</p>
          </div>
        </div>
        <div class="info">
          <div class="info-item">
              <i class="fas fa-hourglass-half fa-2x"></i>
            <p><strong>Nombre total de tâches en cours :</strong> {{ count($user->tasks->where('etat', 'en_cours')) }}</p>
          </div>
        </div>
      </div>
      <div class="section-inner">
        <div class="info">
          <div class="info-item">
            <i class="fas fa-calendar-alt fa-2x"></i>
            <p><strong>Nombre total de tâches à faire :</strong> {{ count($user->tasks->where('etat', 'planifie')) }}</p>
          </div>
        </div>
        <div class="info">
          <div class="info-item">
            <i class="fas fa-plus-circle fa-2x"></i>
            <p><strong>Nombre total nouvelles tâches :</strong> {{ count($user->tasks->where('etat', 'nouveau')) }}</p>
          </div>
        </div>
        <div class="info">
          <div class="info-item">
            <i class="fas fa-project-diagram fa-2x"></i>
            <p><strong>Nombre de groupes :</strong> {{ count($user->groupe) }}</p>
          </div>
        </div>
      </div>
    </div>
    <br><br><br>
  </div>
</div>


<form id="uploadForm" action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="file" id="uploadProfile" name="photo" accept="image/*" style="display: none;" onchange="this.form.submit();">
</form>

@endsection