const checkbox = document.getElementById('rappel_active');
const frequenceContainer = document.getElementById('frequence-container');
const frequenceSelect = document.getElementById('frequence');
const dateContainer = document.getElementById('date-container');

checkbox.addEventListener('change', function () {
    if (this.checked) {
        frequenceContainer.classList.remove('hidden');
        handleFrequencyChange(); // Check frequency when checkbox is (re)checked
    } else {
        frequenceContainer.classList.add('hidden');
        dateContainer.classList.add('hidden');
    }
});

frequenceSelect.addEventListener('change', handleFrequencyChange);

function handleFrequencyChange() {
    const selected = frequenceSelect.value;
    if (selected === 'une_fois' || selected === 'hebdomadaire') {
        dateContainer.classList.remove('hidden');
    } else {
        dateContainer.classList.add('hidden');
    }
}