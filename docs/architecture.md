# Arquitectura del sistema de prácticas

## Objetivo

El proyecto sigue una arquitectura Laravel modular por actor. Cada petición debe recorrer capas con una responsabilidad concreta:

```text
Ruta -> Middleware -> FormRequest -> Controlador -> Acción/Servicio -> Modelo
                         |               |
                    autorización     ViewModel/Presenter -> Vista Blade
                       (Policy)
```

- Las rutas definen URL, verbo HTTP y middleware, pero no contienen lógica de negocio.
- Los middleware resuelven condiciones transversales, como autenticación, rol y aprobación de empresa.
- Los `FormRequest` validan y autorizan la entrada asociada a una operación.
- Los controladores coordinan el caso de uso y construyen la respuesta HTTP.
- Las acciones representan un caso de uso concreto con lógica de negocio.
- Los servicios encapsulan procesos reutilizables o integraciones externas.
- Las políticas verifican la propiedad de cada recurso.
- Los modelos representan datos, relaciones y comportamiento propio de la entidad.
- Los `ViewModels` agrupan los datos que necesita una pantalla y calculan sus métricas.
- Los `Presenters` traducen valores del dominio a texto, clases y estructuras de presentación.
- Las vistas Blade solo renderizan datos y delegan secciones repetibles a componentes.

## Organización

```text
app/
├── Actions/                 # Casos de uso específicos
├── Enums/                   # Vocabulario cerrado del dominio
├── Http/
│   ├── Controllers/         # Coordinación HTTP, agrupada por actor
│   ├── Middleware/          # Reglas transversales
│   └── Requests/            # Validación y autorización de entrada
├── Models/                  # Entidades y relaciones Eloquent
├── Policies/                # Autorización por propiedad del recurso
├── Services/                # Procesos reutilizables e integraciones
└── View/
    ├── {Actor}/{Pantalla}/    # ViewModels de pantallas con datos complejos
    ├── Composers/           # Datos transversales de layouts
    ├── Dashboards/          # ViewModels del panel por actor
    ├── Layout/              # Objetos de datos para layouts
    ├── Presenters/          # Formato y estado visual reutilizable
    └── PageTitleResolver.php # Título del documento según la ruta actual

resources/views/
├── components/              # Piezas reutilizables y secciones de pantalla
├── layouts/                 # Estructura global autenticada y pública
└── {actor}/{recurso}/       # Pantallas agrupadas por actor y recurso

routes/
├── web.php                  # Punto de composición
├── shared.php               # Firmas, registro e integraciones compartidas
├── admin.php
├── profesor.php
├── empresa.php
├── alumno.php
└── auth.php
```

## Límites y convenciones

### Rutas

- Cada módulo mantiene su prefijo, nombre y middleware en un único grupo.
- Una operación que cambia estado usa `POST`, `PUT`, `PATCH` o `DELETE`; nunca `GET`.
- Los parámetros usan el nombre singular exacto del modelo para habilitar route model binding.
- `routes/web.php` solo compone rutas globales y los archivos de cada módulo.

### Controladores

- Un controlador no debe construir clientes externos, abrir transacciones complejas ni duplicar reglas de validación.
- Se usa route model binding en lugar de recibir identificadores y llamar a `findOrFail` repetidamente.
- Las consultas de un actor siempre se limitan a sus recursos.
- Si un método empieza a coordinar varias escrituras o efectos, se extrae a una acción o servicio.

### Validación y autorización

- La forma y restricciones de la entrada pertenecen a `app/Http/Requests`.
- El middleware `role` restringe el módulo completo.
- Las políticas restringen el registro concreto; tener el rol correcto no concede acceso a datos de otro usuario.
- Las reglas de propiedad deben permanecer en una política, no repetirse en cada método del controlador.

### Persistencia e integraciones

- Las escrituras relacionadas se ejecutan dentro de `DB::transaction`.
- Los eventos o llamadas externas se realizan después de confirmar la transacción siempre que sea posible.
- Credenciales y tokens no se guardan en controladores ni vistas.
- Cada integración externa tiene un servicio propio, como `GoogleDriveService`.

### Vistas y datos de presentación

- Una vista no importa modelos, no usa fachadas de base de datos y no ejecuta consultas Eloquent.
- El controlador carga todas las relaciones requeridas antes de renderizar.
- Las métricas de una pantalla pertenecen a un `ViewModel`; el formato de estados pertenece a un `Presenter`.
- Los datos globales de navegación se preparan con un `View Composer`, no con llamadas a `auth()` o `request()` dentro de Blade.
- Los títulos del navegador se declaran por nombre de ruta en `config/page-titles.php`; las vistas de detalle pueden sobrescribirlos con el atributo `title` del layout.
- Una sección con estructura y responsabilidad propias se extrae a `resources/views/components`.
- Los componentes reciben datos explícitos mediante `@props`; no descubren datos de negocio por su cuenta.
- Los condicionales Blade se limitan a elegir qué representación mostrar, no a implementar reglas de negocio.

## Cómo añadir una funcionalidad

1. Elegir el módulo propietario y declarar su ruta con el verbo HTTP correcto.
2. Crear un `FormRequest` si recibe entrada.
3. Crear o ampliar una política si opera sobre un recurso perteneciente a un usuario.
4. Mantener el controlador como coordinador corto.
5. Extraer una acción para un caso de uso con varias escrituras o reglas.
6. Extraer un servicio si la lógica se reutiliza o integra un proveedor externo.
7. Añadir pruebas de acceso, validación, resultado y aislamiento entre propietarios.
8. Si hay interfaz, preparar sus datos fuera de Blade y reutilizar componentes existentes.

## Verificación local

```bash
php artisan test
php artisan route:list --except-vendor
php artisan route:cache
vendor/bin/pint --test
```

`route:cache` debe completarse correctamente; por eso las rutas no deben usar closures como acciones.
