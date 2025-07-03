@extends('layout.layoutUser')
@vite('resources/js/app.js')
@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/showGroupe.css')}}">
  <link rel="stylesheet" href="{{ asset('css/pop-up.css') }}">
@endsection

@section('scripts')
  @vite('resources/js/chartGroupe.js')
@endsection


@section('content')
<div class="containeurHeader">
  <form action="/groupe/{{$groupe->id}}" method="GET">
    @if (isset($periode))
      <H1 class ='text-3xl font-semibold mb-4 '>periode du <input type='date' value ="{{$date_depart}}" name = "date_depart"> au <input type="date" name = "date_fin" value="{{$date_fin}}"></H1>
    @endif
    <button type="submit" class="Btn-form"> rechercher </button>
  </form>
  @if ($groupe->proprietaire_id === auth()->id())
    <button class="Btn-form" style="width: 250px" id='gestionGroupe'>gérer le groupe</button>
  @endif
</div>
  <div class="containeur">
      <div class=" containeurTask">
        <h1 class ='text-3xl font-semibold mb-4 '>
          Tache du groupe
        </h1>
        <div class="containeurIner">
              <a href="{{ route('user.task.show', ['id' => 0]) }}?groupe={{ $groupe->id }}"><button class="Btn-form" style="width: 250px">
              cree une nouvelle tache
        </button></a>
        <a href="{{ route('user.tasks')}}?groupe={{ $groupe->id }}"><button class="Btn-form" style="width: 250px">
                acceder au kanban
        </button></a>
        <br>
        </div>
        <div class=tache-decriptif>
          <div class='graphes' >
            <canvas id="tachesChart" width="50%" height="50%"></canvas>
          </div>
        </div>
        
      </div>
      <div class=" containeurDiscution">
          <div class="chat">
            <div class="message-box">
              <form id="message-form">
                @csrf
                <input type="hidden" name="groupe" value="{{ $groupe->id }}">
                <textarea name="message" placeholder="{{ __('groupe.enter_message') }}"></textarea>
                <button type="submit">{{ __('groupe.send') }}</button>
            </form>
            </div>
            <div class="message-channel">
              @if ($messages && $messages->count())
                @foreach ($messages as $message)
                  @php
                      $isOwnMessage = auth()->id() === $message->user_id;
                  @endphp
              
                  <div class="message {{ $isOwnMessage ? 'own-message' : 'other-message' }}">
                      <div class="message-meta">
                          <span class="user-name">
                              {{ $isOwnMessage ? 'Moi' : ($message->user->prenom ?? 'Utilisateur') }}
                          </span>
                          <span class="message-time">{{ $message->created_at->diffForHumans() }}</span>
                      </div>
                      <div class="message-content">
                          {{ $message->contenu }}
                      </div>
                  </div>
                @endforeach
              @else
                  <div class="no-messages">Aucun message pour l’instant.</div>
              @endif
            </div>
          
          </div>
      </div>
  </div>


@section('script')    
  <script>
     window.tachesData = {
        nouveau: {{ $tache->where('etat', 'nouveau')->count() }},
        planifie: {{ $tache->where('etat', 'planifie')->count() }},
        en_cours: {{ $tache->where('etat', 'en_cours')->count() }},
        termine: {{ $tache->where('etat', 'termine')->count() }}
    };

    window.urlPost = '/message/addMessageGroupe';
    window.urlGet  = '/message/getMessageGroupe';
  </script>
  <script  src="{{ asset('js/pop-up.js') }}" defer></script>
  <script  src="{{ asset('js/message.js') }}" defer></script>
@endsection


@extends('pop-up.gestionGroupe')

@endsection
