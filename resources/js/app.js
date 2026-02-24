import './bootstrap';
import $ from 'jquery'; 
import select2 from 'select2'; 
import 'select2/dist/css/select2.css'; 
import Chart from 'chart.js/auto';
import './chartGroupe';
import Swal from 'sweetalert2';
import Gantt from 'frappe-gantt';
import '../css/frappe-gantt.css';


select2($); 


window.$ = window.jQuery = $;
window.Chart = Chart;
window.Gantt = Gantt;
window.Swal = Swal;

$(document).ready(() => {
  console.log('jQuery version:', $.fn.jquery);
  
  if (typeof $.fn.select2 === 'function') {
    console.log('✅ Select2 est prêt');
    $('.select2').select2({
      placeholder: 'Rechercher...',
      allowClear: true,
    });
  } else {
    console.error('❌ Select2 n’est pas chargé sur cette instance jQuery');
  }
});