
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


    
});






