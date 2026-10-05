import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.Chart = Chart;
window.lucide = { createIcons, icons };

Alpine.start();

// Re-render Lucide icons after Livewire navigations
document.addEventListener('livewire:navigated', () => {
    window.lucide.createIcons({ icons: window.lucide.icons });
});

document.addEventListener('livewire:init', () => {
    window.Livewire.hook('morph.updated', () => {
        window.lucide.createIcons({ icons: window.lucide.icons });
    });
});

// Initial render
window.addEventListener('DOMContentLoaded', () => {
    window.lucide.createIcons({ icons: window.lucide.icons });
});
