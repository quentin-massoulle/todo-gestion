@extends('admin-layout')

@section('title')
Gestion des {{ __('admin.users.title') }}
@endsection

@section('style')
<style> [x-cloak] { display: none !important; } </style>
@endsection

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto" x-data="{
    search: '',
    hasResults() {
        return Array.from(document.querySelectorAll('.user-row')).some(el => !el.classList.contains('hidden'));
    }
}">

    {{-- Header --}}
    <div class="flex flex-col mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 gap-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 w-full">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ __('admin.users.title') }}</h1>
                    <p class="text-sm text-gray-400 font-medium">{{ $users->count() }} {{ trans_choice('admin.users.total_members', $users->count()) }} {{ __('admin.users.total') }}</p>
                </div>
            </div>
        </div>

        {{-- Barre de recherche live (Alpine.js) --}}
        <div class="pt-4 border-t border-gray-50">
            <div class="relative w-full">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    x-model="search"
                    placeholder="{{ __('admin.users.search_placeholder') }}"
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none shadow-sm"
                >
            </div>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-100 text-red-600 text-sm font-semibold px-4 py-3 rounded-xl">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Liste --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50">
            <h2 class="text-sm font-black text-gray-500 uppercase tracking-widest">{{ __('admin.users.list_title') }}</h2>
        </div>

        <div class="divide-y divide-gray-50">
            @forelse($users as $user)
            <div class="user-row flex items-center gap-4 px-6 py-4 hover:bg-gray-50/50 transition-colors"
                 x-show="search === '' || '{{ strtolower($user->prenom . ' ' . $user->nom . ' ' . $user->email) }}'.includes(search.toLowerCase())"
                 x-transition.opacity>

                {{-- Avatar --}}
                <img src="{{ $user->profilePicture() }}" alt="{{ $user->prenom }}"
                     class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-sm shrink-0">

                {{-- Infos --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 leading-tight">
                        {{ $user->prenom }} {{ $user->nom }}
                    </p>
                    <p class="text-xs text-gray-400 font-medium truncate">{{ $user->email }}</p>
                </div>

                {{-- Rôle --}}
                <div class="shrink-0">
                    @if($user->isAdmin())
                        <span class="text-[10px] font-black bg-violet-100 text-violet-600 px-2.5 py-1 rounded-full uppercase tracking-tight">{{ __('admin.users.admin') }}</span>
                    @else
                        <span class="text-[10px] font-black bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full uppercase tracking-tight">{{ __('admin.users.member') }}</span>
                    @endif
                </div>

                {{-- Date inscription --}}
                <div class="shrink-0 hidden sm:block text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ __('admin.users.registered_on') }}</p>
                    <p class="text-xs font-semibold text-gray-600">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>

                {{-- Nb tâches --}}
                <div class="shrink-0 hidden md:block text-center">
                    <p class="text-lg font-black text-gray-900 leading-none">{{ $user->tache->count() }}</p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tight">{{ __('admin.users.tasks') }}</p>
                </div>

                {{-- Supprimer --}}
                <form action="{{ route('axe.users.destroy', $user) }}" method="POST" class="shrink-0"
                      x-data
                      @submit.prevent="if(confirm('{{ __('admin.users.delete_confirm', ['name' => $user->prenom . ' ' . $user->nom]) }}')) $el.submit()">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-600 text-xs font-bold rounded-lg transition-all border border-red-100 hover:border-red-200 active:scale-95">
                        <i class="fas fa-trash-can text-xs"></i>
                        {{ __('admin.users.delete') }}
                    </button>
                </form>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <i class="fas fa-user-slash text-3xl text-gray-200 mb-3"></i>
                <p class="text-gray-400 text-sm font-medium">{{ __('admin.users.no_user_found') }}</p>
            </div>
            @endforelse
        </div>

        {{-- Message aucun résultat (live) --}}
        <div x-cloak
             x-show="search !== '' && document.querySelectorAll('.user-row[style*=\'display: none\']').length === {{ $users->count() }}"
             class="px-6 py-12 text-center border-t border-gray-50">
            <i class="fas fa-search text-3xl text-gray-200 mb-3 block"></i>
            <p class="text-gray-400 text-sm font-medium">
                {{ __('admin.users.no_match') }} "<span x-text="search"></span>"
            </p>
        </div>
    </div>

</div>
@endsection
