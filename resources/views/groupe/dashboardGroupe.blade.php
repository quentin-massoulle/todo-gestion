@extends('layout')

@section('title')
  Dashboard Groupe
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardGroupe.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex gap-4 items-center mb-10 ">
        <section class="hero flex-grow text-center !mb-0">
            <div class="w-full">
                <h2 class="text-2xl font-extrabold">{{__('groupe.welcome_groups') }}</h2>
            </div>
        </section>
        
        <button class="btn-popUp flex-shrink-0" id='gestionGroupe'>
            <i class="fa-solid fa-plus text-xs"></i> {{ __('groupe.create_new_group') }}
        </button>
    </div>

    <div class="custom-container">
        @foreach($groupes as $groupe)
            <div class="etiquette">
                <h1 class="text-xl font-bold text-slate-900 mb-1">{{ $groupe->nom }}</h1>
                
                <div class="member-count mb-4">
                    <i class="fa-solid fa-users"></i>
                    <span class="font-medium text-slate-500">
                        {{ $groupe->users->count() }} {{ trans_choice('groupe.members_count', $groupe->users->count()) }}
                    </span>
                </div>

                <a href="{{ route('groupe.show', $groupe->id) }}" class="btn-access">
                    <span>{{ __('groupe.access_group') }}</span>
                    <i class="fa-solid fa-arrow-right-long text-base"></i>
                </a>
            </div>
        @endforeach
    </div>
</div>


@section('script')
    <script src="{{ asset('js/pop-up.js') }}" defer></script>
@endsection

@extends('pop-up.gestionGroupe')

@endsection
