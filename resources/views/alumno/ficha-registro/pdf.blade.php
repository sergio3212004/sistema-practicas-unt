<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASS - Ficha de Registro</title>
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

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .header h2 {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header h3 {
            font-size: 12px;
            font-weight: normal;
            margin-bottom: 3px;
            text-decoration: underline;
        }

        .header p {
            font-size: 10px;
            color: #666;
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
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
            padding: 6px 10px;
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

        .firmas-section {
            margin-top: 4px;
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
        }

        .firma-box {
            height: 45px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .firma-box img {
            max-height: 40px;
            max-width: 100%;
        }

        .firma-title {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .firma-subtitle {
            font-size: 9px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .horarios-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .horarios-table th,
        .horarios-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }

        .horarios-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>

<body>

{{-- HEADER --}}
<div class="header-with-logo">
    <img src="{{ public_path('images/UNT.png') }}" alt="Logo UNT" class="logo">
    <div class="header-text">
        <h1>FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS</h1>
        <h3 style="text-decoration: underline;">MONITOREO DE PRÁCTICAS PRE PROFESIONALES</h3>
        <p>FORMATO 01: FICHA DE REGISTRO</p>
    </div>
</div>

{{-- 1. ESTUDIANTE --}}
<div class="section">
    <div class="section-title">1. ESTUDIANTE</div>

    <div class="field">
        <div class="field-label">Apellidos y Nombres</div>
        <div class="field-value">{{ $fichaRegistro->alumno->nombre_completo }}</div>
    </div>

    <div class="grid-3">
        <div>
            <div class="field-label">Nro. Matrícula</div>
            <div class="field-value">{{ $fichaRegistro->alumno->codigo_matricula }}</div>
        </div>
        <div>
            <div class="field-label">Ciclo</div>
            <div class="field-value">{{ $fichaRegistro->ciclo }}</div>
        </div>
        <div>
            <div class="field-label">Semestre</div>
            <div class="field-value">{{ $fichaRegistro->semestre->nombre }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div>
            <div class="field-label">Teléfono</div>
            <div class="field-value">{{ $fichaRegistro->alumno->telefono }}</div>
        </div>
        <div>
            <div class="field-label">Correo</div>
            <div class="field-value">{{ $fichaRegistro->alumno->user->email }}</div>
        </div>
    </div>
</div>

{{-- 2. EMPRESA --}}
<div class="section">
    <div class="section-title">2. EMPRESA O INSTITUCIÓN</div>

    <div class="grid-2">
        <div>
            <div class="field-label">Razón Social</div>
            <div class="field-value">{{ $fichaRegistro->razon_social }}</div>
        </div>
        <div>
            <div class="field-label">RUC</div>
            <div class="field-value">{{ $fichaRegistro->ruc }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div>
            <div class="field-label">Gerente General</div>
            <div class="field-value">{{ $fichaRegistro->nombre_gerente }}</div>
        </div>
        <div>
            <div class="field-label">Jefe RRHH</div>
            <div class="field-value">{{ $fichaRegistro->nombre_jefe_rrhh }}</div>
        </div>
    </div>

    <div class="field">
        <div class="field-label">Dirección</div>
        <div class="field-value">{{ $fichaRegistro->direccion }}</div>
    </div>
</div>

{{-- 3. PRÁCTICA --}}
<div class="section">
    <div class="section-title">3. CARACTERÍSTICAS DE LA PRÁCTICA</div>

    <div class="grid-2">
        <div>
            <div class="field-label">Fecha de Inicio</div>
            <div class="field-value">{{ $fichaRegistro->fecha_inicio->format('d/m/Y') }}</div>
        </div>
        <div>
            <div class="field-label">Fecha de Término</div>
            <div class="field-value">{{ $fichaRegistro->fecha_termino->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="field">
        <div class="field-label">Descripción</div>
        <div class="field-value">{{ $fichaRegistro->descripcion }}</div>
    </div>

    <div class="grid-2">
        <div>
            <div class="field-label">Área de Prácticas</div>
            <div class="field-value">{{ $fichaRegistro->area_practicas }}</div>
        </div>
        <div>
            <div class="field-label">Cargo</div>
            <div class="field-value">{{ $fichaRegistro->cargo }}</div>
        </div>
    </div>

    @if($fichaRegistro->horarios && $fichaRegistro->horarios->count() > 0)
        <div class="field" style="margin-top: 10px;">
            <div class="field-label">Días y Horario:</div>
            <table class="horarios-table">
                @php
                    $diasNombres = ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'];
                    $horariosMap = array_fill(0, 6, null);

                    foreach($fichaRegistro->horarios as $h) {
                        $diaNum = (int)trim($h->dia_semana);
                        if ($diaNum >= 1 && $diaNum <= 6) {
                            $indice = $diaNum - 1;

                            // Parsear horas
                            $horaInicio = $h->hora_inicio;
                            $horaFin = $h->hora_fin;

                            if (strlen($horaInicio) > 5) {
                                try {
                                    $horaInicio = \Carbon\Carbon::parse($horaInicio)->format('H:i');
                                } catch (\Exception $e) {
                                    $horaInicio = substr($horaInicio, 11, 5);
                                }
                            }

                            if (strlen($horaFin) > 5) {
                                try {
                                    $horaFin = \Carbon\Carbon::parse($horaFin)->format('H:i');
                                } catch (\Exception $e) {
                                    $horaFin = substr($horaFin, 11, 5);
                                }
                            }

                            $horariosMap[$indice] = [
                                'inicio' => $horaInicio,
                                'fin' => $horaFin
                            ];
                        }
                    }
                @endphp
                <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">HORA</th>
                    @foreach($diasNombres as $dia)
                        <th style="text-align: center;">{{ $dia }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="text-align: center; font-weight: bold;">De/A</td>
                    @foreach($horariosMap as $horario)
                        <td style="text-align: center; font-size: 9px;">
                            @if($horario)
                                De: {{ $horario['inicio'] }}<br>
                                A: {{ $horario['fin'] }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- 4. FIRMAS --}}
<div class="firmas-section">
    <div class="section-title">4. FIRMAS</div>

    <div class="firmas-grid">
        {{-- FIRMA EMPRESA --}}
        <div class="firma-col">
            <div class="firma-title">Empresa</div>
            <div class="firma-box">
                @if($fichaRegistro->firma_empresa)
                    <img src="{{ storage_path('app/public/firmas/ficha-registro/' . $fichaRegistro->firma_empresa) }}"
                         alt="Firma Empresa">
                @else
                    <span style="color: #999; font-size: 10px;">No firmada</span>
                @endif
            </div>
            <div class="firma-subtitle">Representante Legal</div>
        </div>

        {{-- FIRMA PRACTICANTE (CENTRO) --}}
        <div class="firma-col">
            <div class="firma-title">Practicante</div>
            <div class="firma-box">
                @if($fichaRegistro->firma_practicante)
                    <img src="{{ storage_path('app/public/firmas/ficha-registro/' . $fichaRegistro->firma_practicante) }}"
                         alt="Firma Practicante">
                @else
                    <span style="color: #999; font-size: 10px;">No firmada</span>
                @endif
            </div>
            <div class="firma-subtitle">Alumno</div>
        </div>

        {{-- FIRMA PROGRAMA (DERECHA) --}}
        <div class="firma-col">
            <div class="firma-title">Programa</div>
            <div class="firma-box">
                @if($fichaRegistro->firma_programa)
                    <img src="{{ storage_path('app/public/firmas/ficha-registro/' . $fichaRegistro->firma_programa) }}"
                         alt="Firma Programa">
                @else
                    <span style="color: #999; font-size: 10px;">No firmada</span>
                @endif
            </div>
            <div class="firma-subtitle">Coordinador de Prácticas</div>
        </div>
    </div>
</div>

{{-- FECHA DE EMISIÓN --}}
<div style="position: fixed; bottom: 40px; right: 40px; font-size: 10px; color: #333;">
    <strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y') }}
</div>

</body>

</html>
