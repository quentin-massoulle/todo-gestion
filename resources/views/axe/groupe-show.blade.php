@extends('admin-layout')  

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardGroupe.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
@endsection



@section('content')

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
@endsection
