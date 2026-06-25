import 'flowbite';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Chart = Chart;

Alpine.store('theme', {
    dark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    init() {
        this.apply();
    },

    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        this.apply();
    },

    apply() {
        document.documentElement.classList.toggle('dark', this.dark);
    },
});

Alpine.store('toast', {
    visible: false,
    message: '',
    type: 'success',
    timeout: null,

    show(message, type = 'success') {
        this.message = message;
        this.type = type;
        this.visible = true;
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => { this.visible = false; }, 4000);
    },
});

Alpine.store('loading', {
    active: false,
    show() { this.active = true; },
    hide() { this.active = false; },
});

Alpine.store('confirm', {
    open: false,
    form: null,
    message: 'Apakah Anda yakin ingin menghapus data ini?',

    ask(form, message = null) {
        this.form = form;
        if (message) this.message = message;
        this.open = true;
    },

    submit() {
        if (this.form) this.form.submit();
        this.open = false;
    },
});

window.confirmDelete = (form, message = null) => Alpine.store('confirm').ask(form, message);

document.addEventListener('DOMContentLoaded', () => {
    Alpine.store('theme').apply();

    document.querySelectorAll('form[data-loading]').forEach(form => {
        form.addEventListener('submit', () => Alpine.store('loading').show());
    });
});

window.Alpine = Alpine;
Alpine.start();
