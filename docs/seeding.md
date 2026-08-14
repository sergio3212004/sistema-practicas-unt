# Datos iniciales y cuentas de demostración

Los seeders separan dos clases de información:

- Los catálogos indispensables (`roles`, razones sociales y tipos de actividad) se crean en todos los entornos.
- Las cuentas, perfiles, semestre y aula de demostración se crean en desarrollo y pruebas. En producción están deshabilitados salvo habilitación explícita.

## Configuración

Las credenciales se definen mediante las variables `SEED_*` incluidas en `.env.example`. Cada rol tiene una contraseña distinta y puede sobrescribirse sin editar el código. El archivo de ejemplo mantiene `SEED_DEMO_DATA=false` para que las cuentas no se creen accidentalmente.

Antes de compartir o desplegar una instancia, deben reemplazarse todos los valores de demostración. Para habilitar temporalmente las cuentas en un entorno local:

```dotenv
SEED_DEMO_DATA=true
```

Para sembrar una base local:

```bash
SEED_DEMO_DATA=true php artisan migrate:fresh --seed
```

Los seeders son idempotentes: `php artisan db:seed` puede ejecutarse nuevamente sin duplicar catálogos, cuentas o perfiles.
