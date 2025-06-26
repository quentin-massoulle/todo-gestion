import './bootstrap';
import Chart from 'chart.js/auto';
import './chartGroupe';

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
