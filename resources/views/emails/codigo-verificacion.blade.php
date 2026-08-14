<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 30px;
            margin: 20px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
        }
        .code-box {
            background-color: #ffffff;
            border: 2px solid #4f46e5;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #4f46e5;
            font-family: 'Courier New', monospace;
        }
        .info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Sistema de Prácticas UNT</h1>
        <p>Verificación de Registro de Empresa</p>
    </div>

    @if($nombreEmpresa)
        <p>Hola, <strong>{{ $nombreEmpresa }}</strong></p>
    @endif

    <p>Gracias por registrarte en nuestro sistema. Para completar tu registro, utiliza el siguiente código de verificación:</p>

    <div class="code-box">
        <div class="code">{{ $codigo }}</div>
    </div>

    <div class="info">
        <strong>⚠️ Importante:</strong>
        <ul style="margin: 10px 0; padding-left: 20px;">
            <li>Este código expira en 10 minutos</li>
            <li>No compartas este código con nadie</li>
            <li>Si no solicitaste este registro, ignora este email</li>
        </ul>
    </div>

    <p>Ingresa este código en la página de verificación para completar tu registro.</p>

    <div class="footer">
        <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        <p>&copy; {{ date('Y') }} Universidad Nacional de Trujillo - Sistema de Prácticas Preprofesionales</p>
    </div>
</div>
</body>
</html>
