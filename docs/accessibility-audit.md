# Auditoría de accesibilidad web

Fecha de revisión: 14 de agosto de 2026  
Objetivo: [WCAG 2.2 nivel AA](https://www.w3.org/TR/WCAG22/)  
Alcance: layouts públicos y autenticados, navegación, autenticación, formularios, tablas, entregas, firmas y vistas principales de estudiantes, docentes, empresas y administración.

## Resultado

Se corrigieron las barreras detectables mediante revisión de código, compilación de vistas y pruebas automatizadas. El resultado mejora la conformidad técnica, pero no constituye una certificación WCAG: una declaración de conformidad requiere revisar todas las páginas y estados, incluidos contenido, servicios externos y documentos descargables, además de efectuar pruebas humanas con tecnologías de asistencia.

| Área | Criterios relacionados | Resultado implementado |
| --- | --- | --- |
| Estructura y navegación | 1.3.1, 1.3.2, 2.4.1, 2.4.2, 2.4.6 | Landmarks `header`, `nav`, `main` y `footer`; enlace para saltar al contenido; un título principal contextual; jerarquía de encabezados; secciones, artículos y tablas con nombres. |
| Teclado y foco | 2.1.1, 2.1.2, 2.4.3, 2.4.7 | Foco visible global; menú y modales con apertura, cierre con `Escape`, contención temporal del foco y devolución al elemento activador; contenido oculto retirado del foco mediante `inert`. |
| Controles y estado | 1.3.1, 2.5.3, 3.2.4, 4.1.2, 4.1.3 | Etiquetas asociadas, nombres accesibles en acciones con iconos, `aria-current` en navegación, diálogos identificados y mensajes con semántica `status` o `alert`. |
| Formularios y errores | 1.3.5, 3.3.1, 3.3.2, 3.3.3 | `autocomplete` e `inputmode` cuando corresponde; campos obligatorios explicados; errores enlazados mediante `aria-describedby`; `aria-invalid`; resúmenes de errores enfocables. |
| Tiempo disponible | 2.2.1 | Las notificaciones globales ya no desaparecen automáticamente y pueden descartarse de forma explícita. |
| Gestos de puntero | 2.1.1, 2.5.1 | Todos los lienzos de firma ofrecen carga de imagen operable con teclado como alternativa al dibujo con ratón o pantalla táctil. |
| Tablas y reflujo | 1.3.1, 1.4.10, 2.1.1 | Cada tabla interactiva tiene `caption`; encabezados de fila/columna reciben `scope`; las regiones con desplazamiento horizontal son enfocables y se anuncian solo cuando realmente desbordan. |
| Percepción visual | 1.4.3, 1.4.11, 2.3.3 | Foco con contraste reforzado, estados amarillos corregidos, soporte de colores forzados y reducción de movimiento mediante `prefers-reduced-motion`. |
| Enlaces e imágenes | 1.1.1, 2.4.4 | Imágenes informativas con texto alternativo, iconos decorativos ocultos a tecnologías de asistencia y aviso en enlaces que abren una pestaña nueva. |

## Verificación automatizada realizada

- `npm run build`: compilación de Vite completada.
- `php artisan view:cache`: todas las plantillas Blade compilan.
- `php artisan test --compact`: 69 pruebas correctas y 254 aserciones.
- Pruebas de arquitectura añadidas para impedir regresiones en enlace de salto, landmark principal, navegación oculta, notificaciones, nombres de tablas, firmas alternativas y asociación de errores.

## Validaciones manuales necesarias antes de declarar conformidad

1. Recorrer cada flujo y cada rol solo con teclado, comprobando orden de foco y que no quede oculto por contenido fijo.
2. Probar al menos con NVDA + Firefox o Chrome y VoiceOver + Safari, verificando nombres, estados, errores y cambios dinámicos.
3. Validar reflujo a 320 píxeles CSS y zoom de texto al 200 %, sin pérdida de contenido ni desplazamiento en dos direcciones salvo en tablas justificadas.
4. Medir contraste sobre las páginas renderizadas, incluidos estados `hover`, `focus`, deshabilitado, tema oscuro y contenido cargado desde datos reales.
5. Verificar tamaño y separación de todos los objetivos táctiles, especialmente acciones heredadas fuera de los componentes compartidos.
6. Auditar los PDF generados como documentos independientes: el HTML de origen no garantiza que el PDF final tenga etiquetas, orden de lectura, tablas y formularios accesibles.
7. Evaluar el selector de Google Drive, los enlaces a documentos externos y las respuestas del servicio de consulta RUC, porque su accesibilidad no depende completamente de esta aplicación.
8. Realizar pruebas con personas con discapacidad para comprobar que los flujos académicos resulten comprensibles y eficientes, no solo técnicamente operables.

## Criterio sobre un “botón de accesibilidad”

No se añadió un overlay o botón genérico. Las facilidades esenciales deben estar incorporadas en todos los componentes y funcionar con las preferencias del navegador y del sistema operativo. Un panel adicional solo tendría sentido para preferencias propias y persistentes que aporten algo real —por ejemplo, densidad o simplificación de una vista— y nunca como sustituto de HTML semántico, contraste, teclado o compatibilidad con lectores de pantalla.

## Mantenimiento

- Toda pantalla nueva debe conservar un único `main`, un `h1` descriptivo y controles con nombre accesible.
- No se deben introducir temporizadores para información importante ni interacciones exclusivas de ratón o tacto.
- Las tablas nuevas requieren `caption` y encabezados; los errores deben asociarse al control que los provoca.
- La suite de arquitectura debe ejecutarse en integración continua junto con las pruebas funcionales.
- Se recomienda añadir pruebas de navegador con axe-core como alerta temprana; sus resultados deben complementarse siempre con revisión manual.
