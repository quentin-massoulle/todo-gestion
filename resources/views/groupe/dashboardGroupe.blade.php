@extends('layout.layoutUser')

@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardGroupe.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
@endsection

@section('content')
<section class="hero">
    <div class="mx-auto">
        <h2 class="text-4xl font-semibold mb-4">{{__('groupe.welcome_groups') }}  {{ Auth::user()->nom }}</h2>
    </div>
    <button class="btn-popUp" id='NewGroupe'>
        cree un nouveau groupe
    </button>
</section>



<div class="container overflow-y-auto">
    @foreach($groupes as $groupe)
        <div class="etiquette">
            <h3 class="text-2xl font-bold mb-2">{{ $groupe->prenom }}</h3>
            <p class="text-gray-600 mb-4">{{__('groupe.group_users')}}</p>
            <ul>
                @foreach($groupe->users as $user)
                    <li>{{ $user->prenom }} {{$user->nom}}</li>
                @endforeach
            </ul>
            <div class="btn">
                <a href="/groupe/{{$groupe->id}}">{{ __('groupe.access_group') }}</a>
            </div>
        </div>
    @endforeach
</div>
@section('script')
    <script src="{{ asset('js/pop-up.js') }}"defer>
    </script>
@endsection

@extends('pop-up.creationGroupe')

@endsection
