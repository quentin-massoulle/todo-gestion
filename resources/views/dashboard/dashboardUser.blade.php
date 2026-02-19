@extends('layout')
@section('title')
  dashboard
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

<section id="tasks" class="task-container">
  <h2 class="text-3xl font-semibold mb-4">
      {{__('dashBoard.acceder_taches')}} </h2>    
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="card">
      <h3 class="text-xl font-semibold mb-4">
          <i class="fas fa-list mr-2"></i>
      </h3>
      <p >{{__('dashBoard.creer_listes')}}</p>
    </div>
    <div class="card">
      <h3 class="text-xl font-semibold mb-4">
          <i class="fas fa-chart-line mr-2"></i>
      </h3>        
      <p>{{__('dashBoard.suivre_avancement')}}</p>
    </div>
    <div class="card">
      <h3 class="text-xl font-semibold mb-4">
          <i class="fas fa-bell mr-2"></i>
      </h3>        
      <p >{{__('dashBoard.recevoir_notifications')}}</p>
    </div>
  </div>
    <div class="btn">
      <a href="/">{{ __('layout.taches')}}</a>
    </div>
</section>


@endsection