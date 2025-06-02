@extends('layout.layoutUser')

@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/showGroupe.css')}}">
@endsection

@section('content')
        <h2 class="text-4xl font-semibold mb-4">{{__('groupe.manage_group')}}</h2>
        <div class="containeur">
            <div class="containeurIner containeurTask">

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
    <script src="{{ asset('js/messageSend.js') }}"defer>
    </script>
@endsection

