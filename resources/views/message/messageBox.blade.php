<div class="chat flex flex-col h-full bg-slate-50 overflow-hidden">
    <!-- Messages Channel -->
    <div class="message-channel flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar" id="message-container">
        @if ($messages && $messages->count())
            @foreach ($messages as $message)
                @php
                    $isOwnMessage = auth()->id() === $message->user_id;
                @endphp
            
                <div class="flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }} group">
                    <div class="max-w-[85%] flex flex-col {{ $isOwnMessage ? 'items-end' : 'items-start' }}">
                        @if (!$isOwnMessage)
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 ml-2">
                                {{ $message->user->prenom ?? 'Utilisateur' }}
                            </span>
                        @endif
                        <div class="px-4 py-2.5 rounded-2xl shadow-sm text-sm {{ $isOwnMessage ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none' }}">
                            {{ $message->contenu }}
                        </div>
                        <span class="text-[9px] text-gray-400 mt-1 {{ $isOwnMessage ? 'mr-1' : 'ml-1' }}">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-messages flex flex-col items-center justify-center h-full text-gray-400 space-y-2">
                <i class="fas fa-comments text-3xl opacity-20"></i>
                <p class="text-xs font-medium italic">Aucun message pour l’instant.</p>
            </div>
        @endif
    </div>

    <!-- Message Input Box -->
    <div class="p-4 bg-white border-t border-gray-100">
        <form id="message-form" class="relative flex items-center gap-2">
            @csrf
            <input type="hidden" name="groupe" value="{{ $groupe->id ?? '' }}">
            <textarea 
                class="message-input flex-1 bg-gray-50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-indigo-500/20 transition-all resize-none max-h-32" 
                name="message" 
                placeholder="Votre message..."
                rows="1"
            ></textarea>
            <button 
                class="message-button shrink-0 w-10 h-10 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-100 flex items-center justify-center transition-all active:scale-95" 
                type="submit"
            >
                <i class="fas fa-paper-plane text-xs"></i>
            </button>
        </form>
    </div>
</div>
