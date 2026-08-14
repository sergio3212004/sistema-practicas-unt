import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

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

Alpine.start();
