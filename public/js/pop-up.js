
document.addEventListener('DOMContentLoaded', function () {
    const popUpGroupe = document.getElementById('pop-upGroupe');
    const overlay     = document.getElementById('overlay');
    popUpGroupe.classList.add('hidden');
    const boutonOpen  = document.querySelector('#NewGroupe');
    const boutonClose = document.querySelector('#close-popUp');
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