<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formato 11 - Conformidad de PPP</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            max-width: 95%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header h2 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .info-section {
            margin-bottom: 12px;
        }

        .info-section p {
            margin-bottom: 3px;
            font-size: 9pt;
        }

        .info-section strong {
            display: inline-block;
            min-width: 150px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto 15px;
            font-size: 8pt;
            table-layout: fixed;
        }

        table th {
            background-color: #e0e0e0;
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 7.5pt;
            vertical-align: middle;
            word-wrap: break-word;
        }

        table td {
            border: 1px solid #000;
            padding: 5px 4px;
            vertical-align: top;
            font-size: 8pt;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .alumno-nombre {
            font-weight: bold;
            font-size: 8pt;
            word-wrap: break-word;
        }

        .alumno-codigo {
            font-size: 7pt;
            color: #555;
            margin-top: 2px;
        }

        .conformidad-si {
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-size: 8pt;
        }

        .conformidad-no {
            text-align: center;
            font-weight: bold;
            color: #cc0000;
            font-size: 8pt;
        }

        .firma-section {
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .nota {
            font-size: 7pt;
            font-style: italic;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .firma-box {
            margin-top: 40px;
            text-align: center;
        }

        .firma-image {
            max-width: 180px;
            max-height: 70px;
            margin-bottom: 5px;
        }

        .firma-line {
            border-top: 1px solid #000;
            width: 220px;
            margin: 0 auto;
            padding-top: 5px;
            font-size: 9pt;
        }

        .text-center {
            text-align: center;
        }

        /* Ajustes para columnas específicas con anchos relativos */
        .col-numero {
            width: 3%;
            text-align: center;
        }

        .col-alumno {
            width: 12%;
        }

        .col-sede {
            width: 10%;
        }

        .col-nivel {
            width: 5%;
            text-align: center;
        }

        .col-competencias {
            width: 15%;
        }

        .col-capacidades {
            width: 15%;
        }

        .col-actividades {
            width: 14%;
        }

        .col-producto {
            width: 9%;
        }

        .col-conformidad {
            width: 5%;
            text-align: center;
        }

        .col-comentarios {
            width: 12%;
        }

        /* Estilos para el texto que se puede expandir */
        .expandable-text {
            white-space: pre-line;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>ESCUELA PROFESIONAL DE INGENIERÍA DE SISTEMAS</h1>
    <h2>Conformidad de las Prácticas Pre Profesionales</h2>
</div>

<div class="info-section">
    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    <p><strong>Nombre del coordinador:</strong> {{ $formatoOnce->aula->profesor->nombres }} {{ $formatoOnce->aula->profesor->apellido_paterno }} {{ $formatoOnce->aula->profesor->apellido_materno }}</p>
    <p><strong>Aula:</strong> {{ $formatoOnce->aula->numero }} - {{ $formatoOnce->aula->semestre->nombre ?? 'N/A' }}</p>
</div>

<table>
    <thead>
    <tr>
        <th class="col-numero" rowspan="2">#</th>
        <th class="col-alumno" rowspan="2">Nombres y Apellidos del Estudiante</th>
        <th class="col-sede" rowspan="2">Nombre de la Sede de Prácticas</th>
        <th class="col-nivel" rowspan="2">Ciclo / Nivel</th>
        <th colspan="2">Competencias a desarrollar con la Práctica</th>
        <th class="col-actividades" rowspan="2">Actividades a desarrollar</th>
        <th class="col-producto" rowspan="2">Producto (*)</th>
        <th class="col-conformidad" rowspan="2">Conformidad</th>
        <th class="col-comentarios" rowspan="2">Comentarios</th>
    </tr>
    <tr>
        <th class="col-competencias">Competencia Genérica / Específica</th>
        <th class="col-capacidades">Capacidad(es)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($formatoOnce->formatoOnceAlumnos as $index => $registro)
        <tr>
            <td class="col-numero text-center">{{ $index + 1 }}</td>
            <td class="col-alumno">
                <div class="alumno-nombre">{{ $registro->alumno->user->nombre }}</div>
                <div class="alumno-codigo">{{ $registro->alumno->codigo_matricula }}</div>
            </td>
            <td class="col-sede">
                <div class="expandable-text">
                    {{ $registro->sede_practicas ?? '-' }}
                </div>
            </td>
            <td class="col-nivel text-center">
                {{ $registro->ciclo_nivel ?? 'N/A' }}
            </td>
            <td class="col-competencias">
                <div class="expandable-text">
                    {{ $registro->competencias ?? '-' }}
                </div>
            </td>
            <td class="col-capacidades">
                <div class="expandable-text">
                    {{ $registro->capacidades ?? '-' }}
                </div>
            </td>
            <td class="col-actividades">
                <div class="expandable-text">
                    {{ $registro->actividades ?? '-' }}
                </div>
            </td>
            <td class="col-producto">
                <div class="expandable-text">
                    {{ $registro->producto ?? '-' }}
                </div>
            </td>
            <td class="col-conformidad {{ $registro->conformidad ? 'conformidad-si' : 'conformidad-no' }}">
                {{ $registro->conformidad ? 'SÍ' : 'NO' }}
            </td>
            <td class="col-comentarios">
                <div class="expandable-text">
                    {{ $registro->comentarios ?? '-' }}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="nota">
    <strong>(*)</strong> Evidencia de la actividad desarrollada. Pueden ser: informes específicos, proyectos, planes, reportes, etc.
</div>

<div class="firma-section">
    <div class="firma-box">
        @if($formatoOnce->firma_coordinador)
            <img src="{{ public_path('storage/' . $formatoOnce->firma_coordinador) }}"
                 alt="Firma del Coordinador"
                 class="firma-image">
        @endif
        <div class="firma-line">
            Firma del coordinador
        </div>
    </div>
</div>
</body>
</html>
