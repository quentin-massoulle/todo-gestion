@extends('layout.layoutUser')

@section('content')
<section class="hero">
    <div class=" mx-auto">
      <h2 class="text-4xl font-semibold mb-4">{{ __('user.dashboard.wellcom')}}  {{ Auth::user()->name }}</h2>
      <p class="text-lg mb-6">Gérez vos tâches quotidiennes et suivez vos finances en toute simplicité.</p>
    </div>
</section>



@endsection