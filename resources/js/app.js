import './bootstrap';
import Chart from 'chart.js/auto';
import './chartGroupe';
import Swal from 'sweetalert2';
import Gantt from 'frappe-gantt';
import '../css/frappe-gantt.css';

document.addEventListener('DOMContentLoaded', () => {
  if (window.appTasks) {
    const formattedTasks = window.appTasks.map(task => ({
      id: task.id.toString(),
      name: task.titre,
      start: task.date_debut,
      end: task.date_fin,
      dependencies: task.dependencies || '',
      proprietaire: task.user ? task.user.name : 'Aucun',
    }));

    new Gantt("#gantt", formattedTasks, {
      view_mode: 'Day',
      language: 'fr',
    });
  } else {
    console.error('No tasks found');
  }
});

window.Swal = Swal;

$(document).ready(() => {
  console.log('jQuery:', typeof $.fn.jquery);
  console.log('Select2:', typeof $.fn.select2);

  if (typeof $.fn.select2 === 'function') {
    console.log('✅ Select2 est prêt');
    $('.select2').select2({
      placeholder: 'Rechercher...',
      allowClear: true,
    });
  } else {
    console.error('❌ Select2 n’est pas chargé');
  }
});
