<div class="overlay hidden" id="overlay-task"></div>

<div class="pop-up hidden" id="pop-upTask">
    <button class="close" id="close-taskPopUp">X</button>

    <div class="popup-content">
        <h2 class="text-xl font-bold mb-6 text-center text-gray-800" id="taskModalTitle">Nouvelle Tâche</h2>

        <form method="POST" action="{{ route('tache.store') }}" class="modern-form" id="taskForm">
            @csrf
            @if(isset($groupe) && is_object($groupe))<input type="hidden" name="groupe" id="modalGroupeId" value="{{ is_object($groupe) ? $groupe->id : $groupe }}">
            @endif
            <input type="hidden" name="TaskId" id="modalTaskId" value="">

            <div class="form-group">
                <label>{{ __('task.titre') }}</label>
                <input type="text" name="titre" id="modalTitre" required placeholder="Titre de la mission">
            </div>

            @if(isset($groupe) && is_object($groupe))
            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> {{ __('task.responsable') }}</label>
                <select name="user_id" id="modalUserId" class="modern-input">
                    @foreach($groupe->users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->nom }} {{ $user->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group">
                <label>{{ __('task.description') }}</label>
                <textarea name="description" id="modalDescription" placeholder="Description détaillée..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fa-regular fa-calendar"></i> {{ __('task.date_debut') }}</label>
                    <input type="date" name="date_debut" id="modalDateDebut" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-calendar-check"></i> {{ __('task.date_fin') }}</label>
                    <input type="date" name="date_fin" id="modalDateFin" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
            </div>

            <div class="notification-card">
                <div class="notif-info">
                    <div class="notif-icon"><i class="fa-solid fa-bell"></i></div>
                    <div style="display: flex; flex-direction: row; gap: 10px;">
                        <strong>Notification</strong>
                        <span>Activer les rappels automatiques</span>
                    </div>
                </div>
                <label class="switch">
                    <input type="checkbox" name="rappel_active" id="modal_rappel_active">
                    <span class="slider"></span>
                </label>
            </div>

            <div id="modal-rappel-options" class="space-y-4 mb-6 hidden">
                <div class="form-row">
                    <div class="form-group">
                        <label for="frequence">{{ __('task.frequence_du_rappel') }}</label>
                        <select name="frequence" id="modalFrequence" class="modern-input">
                            <option value="une_fois">Une seule fois</option>
                            <option value="quotidien">Tous les jours</option>
                            <option value="hebdomadaire">Chaque semaine</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_rappel">{{ __('task.date_du_rappel') }}</label>
                        <input type="date" name="date_rappel_solo" id="modalDateRappel" class="modern-input">
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn" style="width: 100%; justify-content: center;">
                <i class="fa-solid fa-paper-plane"></i> {{ __('task.enregistrer_la_tache') }}
            </button>
        </form>
    </div>
</div>
