@extends('layout.layoutUser')
@section('title')
  <title>dashboard</title>
@endsection
@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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