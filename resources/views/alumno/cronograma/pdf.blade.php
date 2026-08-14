<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASS - Plan de Prácticas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 72px;
        }

        .header-with-logo {
            position: relative;
            text-align: center;
            margin-bottom: 2px;
            padding-bottom: 5px;
            padding-top: 0;
            min-height: 40px;
        }

        .logo {
            position: absolute;
            left: 11px;
            top: -58px;
            width: 145px;
            height: auto;
        }

        .header-text {
            text-align: center;
            padding-top: 10px;
        }

        .section {
            margin-bottom: 4px;
            padding: 5px 0;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
            padding: 4px 10px;
            background-color: #e8e8e8;
            border: 1px solid #999;
        }

        .field {
            margin-bottom: 5px;
        }

        .field-label {
            font-size: 10px;
            font-weight: bold;
            color: #555;
            margin-bottom: 2px;
        }

        .field-value {
            font-size: 11px;
            color: #000;
            padding: 4px 8px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .grid-2 {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .grid-2>div {
            display: table-cell;
            width: 50%;
            padding-right: 10px;
        }

        .grid-2>div:last-child {
            padding-right: 0;
        }

        .grid-3 {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .grid-3>div {
            display: table-cell;
            width: 33.33%;
            padding-right: 10px;
        }

        .grid-3>div:last-child {
            padding-right: 0;
        }

        /* Tabla de Actividades */
        .actividades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .actividades-table th,
        .actividades-table td {
            border: 1px solid #999;
            padding: 4px;
            text-align: center;
            font-size: 9px;
        }

        .actividades-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .actividades-table td.left-align {
            text-align: left;
        }

        .check-mark {
            color: green;
            font-weight: bold;
            font-size: 10px;
        }

        .firmas-section {
            margin-top: 20px;
            padding: 5px 0;
        }

        .firmas-grid {
            display: table;
            width: 100%;
            text-align: center;
        }

        .firma-col {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            vertical-align: top;
        }

        .firma-box {
            height: 60px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .firma-box img {
            max-height: 55px;
            max-width: 100%;
        }

        .firma-title {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

{{-- HEADER --}}
<div class="header-with-logo">
    <img src="{{ public_path('images/UNT.png') }}" alt="Logo UNT" class="logo">
    <div class="header-text">
        <h1>FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS</h1>
        <h3 style="text-decoration: underline;">PLAN DE PRÁCTICAS PRE PROFESIONALES</h3>
        <p>FORMATO 02: PLAN DE PRÁCTICAS</p>
    </div>
</div>

{{-- 1. ESTUDIANTE --}}
<div class="section">
    <div class="section-title">1. ESTUDIANTE</div>
    <div class="grid-2">
        <div>
            <div class="field-label">Apellidos y Nombres</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->alumno->nombre_completo }}</div>
        </div>
        <div>
            <div class="field-label">Nro. Matrícula</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->alumno->codigo_matricula }}</div>
        </div>
    </div>
    <div class="grid-2">
        <div>
            <div class="field-label">Ciclo</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->ciclo }}</div>
        </div>
        <div>
            <div class="field-label">Semestre</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->semestre->nombre ?? '-' }}</div>
        </div>
    </div>
</div>

{{-- 2. EMPRESA --}}
<div class="section">
    <div class="section-title">2. EMPRESA O INSTITUCIÓN</div>
    <div class="grid-2">
        <div>
            <div class="field-label">Razón Social</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->razon_social }}</div>
        </div>
        <div>
            <div class="field-label">RUC</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->ruc }}</div>
        </div>
    </div>
    <div class="field">
        <div class="field-label">Dirección</div>
        <div class="field-value">{{ $cronograma->fichaRegistro->direccion }}</div>
    </div>
</div>

{{-- 3. CARACTERÍSTICAS --}}
<div class="section">
    <div class="section-title">3. CARACTERÍSTICAS DE LA PRÁCTICA</div>
    <div class="grid-2">
        <div>
            <div class="field-label">Fecha de Inicio</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->fecha_inicio->format('d/m/Y') }}</div>
        </div>
        <div>
            <div class="field-label">Fecha de Término</div>
            <div class="field-value">{{ $cronograma->fichaRegistro->fecha_termino->format('d/m/Y') }}</div>
        </div>
    </div>
    <div class="field">
        <div class="field-label">Área de Prácticas</div>
        <div class="field-value">{{ $cronograma->fichaRegistro->area_practicas }}</div>
    </div>
</div>

{{-- 4. ACTIVIDADES --}}
<div class="section">
    <div class="section-title">4. ACTIVIDADES PRINCIPALES (Cronograma)</div>

    <table class="actividades-table">
        <thead>
        <tr>
            <th rowspan="2" style="width: 40%">ACTIVIDAD</th>
            <th colspan="4">MES 1</th>
            <th colspan="4">MES 2</th>
            <th colspan="4">MES 3</th>
            <th colspan="4">MES 4</th>
        </tr>
        <tr>
            @for($i = 1; $i <= 4; $i++)
                @for($j = 1; $j <= 4; $j++)
                    <th>S{{$j}}</th>
                @endfor
            @endfor
        </tr>
        </thead>
        <tbody>
        @foreach($cronograma->actividades as $act)
            <tr>
                <td class="left-align">{{ $act->actividad }}</td>
                @for($mes = 1; $mes <= 4; $mes++)
                    @for($sem = 1; $sem <= 4; $sem++)
                        @php
                            $col = "m{$mes}_s{$sem}";
                        @endphp
                        <td>
                            @if($act->$col)
                                <span class="check-mark">x</span>
                            @endif
                        </td>
                    @endfor
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- FIRMAS --}}
<div class="firmas-section">
    <div class="section-title">FIRMAS</div>
    <div class="firmas-grid">
        {{-- JEFE DIRECTO --}}
        <div class="firma-col">
            <div class="firma-title">Jefe Inmediato</div>
            <div class="firma-box">
                @if($cronograma->firma_jefe_directo)
                    <img src="{{ storage_path('app/public/' . $cronograma->firma_jefe_directo) }}" alt="Firma Jefe">
                @else
                    <span style="color:#999; font-size:9px;">No firmada</span>
                @endif
            </div>
            <p style="font-size:9px;">(Firma y Sello)</p>
        </div>

        {{-- PRACTICANTE --}}
        <div class="firma-col">
            <div class="firma-title">Practicante</div>
            <div class="firma-box">
                @if($cronograma->firma_practicante)
                    <img src="{{ storage_path('app/public/' . $cronograma->firma_practicante) }}"
                         alt="Firma Practicante">
                @else
                    <span style="color:#999; font-size:9px;">No firmada</span>
                @endif
            </div>
            <p style="font-size:9px;">(Firma)</p>
        </div>

        {{-- PROFESOR --}}
        <div class="firma-col">
            <div class="firma-title">Profesor Supervisor</div>
            <div class="firma-box">
                @if($cronograma->firma_profesor)
                    <img src="{{ storage_path('app/public/' . $cronograma->firma_profesor) }}" alt="Firma Profesor">
                @else
                    <span style="color:#999; font-size:9px;">No firmada</span>
                @endif
            </div>
            <p style="font-size:9px;">(Firma)</p>
        </div>
    </div>
</div>

<div style="text-align: right; margin-top: 40px; margin-right: 40px; font-size: 10px; color: #333;">
    <strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y') }}
</div>

</body>

</html>
