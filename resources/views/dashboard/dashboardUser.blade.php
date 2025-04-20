@extends('layout.layoutUser')
@section('title')
  <title>dashboard</title>
@endsection
@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
<section class="hero">
    <div class=" mx-auto">
      <h2 class="text-4xl font-semibold mb-4">{{ __('user.dashboard.wellcom')}}  {{ Auth::user()->name }}</h2>
    </div>
</section>

<section id="tasks" class="py-16 text-center bg-[#4F96FF] bg-opacity-40">
  <h2 class="text-3xl font-semibold mb-4">
      acceder a vos tache 
  </h2>    
  <p>truc</p>
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
      <p>Suivez l'avancement de vos tâches, marquez-les comme terminées et célébrez chaque petite victoire !</p>
    </div>
    <div class="card bg-[#61D0A7]">
      <h3 class="text-xl font-semibold mb-4">
          <i class="fas fa-bell mr-2"></i>
      </h3>        
      <p >Recevez des notifications pour ne jamais oublier une tâche importante et restez productif tout au long de la journée.</p>
    </div>
  </div>
    <div class="btn">
      <a href="/">{{ __('layout.taches')}}</a>
    </div>
</section>


@endsection