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
        <h2 class="text-4xl font-semibold mb-4">{{__('groupe.manage_group')}}</h2>
        <div class="containeur">
            <div class="containeurIner containeurTask">
                <div class='listeTache'> 
                  <h1 class ='text-3xl font-semibold mb-4 '>
                      Tache du groupe
                  </h1>
                  <p>nb tâches en nouveau   : {{ $groupe->tache->where('etat', 'nouveau')->count() }}</p>
                  <p>nb tâches en planifier : {{ $groupe->tache->where('etat', 'planifie')->count() }}</p>
                  <p>nb tâches en cours     : {{ $groupe->tache->where('etat', 'en_cours')->count() }}</p>
                  <p>nb tâches en terminer  : {{ $groupe->tache->where('etat', 'termine')->count() }}</p>
                </div>
                <div class='graphes' >
                  <canvas id="tachesChart" width="100%" height="100%"></canvas>
                </div>
            </div>
            <div class="containeurIner containeurDiscution">
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
        nouveau: {{ $groupe->tache->where('etat', 'nouveau')->count() }},
        planifie: {{ $groupe->tache->where('etat', 'planifie')->count() }},
        en_cours: {{ $groupe->tache->where('etat', 'en_cours')->count() }},
        termine: {{ $groupe->tache->where('etat', 'termine')->count() }}
    };

    window.urlPost = '/message/addMessageGroupe';
    window.urlGet  = '/message/getMessageGroupe';
  </script>

  <script src="{{ asset('js/message.js') }}" defer></script>
@endsection

