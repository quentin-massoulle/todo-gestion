@extends('layout.layoutUser')

@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
<section class="hero">
    <div class="mx-auto">
        <h2 class="text-4xl font-semibold mb-4">Bienvenue dans vos groupes {{ Auth::user()->nom }}</h2>
    </div>
</section>

<section id="groupes" class="py-16 text-center bg-blue-100">
    <h2 class="text-3xl font-semibold mb-4">Liste des groupes et utilisateurs</h2>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($groupes as $groupe)
            <div class="card bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-2xl font-bold mb-2">{{ $groupe->nom }}</h3>
                <p class="text-gray-600 mb-4">Utilisateurs du groupe :</p>
                <ul class="text-left list-disc list-inside">
                    @foreach($groupe->users as $user)
                        <li>{{ $user->nom }} {{$user->prenom}}</li>
                    @endforeach

                <button>
                    <i>
                        <a href="/groupe/{{$groupe->id}}"> acceder au groupe </a>
                    </i>
                </button>
                </ul>
            </div>
        @endforeach
    </div>
</section>
@endsection
