@extends('admin-layout')  
@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">


    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
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
        <form action="{{ route('axe.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200 w-full lg:w-auto">
          <div class="flex items-center gap-2 px-2">
            <input type="date" value="{{ $date_debut }}" name="date_debut" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer">
            <span class="text-gray-400 text-xs font-bold font-mono">→</span>
            <input type="date" name="date_fin" value="{{ $date_fin }}" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer">
          </div>
          <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-indigo-100 active:scale-95">
            <i class="fas fa-filter mr-2"></i> Filtrer
          </button>
        </form>

        <span class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-bold border border-indigo-100">
          <i class="fas fa-circle text-[6px] text-indigo-400 animate-pulse"></i>
          Admin
        </span>
      </div>
    </div>

    {{-- ===== KPI CARDS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      {{-- Utilisateurs --}}
      <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-start mb-4">
          <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
            <i class="fas fa-users text-sm"></i>
          </div>
          <span class="text-[10px] bg-blue-50 text-blue-500 font-bold px-2 py-0.5 rounded-full">TOTAL</span>
        </div>
        <p class="text-3xl font-black text-gray-900 leading-none mb-1">{{ $totalUsers }}</p>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Utilisateurs</p>
      </div>

      {{-- Tâches --}}
      <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-start mb-4">
          <div class="w-10 h-10 bg-violet-50 text-violet-500 rounded-xl flex items-center justify-center">
            <i class="fas fa-list-check text-sm"></i>
          </div>
          <span class="text-[10px] bg-violet-50 text-violet-500 font-bold px-2 py-0.5 rounded-full">TOTAL</span>
        </div>
        <p class="text-3xl font-black text-gray-900 leading-none mb-1">{{ $totalTaches }}</p>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tâches</p>
      </div>

      {{-- Groupes --}}
      <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-start mb-4">
          <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center">
            <i class="fas fa-layer-group text-sm"></i>
          </div>
          <span class="text-[10px] bg-emerald-50 text-emerald-500 font-bold px-2 py-0.5 rounded-full">TOTAL</span>
        </div>
        <p class="text-3xl font-black text-gray-900 leading-none mb-1">{{ $totalGroupes }}</p>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Groupes</p>
      </div>

      {{-- En retard --}}
      <div class="stat-card rounded-2xl p-5 border shadow-sm {{ $enRetard > 0 ? 'bg-red-50 border-red-100' : 'bg-white border-gray-100' }}">
        <div class="flex justify-between items-start mb-4">
          <div class="w-10 h-10 {{ $enRetard > 0 ? 'bg-red-100 text-red-500' : 'bg-gray-50 text-gray-400' }} rounded-xl flex items-center justify-center">
            <i class="fas fa-triangle-exclamation text-sm"></i>
          </div>
          @if($enRetard > 0)
          <span class="text-[10px] bg-red-100 text-red-500 font-bold px-2 py-0.5 rounded-full animate-pulse">ALERTE</span>
          @endif
        </div>
        <p class="text-3xl font-black {{ $enRetard > 0 ? 'text-red-600' : 'text-gray-900' }} leading-none mb-1">{{ $enRetard }}</p>
        <p class="text-xs font-bold {{ $enRetard > 0 ? 'text-red-400' : 'text-gray-400' }} uppercase tracking-widest">En retard</p>
      </div>
    </div>

    {{-- ===== MAIN CONTENT GRID ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- LEFT — Recent users + Recent tasks --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- Global Progress --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
          <h2 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-5">Progression globale de l'équipe</h2>
          <div class="flex flex-wrap gap-6 mb-6">
            <div class="flex flex-col">
              <span class="text-2xl font-black text-emerald-600">{{ $terminees }}</span>
              <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-tight">Terminées</span>
            </div>
            <div class="flex flex-col">
              <span class="text-2xl font-black text-blue-600">{{ $enCours }}</span>
              <span class="text-[10px] font-bold text-blue-400 uppercase tracking-tight">En cours</span>
            </div>
            <div class="flex flex-col">
              <span class="text-2xl font-black text-gray-900">{{ $totalTaches - $terminees - $enCours }}</span>
              <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">À faire</span>
            </div>
          </div>
          <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-violet-500 h-3 rounded-full progress-bar" style="width: {{ $completion }}%"></div>
          </div>
          <div class="flex justify-between mt-2">
            <span class="text-xs text-gray-400 font-medium">0%</span>
            <span class="text-sm font-black text-indigo-600">{{ $completion }}% complété</span>
            <span class="text-xs text-gray-400 font-medium">100%</span>
          </div>
        </div>

        {{-- Recent tasks --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-sm font-black text-gray-500 uppercase tracking-widest">Dernières tâches créées</h2>
            <span class="text-[10px] bg-gray-50 text-gray-400 px-2 py-0.5 rounded-md font-black border border-gray-100">5 récentes</span>
          </div>
          <div class="divide-y divide-gray-50">
            @forelse($recentTaches as $t)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/50 transition-colors">
              @php
                $colors = [
                  'nouveau'  => 'bg-gray-100 text-gray-600',
                  'planifie' => 'bg-blue-100 text-blue-600',
                  'en_cours' => 'bg-amber-100 text-amber-700',
                  'termine'  => 'bg-emerald-100 text-emerald-700',
                ];
                $color = $colors[$t->etat] ?? 'bg-gray-100 text-gray-600';
              @endphp
              <div class="w-9 h-9 rounded-xl {{ str_replace('text-', 'bg-', explode(' ', $color)[0]) }} bg-opacity-50 flex items-center justify-center shrink-0">
                <i class="fas fa-check-circle text-sm {{ explode(' ', $color)[1] }}"></i>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate">{{ $t->titre }}</p>
                <p class="text-[10px] text-gray-400 font-medium">
                  {{ $t->user?->prenom ?? '—' }} {{ $t->user?->nom ?? '' }} · {{ $t->created_at->diffForHumans() }}
                </p>
              </div>
              <span class="text-[10px] font-black px-2.5 py-1 rounded-full {{ $color }} shrink-0">
                {{ ucfirst(str_replace('_', ' ', $t->etat)) }}
              </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Aucune tâche pour l'instant.</div>
            @endforelse
          </div>
        </div>
      </div>

      {{-- RIGHT — Recent users --}}
      <div class="space-y-6">
        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
          <h2 class="text-sm font-black text-gray-500 uppercase tracking-widest mb-4">Actions rapides</h2>
          <div class="flex flex-col gap-2">
            <a href="{{ route('axe.groupes') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-colors group">
              <div class="w-8 h-8 bg-indigo-50 text-indigo-500 group-hover:bg-indigo-100 rounded-lg flex items-center justify-center transition-colors">
                <i class="fas fa-layer-group text-xs"></i>
              </div>
              <span class="text-sm font-bold text-gray-700 group-hover:text-indigo-700 transition-colors">Voir les groupes</span>
              <i class="fas fa-chevron-right text-[10px] text-gray-300 ml-auto group-hover:text-indigo-400 transition-colors"></i>
            </a>
            <a href="{{ route('user.tasks') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-violet-50 transition-colors group">
              <div class="w-8 h-8 bg-violet-50 text-violet-500 group-hover:bg-violet-100 rounded-lg flex items-center justify-center transition-colors">
                <i class="fas fa-list-check text-xs"></i>
              </div>
              <span class="text-sm font-bold text-gray-700 group-hover:text-violet-700 transition-colors">Voir les tâches</span>
              <i class="fas fa-chevron-right text-[10px] text-gray-300 ml-auto group-hover:text-violet-400 transition-colors"></i>
            </a>
          </div>
        </div>

        {{-- Recent users --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-gray-50">
            <h2 class="text-sm font-black text-gray-500 uppercase tracking-widest">Nouveaux membres</h2>
          </div>
          <div class="divide-y divide-gray-50">
            @forelse($recentUsers as $u)
            <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50/50 transition-colors">
              <img src="{{ $u->profilePicture() }}" class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" alt="">
              <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-800 leading-tight truncate">{{ $u->prenom }} {{ $u->nom }}</p>
                <p class="text-[10px] text-gray-400 truncate font-medium">{{ $u->email }}</p>
              </div>
              @if($u->is_admin === 'true')
              <span class="text-[9px] font-black bg-violet-100 text-violet-600 px-2 py-0.5 rounded-full uppercase tracking-tight">Admin</span>
              @else
              <span class="text-[9px] font-black bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full uppercase tracking-tight">User</span>
              @endif
            </div>
            @empty
            <div class="px-5 py-8 text-center text-gray-400 text-sm">Aucun utilisateur.</div>
            @endforelse
          </div>
          <div class="p-4 text-center border-t border-gray-50">
            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total · {{ $totalUsers }} utilisateurs</span>
          </div>
        </div>

        {{-- Task state breakdown --}}
        <div class="bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-100">
          <h2 class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-4">Répartition des tâches</h2>
          @php
            $states = [
              ['label' => 'Terminées', 'val' => $terminees, 'color' => 'bg-emerald-400'],
              ['label' => 'En cours', 'val' => $enCours, 'color' => 'bg-amber-400'],
              ['label' => 'En retard', 'val' => $enRetard, 'color' => 'bg-red-400'],
            ];
          @endphp
          <div class="space-y-3">
            @foreach($states as $state)
            @php $pct = $totalTaches > 0 ? round(($state['val'] / $totalTaches) * 100) : 0; @endphp
            <div>
              <div class="flex justify-between mb-1">
                <span class="text-xs font-bold opacity-80">{{ $state['label'] }}</span>
                <span class="text-xs font-black">{{ $pct }}%</span>
              </div>
              <div class="w-full bg-white/20 rounded-full h-1.5">
                <div class="{{ $state['color'] }} h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
