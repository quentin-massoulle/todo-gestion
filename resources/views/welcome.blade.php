@extends('layout')
@section('title')
    <title> todo gestion-acceuil</title>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection
@section('content')

  <section class="hero">
    <div class=" mx-auto">
      <h2 class="text-4xl font-semibold mb-4">Bienvenue sur TodoBudget</h2>
      <p class="text-lg mb-6">Gérez vos tâches quotidiennes et suivez vos finances en toute simplicité.</p>
      <a href="./login" class="btn-main">Se Connecter</a>
    </div>
  </section>

  <!-- Tâches Section -->
  <section id="tasks" class="py-16 text-center bg-[#4F96FF] bg-opacity-40">
    <h2 class="text-3xl font-semibold mb-4">
        Gérez vos Tâches Facilement
    </h2>    
    <p>Avec TodoGestion, vous pouvez facilement organiser vos tâches quotidiennes. Que ce soit pour le travail, les études ou la maison, ajoutez, suivez et accomplissez vos tâches en toute simplicité.</p>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-list mr-2"></i>
        </h3>
        <p >Créez des listes de tâches pour chaque aspect de votre vie. Priorisez, ajoutez des descriptions et des échéances pour ne rien oublier.</p>
      </div>
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-chart-line mr-2"></i>
        </h3>        
        <p >Suivez l'avancement de vos tâches, marquez-les comme terminées et célébrez chaque petite victoire !</p>
      </div>
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-bell mr-2"></i>
        </h3>        
        <p >Recevez des notifications pour ne jamais oublier une tâche importante et restez productif tout au long de la journée.</p>
      </div>
    </div>
</section>

  <!-- Budget Section -->
  <section id="budget" class="bg-[#F3F4F6] bg-opacity-40 py-16 text-center">
    <h2 class="text-3xl font-semibold mb-4">
        Suivi de Votre Budget
    </h2>
    <p>Gérer votre budget n'a jamais été aussi facile. TodoGestion vous aide à suivre vos revenus, vos dépenses et à garder un œil sur vos économies.</p>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-money-bill-wave mr-2"></i>
        </h3>        
        <p>Ajoutez vos sources de revenus et surveillez vos entrées d'argent facilement pour mieux gérer votre budget mensuel.</p>
      </div>
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-credit-card mr-2"></i>
        </h3>        
        <p>Ajoutez vos dépenses pour suivre où va votre argent. Gardez un œil sur votre budget pour éviter les mauvaises surprises.</p>
      </div>
    </div>
</section>

<!-- Stats Section -->
<section id="stats" class="py-16 text-center bg-[#4F96FF] bg-opacity-40 ">
    <h2 class="text-3xl font-semibold mb-4">
        Statistiques
    </h2>    
    <p>Gardez un œil sur vos progrès grâce aux statistiques en temps réel. Suivez l'achèvement de vos tâches, l'utilisation de votre budget et vos économies pour une gestion plus efficace de votre quotidien.</p>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-check-circle mr-2"></i>
        </h3>        
        <p>Gardez un historique de vos tâches terminées pour voir vos progrès au fil du temps.</p>
      </div>
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-wallet mr-2"></i>
        </h3>        
        <p>Suivez l'évolution de votre budget et la proportion de vos dépenses par rapport à vos revenus.</p>
      </div>
      <div class="card bg-[#61D0A7]">
        <h3 class="text-xl font-semibold mb-4">
            <i class="fas fa-piggy-bank mr-2"></i>
        </h3>
        
        <p>Consultez vos économies réalisées pour mieux planifier vos objectifs financiers.</p>
      </div>
    </div>
</section>


@endsection
