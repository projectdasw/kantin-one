//
import * as bootstrap from 'bootstrap';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import './layouts/dashboard.js';
import './modules/tooltips.js';
import './pages/auth/login.js';
import './pages/tenants.js';
import './pages/products.js';

import './pages/customer/products-order.js';
import './pages/customer/cart-order.js';

window.bootstrap = bootstrap;
window.Swal = Swal;
window.Chart = Chart;