
document.addEventListener('DOMContentLoaded', function () {
    const popUpGroupe = document.getElementById('pop-upGroupe');
    const overlay     = document.getElementById('overlay');
    const IdGroupe   = document.getElementById('idGroupe');
    popUpGroupe.classList.add('hidden');
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
    const groupNameInput = form.querySelector('input[name="NameGroupe"]');
    const groupMembersSelect = form.querySelector('select[name="SelectGroupe[]"]');

    form.addEventListener("submit", function (event) {
      if (!groupNameInput.value.trim()) {
        groupNameInput.classList.add("required")
        event.preventDefault(); 
      }

      if ([...groupMembersSelect.selectedOptions].length === 0) {
        groupMembersSelect.classList.add("required")
        event.preventDefault();
      }

    });
});