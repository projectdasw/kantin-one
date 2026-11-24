//
import * as bootstrap from 'bootstrap';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
// import './bootstrap';
// import 'bootstrap';
import 'laravel-datatables-vite';

import './modules/auto-refresh.js';
import './modules/tooltips.js';

import './layouts/dashboard.js';
import './pages/auth/login.js';
import './pages/tenants.js';
import './pages/products.js';
import './pages/users.js';
import './pages/tables.js';
import './pages/canteens.js';
import './pages/buildings.js';
import './pages/floors.js';

import './pages/customer/products-order.js';
import './pages/customer/cart-order.js';
import './pages/customer/order-tracking.js';

window.bootstrap = bootstrap;
window.Swal = Swal;
window.Chart = Chart;