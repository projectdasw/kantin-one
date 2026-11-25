//
import * as bootstrap from 'bootstrap';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import 'laravel-datatables-vite';

import './modules/auto-refresh.js';
import './modules/tooltips.js';
import './layouts/dashboard.js';

window.bootstrap = bootstrap;
window.Swal = Swal;
window.Chart = Chart;

// ==========================================
// SWEETALERT: SUCCESS NOTIFICATION
// ==========================================
const successMessage = document.querySelector(
    'meta[name="flash-success"]'
)?.content;

if (successMessage) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: successMessage,
        showConfirmButton: false,
        timer: 1500
    });
}