<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Firma – Ficha de Prácticas</title>
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

                        <!-- Título -->
                        <h1 style="color:#ffffff;font-size:28px;font-weight:700;margin:0;line-height:1.3;">
                            Solicitud de Firma Electrónica
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
                            Estimado/a <strong style="color:#1e40af;">{{ $token->ficha->nombre_gerente }}</strong>,
                        </p>

                        <!-- Mensaje principal -->
                        <div style="background-color:#eff6ff;border-left:4px solid #3b82f6;border-radius:8px;padding:20px;margin-bottom:30px;">
                            <p style="color:#1e40af;font-size:14px;line-height:1.6;margin:0;">
                                El alumno <strong>{{ $token->ficha->alumno->user->nombre }}</strong> ha registrado su Ficha de Registro de Prácticas Pre-Profesionales y requiere su firma electrónica como representante de la empresa <strong>{{ $token->ficha->razon_social }}</strong>.
                            </p>
                        </div>

                        <!-- Información institucional -->
                        <div style="background-color:#f9fafb;border-radius:8px;padding:20px;margin-bottom:30px;">
                            <table role="presentation" style="width:100%;">
                                <tr>
                                    <td style="padding:8px 0;width:120px;color:#6b7280;font-size:13px;font-weight:600;">Documento:</td>
                                    <td style="padding:8px 0;color:#1f2937;font-size:14px;font-weight:500;">Ficha de Registro de Prácticas</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;width:120px;color:#6b7280;font-size:13px;font-weight:600;">Alumno:</td>
                                    <td style="padding:8px 0;color:#1f2937;font-size:14px;font-weight:500;">{{ $token->ficha->alumno->user->nombre }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;width:120px;color:#6b7280;font-size:13px;font-weight:600;">Empresa:</td>
                                    <td style="padding:8px 0;color:#1f2937;font-size:14px;font-weight:500;">{{ $token->ficha->razon_social }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Botón de acción -->
                        <div style="text-align:center;margin:30px 0;">
                            <a href="{{ route('firmas.ficha-registro.show', $token->token) }}"
                               style="display:inline-block;background:linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);color:#ffffff;text-decoration:none;padding:16px 40px;border-radius:10px;font-weight:600;font-size:16px;box-shadow:0 4px 12px rgba(30,64,175,0.3);">
                                Firmar Documento Ahora
                            </a>
                        </div>

                        <!-- Advertencia de tiempo -->
                        <div style="background-color:#fef3c7;border-left:4px solid #f59e0b;border-radius:8px;padding:15px;margin:30px 0;">
                            <p style="color:#92400e;font-size:13px;margin:0;line-height:1.5;">
                                <strong>Importante:</strong> Este enlace tiene una validez de <strong>7 días</strong> a partir de hoy. Si no realiza la firma dentro de este plazo, el alumno deberá reenviar la solicitud.
                            </p>
                        </div>

                        <!-- Nota de seguridad -->
                        <div style="background-color:#f3f4f6;border-radius:8px;padding:20px;margin-top:30px;">
                            <p style="color:#1f2937;font-size:14px;margin:0 0 10px 0;font-weight:600;">
                                ¿No conoce esta solicitud?
                            </p>
                            <p style="color:#4b5563;font-size:14px;margin:0;line-height:1.6;">
                                Si usted no está autorizado a firmar en nombre de la empresa o no reconoce esta solicitud, por favor ignore este mensaje. No se realizará ninguna acción sin su validación explícita.
                            </p>
                        </div>

                        <!-- Problemas con el botón -->
                        <div style="margin-top:30px;padding-top:20px;border-top:1px solid #e5e7eb;">
                            <p style="color:#6b7280;font-size:12px;line-height:1.6;margin:0;">
                                Si tiene problemas para hacer clic en el botón, copie y pegue la siguiente URL en su navegador:
                            </p>
                            <p style="background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:12px;margin:10px 0 0 0;word-break:break-all;font-size:12px;color:#3b82f6;">
                                {{ url('/firmas/empresa/' . $token->token) }}
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
                                Por favor, no responda a este mensaje.
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
                    ¿Necesita soporte? Contacte con el coordinador de prácticas de la Escuela de Informática.
                </p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
