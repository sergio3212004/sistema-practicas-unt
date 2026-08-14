<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Firma de Cronograma</title>
</head>
<body>

<p>Estimado/a,</p>

<p>
    El alumno ha registrado su <strong>Cronograma de Prácticas</strong>
    y requiere su firma en calidad de <strong>Jefe Directo</strong>.
</p>

<p>
    Para firmar el documento, haga clic en el siguiente enlace:
</p>

<p style="margin: 20px 0;">
    <a href="{{ route('firma.cronograma.jefe', $firmaToken->token) }}"
       style="padding: 10px 15px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 5px;">
        Firmar Cronograma
    </a>
</p>

<p>
    <strong>Este enlace es personal y de un solo uso.</strong><br>
    Fecha de expiración:
    {{ $firmaToken->expira_en->format('d/m/Y H:i') }}
</p>

<p>Saludos cordiales.</p>

<p>
    <small>
        Sistema de Gestión de Prácticas
    </small>
</p>

</body>
</html>
