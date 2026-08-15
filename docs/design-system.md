# Sistema visual institucional

Este documento define las reglas de interfaz del Sistema de Prácticas Preprofesionales de la Escuela de Ingeniería Informática. Complementa el manual corporativo de la Universidad Nacional de Trujillo y evita que cada módulo introduzca un estilo independiente.

## Principios

1. **Institucional:** la interfaz debe transmitir confianza, orden y continuidad con la identidad UNT.
2. **Tecnológico:** la precisión se expresa mediante retículas, jerarquía clara, datos legibles y microinteracciones discretas; no mediante efectos decorativos excesivos.
3. **Académico:** los estados, plazos y siguientes acciones deben ser fáciles de reconocer para estudiantes, docentes, empresas y administradores.
4. **Consistente:** los componentes compartidos son la fuente de verdad. Una pantalla nueva no debe inventar otra variante de botón, tarjeta o encabezado.

## Identidad y color

Los valores digitales proceden del manual corporativo:

| Uso | Token | Valor |
| --- | --- | --- |
| Navegación y acciones primarias | Azul institucional | `#12377B` |
| Acento y selección | Dorado institucional | `#E6AD09` |
| Estados positivos | Verde institucional | `#0C8F3D` |
| Error o acción destructiva | Rojo institucional | `#D8261A` |
| Texto principal | Negro institucional | `#1E1A17` |
| Texto secundario | Gris institucional | `#373435` |

El dorado no reemplaza al azul como color de acción. Verde y rojo solo comunican estado o riesgo. Las familias antiguas `indigo`, `purple`, `cyan` y `teal` se normalizan hacia el azul institucional desde `tailwind.config.js` para mantener coherencia en vistas aún no migradas a componentes.

## Logotipo

Se mantiene el archivo `public/logo-informatica.png` sin modificar su forma ni sus colores. Debe mostrarse con `object-contain`, sobre una superficie blanca y con espacio interior suficiente. No debe inclinarse, recortarse, deformarse, recolorearse ni colocarse directamente sobre una fotografía.

## Tipografía

- Inter es la tipografía funcional de la interfaz por su legibilidad en pantallas.
- La firma institucional permanece dentro de los archivos oficiales de marca. Trajan Pro se reserva como fallback de encabezados institucionales cuando exista una licencia y el archivo tipográfico esté disponible.
- Los títulos usan peso 700; el cuerpo usa 400 o 500. Evitar texto completo en mayúsculas salvo etiquetas breves.

## Componentes compartidos

- `x-ui.page-header`: encabezado y acción principal de una pantalla.
- `x-ui.stat-card`: indicadores resumidos con tonos semánticos.
- `x-ui.empty-state`: estados vacíos con explicación y siguiente acción.
- `x-ui.flash`: notificaciones globales de sesión.
- `.ui-card`: contenedor de información.
- `.ui-btn-primary`, `.ui-btn-secondary`, `.ui-btn-danger`: jerarquía de acciones.
- `.ui-field`, `.ui-label`: controles de formulario.
- `.ui-badge-*`: estados informativos, positivos, de advertencia o error.

## Reglas de experiencia

- Una pantalla debe tener una sola acción primaria visible por sección.
- Toda acción representada solo por un icono necesita `aria-label`.
- Las acciones destructivas requieren confirmación y nunca comparten el color de la acción primaria.
- Los estados vacíos deben explicar qué ocurre y, cuando sea posible, ofrecer un siguiente paso real.
- No utilizar enlaces con `href="#"` como promesa de una función inexistente.
- Tablas y grupos de acciones deben funcionar desde 320 px; la navegación lateral se convierte en panel móvil.
- Respetar `prefers-reduced-motion` y mantener foco visible con teclado.

## Tema claro y oscuro

- Ambos temas usan exclusivamente la paleta institucional; el tema oscuro cambia superficies y contraste, no la identidad cromática.
- La preferencia se guarda en el navegador. Sin una elección previa, se respeta `prefers-color-scheme` del sistema operativo.
- El azul sigue siendo el color de acción principal, el dorado se mantiene como acento y verde/rojo conservan su uso semántico.
- El logotipo siempre permanece sin alteraciones sobre una superficie blanca, también en modo oscuro.
- El selector de tema debe estar disponible en los layouts autenticado y público, ser operable con teclado y exponer una etiqueta accesible.

## Accesibilidad

El objetivo institucional es WCAG 2.2 nivel AA. Las decisiones, correcciones realizadas y validaciones manuales pendientes se mantienen en [la auditoría de accesibilidad](accessibility-audit.md).
