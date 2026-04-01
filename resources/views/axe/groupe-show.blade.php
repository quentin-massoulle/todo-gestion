@extends('admin-layout')  

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/dashboardGroupe.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
  <style> [x-cloak] { display: none !important; } </style>
@endsection

@section('content')

{{-- 1. On déplace le x-data tout en haut pour qu'il englobe TOUTE la page --}}
<div x-data="{ 
        search: '', 
        hasResults() {
            if (this.search === '') return true;
            let noms = Array.from(document.querySelectorAll('.etiquette h1')).map(h1 => h1.innerText.toLowerCase());
            return noms.some(nom => nom.includes(this.search.toLowerCase()));
        }
     }">

    {{-- HEADER --}}
    <div class="flex flex-col mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 gap-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 w-full">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 admin-badge rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100">
                    <i class="fas fa-shield-halved text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Administration</h1>
                    <p class="text-sm text-gray-400 font-medium">Tableau de bord · {{ now()->translatedFormat('l d F Y') }}</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                <form action="{{ route('axe.groupes') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200 w-full lg:w-auto">
                    <div class="flex items-center gap-2 px-2">
                        <input type="date"   value="{{ $date_debut }}" name="date_debut" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer">
                        <span class="text-gray-400 text-xs font-bold font-mono">→</span>
                        <input type="date"   value="{{ $date_fin }}" name="date_fin" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer">
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-indigo-100 active:scale-95">
                        <i class="fas fa-filter mr-2"></i> Filtrer
                    </button>
                </form>
            </div>
        </div>
        <div class="pt-4 border-t border-gray-50">
            <div class="relative w-full">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input 
                    type="text" 
                    x-model="search" 
                    placeholder="Rechercher un groupe parmi la liste ci-dessous..." 
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none shadow-sm"
                >
            </div>
        </div>
    </div>

    {{-- LISTE DES GROUPES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($groupes as $groupe)
            <div class="etiquette" 
                 x-show="'{{ addslashes(strtolower($groupe->nom)) }}'.includes(search.toLowerCase())"
                 x-transition.opacity>
                
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

    {{-- MESSAGE D'ERREUR --}}
    <div x-cloak 
        x-show="search !== '' && !hasResults()" 
        class="p-8 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 mt-4">
        
        <i class="fas fa-search text-gray-300 text-3xl mb-3 block"></i>
        
        <span class="text-gray-500 font-medium">
            Aucun groupe ne correspond à "<span x-text="search"></span>"
        </span>
    </div>

</div> {{-- Fin du x-data global --}}

@endsection