import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('tachesChart');
    if (!el) return; // Évite les erreurs si le canvas n'est pas sur la page

    const ctx = el.getContext('2d');

    const tachesChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Nouveau', 'Planifié', 'En cours', 'Terminé'],
            datasets: [{
                label: 'Nombre de tâches',
                data: [
                    window.tachesData.nouveau,
                    window.tachesData.planifie,
                    window.tachesData.en_cours,
                    window.tachesData.termine
                ],
                backgroundColor: [
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 205, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
    });
});