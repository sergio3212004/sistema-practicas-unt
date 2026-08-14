<script>
    (() => {
        try {
            const preference = window.localStorage.getItem('theme.preference');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const dark = preference === 'dark' || (preference === null && prefersDark);

            document.documentElement.classList.toggle('dark', dark);
            document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
        } catch (_) {
            // La interfaz conserva el tema claro si el navegador bloquea el almacenamiento.
        }
    })();
</script>
