// app.js

// AlpineJS est requis
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Dark mode toggle
document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const toggleButtons = document.querySelectorAll('button[title="Mode sombre"]');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                html.classList.add('light');
            } else {
                html.classList.remove('light');
                html.classList.add('dark');
            }
        });
    });
});
