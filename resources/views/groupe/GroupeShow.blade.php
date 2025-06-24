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
@endsection

@section('scripts')
  @vite('resources/js/chartGroupe.js')
@endsection


@section('content')
      <form action="/groupe/{{$groupe->id}}" method="GET">
        @if (isset($periode))
          <H1 class ='text-3xl font-semibold mb-4 '>periode du <input type='date' value ="{{$date_depart}}" name = "date_depart"> au <input type="date" name = "date_fin" value="{{$date_fin}}"></H1>
        @endif
        <button type="submit" class="Btn-form"> rechercher </button>
      </form>
        <div class="containeur">
            <div class=" containeurTask">
              <h1 class ='text-3xl font-semibold mb-4 '>
                Tache du groupe
              </h1>
              <a href="/hahahahahahhaha"><button class="Btn-form" style="width: 250px">
                cree une nouvelle tache
              </button></a>
              <br>
              <div class=tache-decriptif>
                <div class="containeurIner">
                  <h1 class="text-xl ">
                    acceder au différante tache
                  </h1>
                    <p>
                      <a href="">acceder au tache {{__('task.etat.nouveau')}} ({{ $tache->where('etat', 'nouveau')->count()}})<br></a>
                      <a href="">acceder au tache {{__('task.etat.planifie')}} ({{ $tache->where('etat', 'planifie')->count() }})<br></a>
                      <a href="">acceder au tache {{__('task.etat.en_cours')}} ({{ $tache->where('etat', 'en_cours')->count() }})<br></a>
                      <a href="">acceder au tache {{__('task.etat.termine')}} ({{ $tache->where('etat', 'termine')->count() }})<br></a>
                    </p>
                </div>
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

@endsection


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

  <script src="{{ asset('js/message.js') }}" defer></script>
@endsection

