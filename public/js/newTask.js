document.addEventListener("DOMContentLoaded", function () {

    // Sélection des éléments du DOM
    const checkbox = document.getElementById('rappel_active');
    const frequenceContainer = document.getElementById('frequence-container');
    const frequenceSelect = document.getElementById('frequence');
    const dateContainerMultiple = document.getElementById('date-container-multiple');
    const dateContainerSolo = document.getElementById('date-container-solo');

    // Vérifier si tous les éléments existent
    if (!checkbox || !frequenceContainer || !frequenceSelect || !dateContainerMultiple || !dateContainerSolo) {
        console.error("Un ou plusieurs éléments sont manquants !");
        return;  // Arrêter l'exécution si un élément est manquant
    }

    // Gestion du changement d'état du checkbox
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            frequenceContainer.classList.remove('hidden');
            handleFrequencyChange();
        } else {
            frequenceContainer.classList.add('hidden');
            dateContainerSolo.classList.add('hidden');
            dateContainerMultiple.classList.add('hidden');
        }
    });

    // Gestion du changement de la fréquence
    frequenceSelect.addEventListener('change', handleFrequencyChange);

    // Fonction pour gérer le changement de fréquence
    function handleFrequencyChange() {
        const selected = frequenceSelect.value;

        // Vérifier les éléments avant de manipuler classList
        if (selected === 'une_fois') {
            if (dateContainerSolo) {
                dateContainerSolo.classList.remove('hidden');
            }
            if (dateContainerMultiple) {
                dateContainerMultiple.classList.add('hidden');
            }
        } else if (selected === 'hebdomadaire') {
            if (dateContainerSolo) {
                dateContainerSolo.classList.add('hidden');
            }
            if (dateContainerMultiple) {
                dateContainerMultiple.classList.remove('hidden');
            }
        } else {
            if (dateContainerSolo) {
                dateContainerSolo.classList.add('hidden');
            }
            if (dateContainerMultiple) {
                dateContainerMultiple.classList.add('hidden');
            }
        }
    }

    // Si la checkbox est déjà cochée au chargement de la page
    if (checkbox.checked) {
        frequenceContainer.classList.remove('hidden');
        handleFrequencyChange();
    }
});
