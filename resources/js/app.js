import './bootstrap';
import './custom_confirm';


import.meta.glob([
    '../images/**',
]);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
