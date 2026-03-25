
document.addEventListener('DOMContentLoaded', function () {
    const popUpGroupe = document.getElementById('pop-upGroupe');
    const overlay     = document.getElementById('overlay');
    const IdGroupe   = document.getElementById('idGroupe');
    if (popUpGroupe) popUpGroupe.classList.add('hidden');
    const boutonOpen  = document.querySelector('#gestionGroupe');
    const boutonClose = document.querySelector('#close-popUp');
    const boutonSupprimer = document.querySelector('#supprimerGroupe');
    if (boutonSupprimer) {
        boutonSupprimer.addEventListener('click', function() {
           Swal.fire({
            title: 'Confirmer ?',
            text: "Voulez-vous vraiment continuer ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non'
          }).then((result) => {
            if (result.isConfirmed) {
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = `/groupe/${IdGroupe.value}/delete`;
              const csrfInput = document.createElement('input');
              csrfInput.type = 'hidden';
              csrfInput.name = '_token';
              csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
              form.appendChild(csrfInput);
              document.body.appendChild(form);
              form.submit();
            }
          });
        });
    }
    if (boutonOpen) {
        boutonOpen.addEventListener('click', function() {
        popUpGroupe.classList.remove('hidden')
        overlay.classList.remove('hidden') 
    });
    }
    if (boutonClose) {
        boutonClose.addEventListener('click', function() {
        popUpGroupe.classList.add('hidden')
        overlay.classList.add('hidden') 
    });
    }

    const form = document.querySelector('form[action="/groupe/store"]');
    if (form) {
        const groupNameInput = form.querySelector('input[name="NameGroupe"]');
        const groupMembersSelect = form.querySelector('select[name="SelectGroupe[]"]');

        form.addEventListener("submit", function (event) {
            if (groupNameInput && !groupNameInput.value.trim()) {
                groupNameInput.classList.add("required");
                event.preventDefault(); 
            }

            if (groupMembersSelect && [...groupMembersSelect.selectedOptions].length === 0) {
                groupMembersSelect.classList.add("required");
                event.preventDefault();
            }
        });
    }

    // Logic for Task Modal
    const popUpTask = document.getElementById('pop-upTask');
    const overlayTask = document.getElementById('overlay-task');
    const boutonOpenTask = document.querySelector('#openTaskModal');
    const boutonCloseTask = document.querySelector('#close-taskPopUp');

    if (popUpTask) popUpTask.classList.add('hidden'); // Ensure hidden initially

    if (boutonOpenTask && popUpTask) {
        boutonOpenTask.addEventListener('click', function() {
            // Reset modal for New Task
            document.getElementById('taskModalTitle').innerText = 'Nouvelle Tâche';
            document.getElementById('modalTaskId').value = '';
            document.getElementById('taskForm').reset();
            if (document.getElementById('modal-rappel-options')) {
                document.getElementById('modal-rappel-options').classList.add('hidden');
            }
            
            popUpTask.classList.remove('hidden');
            if (overlayTask) overlayTask.classList.remove('hidden');
        });
    }

    // Logic for Edit Task buttons
    const editBtns = document.querySelectorAll('.editTaskBtn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const titre = this.getAttribute('data-titre');
            const desc = this.getAttribute('data-description');
            const debut = this.getAttribute('data-debut');
            const fin = this.getAttribute('data-fin');
            const rappel = this.getAttribute('data-rappel-active');
            const rDate = this.getAttribute('data-rappel-date');
            const rFreq = this.getAttribute('data-rappel-frequence');

            document.getElementById('taskModalTitle').innerText = 'Modifier la tâche';
            document.getElementById('modalTaskId').value = id;
            document.getElementById('modalTitre').value = titre;
            document.getElementById('modalDescription').value = desc;
            document.getElementById('modalDateDebut').value = debut;
            document.getElementById('modalDateFin').value = fin;

            const checkbox = document.getElementById('modal_rappel_active');
            const options = document.getElementById('modal-rappel-options');
            if (rappel === '1') {
                checkbox.checked = true;
                options.classList.remove('hidden');
                document.getElementById('modalFrequence').value = rFreq;
                document.getElementById('modalDateRappel').value = rDate;
            } else {
                checkbox.checked = false;
                options.classList.add('hidden');
            }

            popUpTask.classList.remove('hidden');
            if (overlayTask) overlayTask.classList.remove('hidden');
        });
    });

    if (boutonCloseTask && popUpTask) {
        boutonCloseTask.addEventListener('click', function() {
            popUpTask.classList.add('hidden');
            if (overlayTask) overlayTask.classList.add('hidden');
        });
    }

    const rappelCheckbox = document.getElementById('modal_rappel_active');
    const rappelOptions = document.getElementById('modal-rappel-options');
    if (rappelCheckbox && rappelOptions) {
        rappelCheckbox.addEventListener('change', function() {
            if (this.checked) {
                rappelOptions.classList.remove('hidden');
            } else {
                rappelOptions.classList.add('hidden');
            }
        });
    }
});