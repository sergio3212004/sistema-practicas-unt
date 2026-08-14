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

## Verificación

```bash
composer validate --strict
composer check-platform-reqs
composer test
npm run build
```

La base de pruebas usa SQLite en memoria y no modifica la base de desarrollo.
