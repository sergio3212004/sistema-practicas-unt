<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body style="margin:0;padding:0;font-family:'Figtree',system-ui,-apple-system,sans-serif;background-color:#f3f4f6;">
<table role="presentation" style="width:100%;border-collapse:collapse;background-color:#f3f4f6;">
    <tr>
        <td style="padding:40px 20px;">
            <!-- Contenedor principal -->
            <table role="presentation" style="max-width:600px;margin:0 auto;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

                <!-- Header con gradiente azul UNT -->
                <tr>
                    <td style="background:linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);padding:40px 30px;text-align:center;position:relative;">
                        <!-- Patrón decorativo -->
                        <div style="position:absolute;top:0;right:0;width:120px;height:120px;background:rgba(255,255,255,0.05);border-radius:50%;margin-top:-60px;margin-right:-60px;"></div>
                        <div style="position:absolute;bottom:0;left:0;width:90px;height:90px;background:rgba(255,255,255,0.05);border-radius:50%;margin-bottom:-45px;margin-left:-45px;"></div>

                        <!-- Logo -->
{{--                        <div style="background-color:#ffffff;border-radius:16px;padding:20px;display:inline-block;box-shadow:0 8px 16px rgba(0,0,0,0.15);margin-bottom:20px;position:relative;">
                            <img src="{{ asset('logo-informatica.png') }}"
                                 alt="Logo Ingeniería Informática UNT"
                                 style="width:100px;height:100px;display:block;">
                        </div>--}}

                        <!-- Título -->
                        <h1 style="color:#ffffff;font-size:28px;font-weight:700;margin:0;line-height:1.3;">
                            Restablecer Contraseña
                        </h1>
                        <p style="color:#cbd5e1;font-size:14px;margin:10px 0 0 0;">
                            Sistema de Prácticas Pre Profesionales
                        </p>
                        <p style="color:#cbd5e1;font-size:14px;margin:10px 0 0 0;">
                            Universidad Nacional de Trujillo
                        </p>
                        <p style="color:#cbd5e1;font-size:14px;margin:10px 0 0 0;">
                            Escuela de Informática
                        </p>
                    </td>
                </tr>

                <!-- Contenido principal -->
                <tr>
                    <td style="padding:40px 30px;">
                        <!-- Saludo -->
                        <p style="color:#1f2937;font-size:16px;line-height:1.6;margin:0 0 20px 0;">
                            Estimado/a <strong style="color:#1e40af;">{{ $user->name ?? 'usuario' }}</strong>,
                        </p>

                        <!-- Mensaje principal -->
                        <div style="background-color:#eff6ff;border-left:4px solid #3b82f6;border-radius:8px;padding:20px;margin-bottom:30px;">
                            <p style="color:#1e40af;font-size:14px;line-height:1.6;margin:0;">
                                <strong>Hemos recibido una solicitud</strong> para restablecer tu contraseña en el sistema de Prácticas Pre-Profesionales de la Escuela de Ingeniería Informática.
                            </p>
                        </div>

                        <!-- Información institucional -->
                        <div style="background-color:#f9fafb;border-radius:8px;padding:20px;margin-bottom:30px;">
                            <table role="presentation" style="width:100%;">
                                <tr>
                                    <td style="padding:8px 0;width:100px;color:#6b7280;font-size:13px;font-weight:600;">Sistema:</td>
                                    <td style="padding:8px 0;color:#1f2937;font-size:14px;font-weight:500;">Prácticas Pre-Profesionales</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;width:100px;color:#6b7280;font-size:13px;font-weight:600;">Facultad:</td>
                                    <td style="padding:8px 0;color:#1f2937;font-size:14px;font-weight:500;">Escuela de Ingeniería Informática</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;width:100px;color:#6b7280;font-size:13px;font-weight:600;">Universidad:</td>
                                    <td style="padding:8px 0;color:#1f2937;font-size:14px;font-weight:500;">Universidad Nacional de Trujillo</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Botón de acción -->
                        <div style="text-align:center;margin:30px 0;">
                            <a href="{{ $url }}"
                               style="display:inline-block;background:linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);color:#ffffff;text-decoration:none;padding:16px 40px;border-radius:10px;font-weight:600;font-size:16px;box-shadow:0 4px 12px rgba(30,64,175,0.3);">
                                Restablecer mi contraseña
                            </a>
                        </div>

                        <!-- Advertencia de tiempo -->
                        <div style="background-color:#fef3c7;border-left:4px solid #f59e0b;border-radius:8px;padding:15px;margin:30px 0;">
                            <p style="color:#92400e;font-size:13px;margin:0;line-height:1.5;">
                                <strong>Importante:</strong> Este enlace tiene una validez de <strong>60 minutos</strong>. Después de este tiempo, deberás solicitar uno nuevo.
                            </p>
                        </div>

                        <!-- Nota de seguridad -->
                        <div style="background-color:#f3f4f6;border-radius:8px;padding:20px;margin-top:30px;">
                            <p style="color:#1f2937;font-size:14px;margin:0 0 10px 0;font-weight:600;">
                                ¿No realizaste esta solicitud?
                            </p>
                            <p style="color:#4b5563;font-size:14px;margin:0;line-height:1.6;">
                                Si no solicitaste restablecer tu contraseña, puedes ignorar este correo de forma segura. Tu cuenta permanecerá protegida y no se realizará ningún cambio.
                            </p>
                        </div>

                        <!-- Problemas con el botón -->
                        <div style="margin-top:30px;padding-top:20px;border-top:1px solid #e5e7eb;">
                            <p style="color:#6b7280;font-size:12px;line-height:1.6;margin:0;">
                                Si tienes problemas para hacer clic en el botón, copia y pega la siguiente URL en tu navegador:
                            </p>
                            <p style="background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:12px;margin:10px 0 0 0;word-break:break-all;font-size:12px;color:#3b82f6;">
                                {{ $url }}
                            </p>
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color:#1e3a8a;padding:30px;text-align:center;">
                        <p style="color:#cbd5e1;font-size:14px;font-weight:600;margin:0 0 8px 0;">
                            Universidad Nacional de Trujillo
                        </p>
                        <p style="color:#94a3b8;font-size:13px;margin:0 0 15px 0;">
                            Escuela de Informática
                        </p>

                        <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:20px;margin-top:20px;">
                            <p style="color:#94a3b8;font-size:11px;margin:0;line-height:1.5;">
                                Este correo fue enviado automáticamente por el Sistema de Prácticas Pre-Profesionales.<br>
                                Por favor, no respondas a este mensaje.
                            </p>
                        </div>

                        <div style="margin-top:20px;">
                            <p style="color:#64748b;font-size:10px;margin:0;">
                                © {{ date('Y') }} Universidad Nacional de Trujillo. Todos los derechos reservados.
                            </p>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Espaciado inferior -->
            <div style="text-align:center;margin-top:30px;">
                <p style="color:#9ca3af;font-size:12px;margin:0;">
                    ¿Necesitas ayuda? Contacta con soporte técnico
                </p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
