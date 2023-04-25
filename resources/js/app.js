import './bootstrap';

import Alpine from 'alpinejs';
import { Chart } from 'chart.js/auto';

import Glide from '@glidejs/glide';
import '@glidejs/glide/dist/css/glide.core.min.css';
import '@glidejs/glide/dist/css/glide.theme.min.css';

window.Alpine = Alpine;
Alpine.start();

window.Chart = Chart;

window.Glide = Glide;
