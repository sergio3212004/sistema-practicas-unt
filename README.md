# Sistema web de prácticas UNT

Aplicación para la gestión de prácticas preprofesionales de la Escuela de
Informática de la Universidad Nacional de Trujillo.

## Entorno soportado

- PHP 8.5.9 (se admiten actualizaciones de parche 8.5.x)
- Laravel 13
- Composer 2
- Node.js 20.19+ o 22.12+
- PostgreSQL mediante `ext-pdo` y `ext-pdo_pgsql`
- SQLite mediante `ext-pdo_sqlite` para las pruebas automatizadas

Composer resuelve las dependencias usando PHP 8.5.9 como plataforma. El archivo
`.php-version` permite que los gestores de versiones compatibles seleccionen esa
versión automáticamente.

En Fedora, instala los controladores de base de datos antes de ejecutar Composer:

```bash
sudo dnf install php-pgsql php-sqlite3
php -m | grep -E 'PDO|pdo_pgsql|pdo_sqlite'
```

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm ci
npm run build
```

Para desarrollo:

```bash
composer run dev
```

La aplicación estará disponible en <http://127.0.0.1:8000> y Vite recargará los
recursos frontend al modificarlos.

## Consulta de RUC para el registro de empresas

El formulario consulta el padrón RUC desde el backend y autocompleta el nombre o
razón social, tipo de persona jurídica, domicilio fiscal y ubigeo. Los campos que
el proveedor no entregue quedan habilitados para completarlos manualmente. Si el
servicio no está disponible, el formulario informa el problema y activa un modo
manual de contingencia.

SUNAT publica el padrón RUC como datos abiertos, pero su servicio de ficha RUC no
es una API REST pública de acceso inmediato para entidades privadas. La
integración predeterminada usa el proveedor APIS.net.pe/Decolecta, que mantiene
una API sobre el padrón publicado por SUNAT. Genera un token en
<https://apis.net.pe/> y configúralo únicamente en el servidor:

```dotenv
SUNAT_RUC_API_URL=https://api.decolecta.com/v1/sunat/ruc/full
SUNAT_RUC_API_TOKEN=tu_token
SUNAT_RUC_CONNECT_TIMEOUT=3
SUNAT_RUC_TIMEOUT=8
```

Después de cambiar estas variables en producción, ejecuta:

```bash
php artisan config:cache
```

El cliente externo está aislado en `app/Services/Sunat/SunatRucService.php`, por
lo que puede reemplazarse si la universidad obtiene acceso directo a los
servicios web de SUNAT.

## Verificación

```bash
composer validate --strict
composer check-platform-reqs
composer test
npm run build
```

La base de pruebas usa SQLite en memoria y no modifica la base de desarrollo.
