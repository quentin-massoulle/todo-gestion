
<div class=" containeurDiscution">
    <div class="chat">
        <div class="message-box">
            <form id="message-form" method="POST">
                @csrf
                <input type="hidden" name="groupe" value="{{ $groupe->id ?? '' }}">

                <textarea class="message-input" name="message" placeholder="{{ __('groupe.enter_message') }}"></textarea>
                <button class="message-button" type="submit">{{ __('groupe.send') }}</button>
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
