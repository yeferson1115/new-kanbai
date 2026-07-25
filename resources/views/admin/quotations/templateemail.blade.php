<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Kanbai</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td, h1, p, a { font-family: 'Segoe UI', Helvetica, Arial, sans-serif !important; }
    </style>
    <![endif]-->
    <style>
        /* Modern Sans-Serif Stack */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');

        body {
            margin: 0;
            padding: 0;
            background-color: #F1F5F9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        table { border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; }
       
        .main-card {
            background-color: #ffffff;
            border-radius: 32px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border: 1px solid #E2E8F0;
        }

        .btn-primary {
            background-color: #6366F1;
            color: #ffffff !important;
            padding: 18px 40px;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 600;
            display: inline-block;
            letter-spacing: -0.01em;
            transition: all 0.3s ease;
        }

        .badge {
            background-color: #EEF2FF;
            color: #6366F1;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        @media screen and (max-width: 600px) {
            .p-mobile { padding: 30px 20px !important; }
            .h1-mobile { font-size: 24px !important; }
        }
    </style>
</head>
<body style="background-color: #F8FAFC; padding: 50px 15px;">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="100%" max-width="600" style="max-width: 600px;" border="0" cellspacing="0" cellpadding="0">
                   
                    <!-- Header Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 40px;">
                            <img src="https://kanbai.co/images/logo/logo-kanbai-color.png" alt="Kanbai" width="130" style="display: block; filter: brightness(0.9);">
                        </td>
                    </tr>

                    <!-- Main Content Card -->
                    <tr>
                        <td class="main-card" style="background-color: #ffffff; border-radius: 32px; border: 1px solid #F1F5F9;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="p-mobile" style="padding: 50px 60px;">
                                       
                                        <!-- Welcome Section -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 12px;">
                                                    <span class="badge">Nueva Cotización</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 20px;">
                                                    <h1 class="h1-mobile" style="margin: 0; color: #0F172A; font-size: 30px; font-weight: 800; letter-spacing: -0.03em; line-height: 1.2;">
                                                        Hola, {{$name}}
                                                    </h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 40px;">
                                                    <p style="margin: 0; color: #64748B; font-size: 17px; line-height: 1.7;">
                                                        Hemos procesado tu solicitud con éxito. Adjunto encontrarás el PDF de tu cotización con todos los detalles y consideraciones.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Detail Box (Glassmorphism inspired) -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #F8FAFC; border-radius: 24px; border: 1px solid #F1F5F9; margin-bottom: 40px;">
                                            <tr>
                                                <td style="padding: 30px; text-align: center;">
                                                    <p style="margin: 0 0 8px 0; color: #94A3B8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Número de Cotización</p>
                                                    <h2 style="margin: 0; color: #1E293B; font-size: 26px; font-weight: 800;">COT-{{$id}}</h2>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Call to Action -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 40px;">
                                                    <a target="_blank" href="https://kanbai.co/ver-cotizacion/{{$uid}}" class="btn-primary" style="background-color: #6366F1; color: #ffffff; font-family: 'Inter', sans-serif;">
                                                        Revisar Cotización
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Divider & Secondary Contact -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="border-top: 1px solid #F1F5F9; padding-top: 40px; text-align: center;">
                                                    <p style="margin: 0 0 24px 0; color: #94A3B8; font-size: 14px; line-height: 1.6;">
                                                        ¿Tienes alguna duda técnica o comercial?<br>Nuestro equipo está listo para ayudarte en tiempo real.
                                                    </p>
                                                    <a target="_blank" href="https://wa.me/573502045177" style="color: #10B981; font-size: 15px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center;">
                                                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" width="18" style="vertical-align: middle; margin-right: 8px;">
                                                        Chat directo vía WhatsApp
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Minimal Footer -->
                    <tr>
                        <td align="center" style="padding-top: 40px;">
                            <p style="margin: 0; color: #94A3B8; font-size: 12px; font-weight: 500; letter-spacing: 0.01em;">
                                Enviado con ❤️ por el equipo de Kanbai
                            </p>
                            <p style="margin: 8px 0 0 0; color: #CBD5E1; font-size: 11px;">
                                Medellín, Colombia · kanbai.co
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
