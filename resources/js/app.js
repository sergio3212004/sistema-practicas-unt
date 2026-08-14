import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('themeToggle', () => ({
    dark: document.documentElement.classList.contains('dark'),

    init() {
        this.$watch('dark', (dark) => {
            document.documentElement.classList.toggle('dark', dark);
            document.documentElement.style.colorScheme = dark ? 'dark' : 'light';

            try {
                window.localStorage.setItem('theme.preference', dark ? 'dark' : 'light');
            } catch (_) {
                // El cambio sigue activo aunque el navegador bloquee localStorage.
            }
        });
    },

    toggle() {
        this.dark = ! this.dark;
    },
}));

Alpine.data('navigation', () => ({
    navigationOpen: false,
    navigationExpanded: true,

    init() {
        try {
            const storedPreference = window.localStorage.getItem('navigation.expanded');

            if (storedPreference !== null) {
                this.navigationExpanded = storedPreference === 'true';
            }
        } catch (_) {
            // El menú sigue funcionando aunque el navegador bloquee localStorage.
        }

        this.$watch('navigationExpanded', (expanded) => {
            try {
                window.localStorage.setItem('navigation.expanded', String(expanded));
            } catch (_) {
                // La persistencia es una mejora opcional, no un requisito del menú.
            }
        });

        this.$watch('navigationOpen', (open) => {
            document.body.classList.toggle('overflow-hidden', open);
        });
    },

    isDesktop() {
        return window.matchMedia('(min-width: 1024px)').matches;
    },

    navigationVisible() {
        return this.isDesktop() ? this.navigationExpanded : this.navigationOpen;
    },

    toggleNavigation() {
        if (this.isDesktop()) {
            this.navigationExpanded = ! this.navigationExpanded;
            return;
        }

        this.navigationOpen = ! this.navigationOpen;
    },

    closeNavigation() {
        if (this.isDesktop()) {
            this.navigationExpanded = false;
            return;
        }

        this.navigationOpen = false;
    },

    syncNavigation() {
        if (this.isDesktop()) {
            this.navigationOpen = false;
        }
    },
}));

Alpine.data('companyRegistration', (config) => ({
    ruc: config.initial.ruc ?? '',
    company: {
        nombre: config.initial.nombre ?? '',
        razon_social_id: config.initial.razon_social_id ?? '',
        departamento: config.initial.departamento ?? '',
        provincia: config.initial.provincia ?? '',
        distrito: config.initial.distrito ?? '',
        direccion: config.initial.direccion ?? '',
        estado: '',
        condicion: '',
    },
    lookupState: config.lookupReady ? 'restored' : 'idle',
    lookupMessage: '',
    detailsVisible: Boolean(config.lookupReady),
    readonlyFields: [],
    consultedRuc: config.lookupReady ? config.initial.ruc : null,

    get registrationEnabled() {
        return ['complete', 'incomplete', 'manual', 'restored'].includes(this.lookupState);
    },

    get statusClasses() {
        if (this.lookupState === 'complete') {
            return 'border-green-200 bg-green-50 text-green-800';
        }

        if (['incomplete', 'manual'].includes(this.lookupState)) {
            return 'border-yellow-200 bg-yellow-50 text-yellow-900';
        }

        return 'border-red-200 bg-red-50 text-red-800';
    },

    handleRucInput() {
        this.ruc = this.ruc.replace(/\D/g, '').slice(0, 11);

        if (this.consultedRuc !== null && this.ruc !== this.consultedRuc) {
            this.resetLookup();
        }
    },

    resetLookup() {
        this.lookupState = 'idle';
        this.lookupMessage = '';
        this.detailsVisible = false;
        this.readonlyFields = [];
        this.consultedRuc = null;
        this.company = {
            nombre: '',
            razon_social_id: '',
            departamento: '',
            provincia: '',
            distrito: '',
            direccion: '',
            estado: '',
            condicion: '',
        };
    },

    isReadonly(field) {
        return this.readonlyFields.includes(field);
    },

    fieldClasses(field) {
        return this.isReadonly(field)
            ? 'block w-full bg-gray-100 text-gray-600 cursor-not-allowed'
            : 'block w-full bg-white';
    },

    async lookupRuc() {
        if (! /^\d{11}$/.test(this.ruc)) {
            this.lookupState = 'error';
            this.lookupMessage = 'Ingresa un RUC válido de 11 dígitos.';
            this.detailsVisible = false;
            return;
        }

        this.lookupState = 'loading';
        this.lookupMessage = '';

        try {
            const response = await fetch(config.lookupUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': config.csrfToken,
                },
                body: JSON.stringify({ ruc: this.ruc }),
            });
            const payload = await response.json();

            if (! response.ok) {
                if (response.status === 503 && payload.allow_manual) {
                    this.enableManualFallback(payload.message);
                    return;
                }

                this.lookupState = 'error';
                this.lookupMessage = payload.errors?.ruc?.[0] ?? payload.message ?? 'No se pudo consultar el RUC.';
                this.detailsVisible = false;
                return;
            }

            this.applyLookup(payload);
        } catch (_) {
            this.lookupState = 'error';
            this.lookupMessage = 'No se pudo completar la consulta. Revisa tu conexión e inténtalo nuevamente.';
            this.detailsVisible = false;
        }
    },

    applyLookup(payload) {
        Object.keys(this.company).forEach((field) => {
            this.company[field] = payload.data?.[field] ?? '';
        });

        this.readonlyFields = payload.readonly_fields ?? [];
        this.consultedRuc = this.ruc;
        this.lookupState = payload.status;
        this.lookupMessage = payload.message;
        this.detailsVisible = true;
    },

    enableManualFallback(message) {
        this.resetLookup();
        this.consultedRuc = this.ruc;
        this.lookupState = 'manual';
        this.lookupMessage = message;
        this.detailsVisible = true;
    },
}));

Alpine.start();
