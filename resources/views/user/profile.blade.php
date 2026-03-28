@extends('layout')

@section('title')
  Profil Utilisateur
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <!-- Header Section -->
    <div class="profile-header">
        <div class="header-cover"></div>
        <div class="header-content">
            <div class="avatar-wrapper" onclick="document.getElementById('uploadProfile').click();">
                <img src="{{ $user->profilePicture() }}" alt="Photo de profil" class="profile-avatar">
                <div class="avatar-overlay">
                    <i class="fas fa-camera"></i>
                    <span>Changer</span>
                </div>
            </div>
            <div class="user-meta">
                <h1>{{ $user->prenom }} {{ $user->nom }}</h1>
                <p class="user-email"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="profile-grid">
        <!-- Info Section -->
        <div class="glass-card info-card">
            <div class="card-header">
                <i class="fas fa-user-circle"></i>
                <h2>Informations</h2>
            </div>
            <div class="info-list">
                <div class="info-row">
                    <span class="label">Nom</span>
                    <span class="value">{{ $user->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Prénom</span>
                    <span class="value">{{ $user->prenom }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Email</span>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Membre depuis</span>
                    <span class="value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        @php
            $totalTaches = count($user->tache);
            $termines = count($user->tache->where('etat', 'termine'));
            $pourcentage = $totalTaches > 0 ? round(($termines / $totalTaches) * 100) : 0;
        @endphp
        <div class="glass-card progress-card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i>
                <h2>Productivité</h2>
            </div>
            <div class="progress-container">
                <div class="circular-progress" style="--percent: {{ $pourcentage }};">
                    <div class="inner-circle">
                        <span class="percentage">{{ $pourcentage }}%</span>
                        <span class="subtext">Terminé</span>
                    </div>
                </div>
                <div class="progress-stats">
                    <div class="stat-mini">
                        <span class="stat-count">{{ $termines }}</span>
                        <span class="stat-label">Terminées</span>
                    </div>
                    <div class="stat-mini">
                        <span class="stat-count">{{ $totalTaches }}</span>
                        <span class="stat-label">Total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon"><i class="fas fa-tasks"></i></div>
            <div class="stat-info">
                <h3>Total</h3>
                <p>{{ count($user->tache) }}</p>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <h3>Terminées</h3>
                <p>{{ count($user->tache->where('etat', 'termine')) }}</p>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <h3>En cours</h3>
                <p>{{ count($user->tache->where('etat', 'en_cours')) }}</p>
            </div>
        </div>
        <div class="stat-card purple">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-info">
                <h3>À faire</h3>
                <p>{{ count($user->tache->where('etat', 'planifie')) }}</p>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-icon"><i class="fas fa-fire"></i></div>
            <div class="stat-info">
                <h3>Nouvelles</h3>
                <p>{{ count($user->tache->where('etat', 'nouveau')) }}</p>
            </div>
        </div>
        <div class="stat-card indigo">
            <div class="stat-icon"><i class="fas fa-users-cog"></i></div>
            <div class="stat-info">
                <h3>Groupes</h3>
                <p>{{ count($user->groupe) }}</p>
            </div>
        </div>
    </div>
</div>

<form id="uploadForm" action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="file" id="uploadProfile" name="photo" accept="image/*" style="display: none;" onchange="this.form.submit();">
</form>
@endsection