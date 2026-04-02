@extends(str_contains(url()->previous(), '/axe') ? 'admin-layout' : 'layout')
@section('content')
@vite('resources/js/app.js')
@section('title', 'Dashboard ' . $groupe->nom)

@section('style')
  <link rel="stylesheet" href="{{ asset('css/showGroupe.css')}}">
  <link rel="stylesheet" href="{{ asset('css/Tache.css')}}">
  <link rel="stylesheet" href="{{ asset('css/message.css')}}">
  <link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
  <style>
    [x-cloak] { display: none !important; }
    .chat-popup {
      position: fixed;
      bottom: 90px;
      right: 24px;
      width: 380px;
      max-height: 550px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.15);
      display: flex;
      flex-direction: column;
      z-index: 1000;
      overflow: hidden;
      border: 1px solid #f3f4f6;
    }
    .chat-header {
      padding: 16px 20px;
      background: #4f46e5;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
    }
    .chat-body {
      flex: 1;
      overflow-y: auto;
      padding: 0;
      background: #f9fafb;
    }
    .chat-fab {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: #4f46e5;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
      cursor: pointer;
      z-index: 1000;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .chat-fab:hover {
      transform: scale(1.05) translateY(-2px);
      box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }
    .chart-container {
      position: relative;
      margin: auto;
      height: 100%;
      width: 100%;
    }
    /* Override message box container for popup */
    .chat-popup .containeurDiscution {
        width: 100% !important;
        min-height: auto !important;
        max-height: none !important;
        border: none !important;
        border-radius: 0 !important;
    }
    .chat-popup .chat {
        height: 500px;
    }
  </style>
@endsection

@section('scripts')
  @vite('resources/js/chartGroupe.js')
@endsection

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto" x-data="{ chatOpen: false }">
  <!-- Header Section -->
<div class="flex flex-row justify-between items-center mb-8 gap-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex flex-col gap-1">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold text-xl">
          {{ substr($groupe->nom, 0, 1) }}
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $groupe->nom }}</h1>
      </div>
      <p class="text-gray-500 font-medium ml-13">Tableau de bord de votre équipe</p>
    </div>
    
    <div class="flex items-center gap-4">
      <form action="/groupe/{{$groupe->id}}" method="GET" class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200">
        @if (isset($periode) || true) {{-- Always show if we want modern look --}}
          <div class="flex items-center gap-2 px-2">
            <input type="date" value="{{$date_debut}}" name="date_debut" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer">
            <span class="text-gray-400 text-xs font-bold font-mono">→</span>
            <input type="date" name="date_fin" value="{{$date_fin}}" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 cursor-pointer">
          </div>
        @endif
        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-indigo-100 active:scale-95">
          <i class="fas fa-filter mr-2"></i> Afficher
        </button>
      </form>

      @if ($groupe->proprietaire_id === auth()->id() || str_contains(url()->previous(), '/axe') )
        <button id="gestionGroupe" class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-100 hover:border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-lg transition-all active:scale-95">
          <i class="fas fa-user-gear mr-2"></i> Paramètres
        </button>
      @endif
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content Area: Tasks and Charts -->
    <div class="lg:col-span-2 space-y-8">
      <!-- Tasks Control Card -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <span class="w-8 h-8 bg-indigo-50 text-indigo-500 rounded-lg flex items-center justify-center mr-3">
              <i class="fas fa-layer-group text-sm"></i>
            </span>
            Gestion des Tâches
          </h2>
          <button id="openTaskModal" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-100 active:scale-95">
            <i class="fas fa-plus-circle mr-2"></i> Nouveau Projet
          </button>
        </div>
        
        <div class="p-8">
          <div class="mb-10 text-center">
            <a href="{{ route('user.tasks')}}?groupe={{ $groupe->id }}" class="group inline-flex items-center px-10 py-6 bg-white border-2 border-indigo-50 hover:border-indigo-400 rounded-3xl transition-all shadow-sm hover:shadow-xl group">
              <div class="w-14 h-14 bg-indigo-50 group-hover:bg-indigo-600 text-indigo-600 group-hover:text-white rounded-2xl flex items-center justify-center mr-6 transition-all duration-300 transform group-hover:rotate-12">
                <i class="fas fa-columns text-2xl"></i>
              </div>
              <div class="flex flex-col text-left">
                <span class="text-xl font-black text-gray-900 leading-tight">Accéder au Kanban</span>
                <span class="text-sm text-gray-400 font-medium tracking-tight">Gérez les missions de l'équipe</span>
              </div>
              <i class="fas fa-arrow-right ml-8 text-gray-200 group-hover:text-indigo-500 group-hover:translate-x-2 transition-all"></i>
            </a>
          </div>

          <!-- Performance Chart - Compact Size -->
          <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 relative overflow-hidden max-w-[280px] max-h-[300px] mx-auto shadow-inner">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 text-center">Progression</h3>
            <div class="h-32 chart-container">
              <canvas id="tachesChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar: Stats and Team -->
    <div class="space-y-8">
        <!-- Stats Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-md font-bold text-gray-900 mb-4 tracking-tight">Aperçu rapide</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 text-center">
                    <span class="block text-lg font-black text-gray-900 leading-none">{{ $tache->count() }}</span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tight">Missions</span>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-center">
                    <span class="block text-lg font-black text-emerald-600 leading-none">{{ $tache->where('etat', 'termine')->count() }}</span>
                    <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-tight">Terminées</span>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl border border-blue-100 text-center">
                    <span class="block text-lg font-black text-blue-600 leading-none">{{ $tache->where('etat', 'en_cours')->count() }}</span>
                    <span class="text-[9px] font-bold text-blue-400 uppercase tracking-tight">En cours</span>
                </div>
                @php
                    $retardCount = $tache->where('deadline', '<', now())->where('etat', '!=', 'termine')->count();
                @endphp
                <div class="p-3 {{ $retardCount > 0 ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-100' }} rounded-xl border text-center">
                    <span class="block text-lg font-black {{ $retardCount > 0 ? 'text-red-600' : 'text-gray-900' }} leading-none">{{ $retardCount }}</span>
                    <span class="text-[9px] font-bold {{ $retardCount > 0 ? 'text-red-400' : 'text-gray-400' }} uppercase tracking-tight">En retard</span>
                </div>
            </div>

            <!-- Task Completion Bar -->
            <div class="mt-8">
                <div class="flex justify-between items-end mb-2">
                    <span class="text-sm font-bold text-gray-700">Objectifs atteints</span>
                    @php
                        $total = $tache->count();
                        $percent = $total > 0 ? round(($tache->where('etat', 'termine')->count() / $total) * 100) : 0;
                    @endphp
                    <span class="text-lg font-black text-indigo-600">{{ $percent }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3">
                    <div class="bg-indigo-600 h-3 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                </div>
            </div>
        </div>

        <!-- Team Members Brief -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-md font-bold text-gray-900 mb-5 flex justify-between items-center tracking-tight">
                Membres
                <span class="text-[10px] bg-gray-50 text-gray-400 px-2 py-0.5 rounded-md font-black border border-gray-100">{{ $groupe->users->count() }}</span>
            </h3>
            <div class="flex flex-col gap-3.5">
                @foreach($groupe->users->take(5) as $u)
                <div class="flex items-center gap-2.5">
                    <img src="{{ $u->profilePicture() }}" class="w-8 h-8 rounded-full object-cover border border-white shadow-sm" alt="">
                    <div class="flex flex-col">
                        <span class="text-[13px] font-bold text-gray-800 leading-tight">{{ $u->prenom }} {{ $u->nom }}</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tight">{{ $u->id === $groupe->proprietaire_id ? 'Admin' : 'Membre' }}</span>
                    </div>
                </div>
                @endforeach
                @if($groupe->users->count() > 5)
                    <button class="text-[11px] font-bold text-indigo-500 mt-1 hover:text-indigo-700 transition-colors">+ {{ $groupe->users->count() - 5 }} autres membres</button>
                @endif
            </div>
        </div>
    </div>
  </div>

  <!-- Chat Popup -->
  <div id="chat-popup" class="chat-popup hidden">
    <div class="chat-header" id="close-chat">
      <div class="flex items-center gap-2">
          <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
          <h3 class="font-black text-sm uppercase tracking-widest">Chat d'équipe</h3>
      </div>
      <button class="hover:bg-white/20 p-1 rounded transition-colors">
        <i class="fas fa-chevron-down text-xs"></i>
      </button>
    </div>
    <div class="chat-body" id="chat-container">
      @include('message.messageBox', ['groupe' => $groupe, 'messages' => $messages])
    </div>
  </div>

  <!-- Chat FAB -->
  <div class="chat-fab" id="chat-fab">
    <div class="relative" id="chat-icon-open">
        <i class="fas fa-comment-dots text-2xl"></i>
    </div>
    <i class="fas fa-times text-2xl hidden" id="chat-icon-close"></i>
  </div>
</div>

@include('task.taskFormModal')

@section('script')    
  <script>
     window.tachesData = {
        nouveau: {{ $tache->where('etat', 'nouveau')->count() }},
        planifie: {{ $tache->where('etat', 'planifie')->count() }},
        en_cours: {{ $tache->where('etat', 'en_cours')->count() }},
        termine: {{ $tache->where('etat', 'termine')->count() }}
    };

    window.urlPost = '/message/addMessage';
    window.urlGet  = '/message/getMessage';

    document.addEventListener('DOMContentLoaded', function() {
        const fab = document.getElementById('chat-fab');
        const popup = document.getElementById('chat-popup');
        const iconOpen = document.getElementById('chat-icon-open');
        const iconClose = document.getElementById('chat-icon-close');
        const closeBtn = document.getElementById('close-chat');

        if (fab && popup) {
            fab.addEventListener('click', function() {
                const isHidden = popup.classList.contains('hidden');
                if (isHidden) {
                    popup.classList.remove('hidden');
                    iconOpen.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                } else {
                    popup.classList.add('hidden');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });
        }

        if (closeBtn && popup) {
          closeBtn.addEventListener('click', function() {
            popup.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
          });
        }
    });
  </script>
  <script src="{{ asset('js/pop-up.js') }}" defer></script>
  <script src="{{ asset('js/message.js') }}" type="module"></script>
@endsection

@extends('pop-up.gestionGroupe')

@endsection
