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
    desktop: window.matchMedia('(min-width: 1024px)').matches,
    returnFocusTo: null,

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

        this.syncNavigation();
    },

    isDesktop() {
        return this.desktop;
    },

    navigationVisible() {
        return this.isDesktop() ? this.navigationExpanded : this.navigationOpen;
    },

    toggleNavigation() {
        if (this.isDesktop()) {
            this.navigationExpanded = ! this.navigationExpanded;
            return;
        }

        if (this.navigationOpen) {
            this.closeNavigation({ restoreFocus: true });
            return;
        }

        this.returnFocusTo = document.activeElement;
        this.navigationOpen = true;
        this.$nextTick(() => {
            this.$refs.navigationPanel?.querySelector('a, button')?.focus();
        });
    },

    closeNavigation({ restoreFocus = false } = {}) {
        if (this.isDesktop()) {
            return;
        }

        if (! this.navigationOpen) {
            return;
        }

        this.navigationOpen = false;

        if (restoreFocus) {
            this.$nextTick(() => {
                (this.returnFocusTo ?? this.$refs.navigationButton)?.focus();
                this.returnFocusTo = null;
            });
        }
    },

    syncNavigation() {
        this.desktop = window.matchMedia('(min-width: 1024px)').matches;

        if (this.isDesktop()) {
            this.navigationOpen = false;
            document.body.classList.remove('overflow-hidden');
        }
    },

    trapNavigationFocus(event) {
        if (this.isDesktop() || ! this.navigationOpen) {
            return;
        }

        const focusable = [...this.$refs.navigationPanel.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])',
        )].filter((element) => ! element.hasAttribute('inert'));

        if (focusable.length === 0) {
            event.preventDefault();
            return;
        }

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (! event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
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

document.querySelectorAll('[data-signature-upload]').forEach((input) => {
    const canvas = document.getElementById(input.dataset.canvas);
    const output = document.getElementById(input.dataset.output);
    const status = document.getElementById(input.dataset.status);

    if (! canvas || ! output) {
        return;
    }

    input.addEventListener('change', () => {
        const [file] = input.files;

        if (! file) {
            return;
        }

        if (! file.type.startsWith('image/')) {
            input.value = '';
            if (status) status.textContent = 'El archivo seleccionado no es una imagen válida.';
            return;
        }

        const reader = new FileReader();

        reader.addEventListener('load', () => {
            const image = new Image();

            image.addEventListener('load', () => {
                const context = canvas.getContext('2d');
                const scale = Math.min(canvas.width / image.width, canvas.height / image.height);
                const width = image.width * scale;
                const height = image.height * scale;

                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(
                    image,
                    (canvas.width - width) / 2,
                    (canvas.height - height) / 2,
                    width,
                    height,
                );
                output.value = canvas.toDataURL('image/png');
                canvas.dispatchEvent(new CustomEvent('signature:loaded'));
                if (status) status.textContent = `Firma cargada: ${file.name}.`;
            });

            image.addEventListener('error', () => {
                input.value = '';
                if (status) status.textContent = 'No se pudo leer la imagen seleccionada.';
            });

            image.src = reader.result;
        });

        reader.readAsDataURL(file);
    });
});

document.querySelectorAll('[data-signature-clear]').forEach((button) => {
    button.addEventListener('click', () => {
        const status = document.getElementById(button.dataset.status);
        if (status) status.textContent = 'Se borró la firma. Dibuja o carga una nueva antes de continuar.';
    });
});

let accessibleTableSequence = 0;

const enhanceDataTable = (table) => {
    if (table.dataset.accessibilityEnhanced === 'true') {
        return;
    }

    table.dataset.accessibilityEnhanced = 'true';
    table.querySelectorAll('thead th:not([scope])').forEach((header) => {
        header.scope = header.colSpan > 1 ? 'colgroup' : 'col';
    });
    table.querySelectorAll('tbody th:not([scope])').forEach((header) => {
        header.scope = 'row';
    });

    const caption = table.querySelector('caption');
    const scrollContainer = table.closest('.overflow-x-auto, .ui-table-wrap');

    if (! caption || ! scrollContainer) {
        return;
    }

    accessibleTableSequence += 1;
    caption.id ||= `tabla-caption-${accessibleTableSequence}`;

    const updateScrollableRegion = () => {
        const overflows = table.scrollWidth > scrollContainer.clientWidth + 1;

        if (overflows) {
            scrollContainer.tabIndex = 0;
            scrollContainer.setAttribute('role', 'region');
            scrollContainer.setAttribute('aria-labelledby', caption.id);
        } else if (scrollContainer.getAttribute('aria-labelledby') === caption.id) {
            scrollContainer.removeAttribute('tabindex');
            scrollContainer.removeAttribute('role');
            scrollContainer.removeAttribute('aria-labelledby');
        }
    };

    updateScrollableRegion();

    if ('ResizeObserver' in window) {
        new ResizeObserver(updateScrollableRegion).observe(scrollContainer);
    }
};

document.querySelectorAll('table').forEach(enhanceDataTable);

new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (! (node instanceof Element)) {
                return;
            }

            if (node.matches('table')) {
                enhanceDataTable(node);
            }

            node.querySelectorAll('table').forEach(enhanceDataTable);
        });
    });
}).observe(document.body, { childList: true, subtree: true });

Alpine.start();
