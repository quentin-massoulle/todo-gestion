(function () {
    console.log('coco');

    const checkbox = document.getElementById('rappel_active');
    const frequenceContainer = document.getElementById('frequence-container');
    const frequenceSelect = document.getElementById('frequence');
    const dateContainerMultiple = document.getElementById('date-container-multiple');
    const dateContainerSolo = document.getElementById('date-container-solo');

    if (!checkbox || !frequenceContainer || !frequenceSelect || !dateContainerMultiple || !dateContainerSolo) {
        console.error("Un ou plusieurs éléments sont manquants !");
        return;
    }

    function hideAll() {
        frequenceContainer.classList.add('hidden');
        dateContainerSolo.classList.add('hidden');
        dateContainerMultiple.classList.add('hidden');
    }

    function handleFrequencyChange() {
        const selected = frequenceSelect.value;

        if (selected === 'une_fois') {
            dateContainerSolo.classList.remove('hidden');
            dateContainerMultiple.classList.add('hidden');
        } else if (selected === 'hebdomadaire') {
            dateContainerSolo.classList.add('hidden');
            dateContainerMultiple.classList.remove('hidden');
        } else {
            dateContainerSolo.classList.add('hidden');
            dateContainerMultiple.classList.add('hidden');
        }
    }

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            frequenceContainer.classList.remove('hidden');
            handleFrequencyChange();
        } else {
            hideAll();
        }
    });

    // Appel initial au chargement
    if (checkbox.checked) {
        frequenceContainer.classList.remove('hidden');
        handleFrequencyChange();
    } else {
        hideAll();
    }
})();