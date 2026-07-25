<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Proyecto - Kanbai</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td, h1, p, a { font-family: 'Segoe UI', Helvetica, Arial, sans-serif !important; }
    </style>
    <![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        body {
            margin: 0;
            padding: 0;
            background-color: #F8FAFC;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        table { border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; border-radius: 12px; }
       
        .main-card {
            background-color: #ffffff;
            border-radius: 32px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #E2E8F0;
        }

        .btn-primary {
            background-color: #6366F1;
            color: #ffffff !important;
            padding: 18px 38px;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            display: inline-block;
            font-size: 15px;
            letter-spacing: -0.01em;
        }

        .badge {
            background-color: #EFF6FF;
            color: #3B82F6;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-label {
            color: #94A3B8;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .data-value {
            color: #1E293B;
            font-size: 14px;
            font-weight: 700;
        }

        .update-box {
            background-color: #F8FAFC;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid #F1F5F9;
            text-align: center;
        }

        @media screen and (max-width: 600px) {
            .p-mobile { padding: 35px 20px !important; }
            .stack-mobile { display: block !important; width: 100% !important; }
            .img-mobile { margin-bottom: 15px !important; width: 70px !important; }
        }
    </style>
</head>
<body style="background-color: #F8FAFC; padding: 40px 15px;">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="100%" max-width="600" style="max-width: 600px;" border="0" cellspacing="0" cellpadding="0">
                   
                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 35px;">
                            @if($project['easybuy']==1)
                            <img src="https://easygift.kanbai.co/images/logo/easygift.png" alt="Kanbai" width="125">
                            @else
                                <img src="{{ asset('images/logo/logo-kanbai-color.png') }}" alt="Kanbai" width="125">
                            @endif
                        </td>
                    </tr>

                    <!-- Card Principal -->
                    <tr>
                        <td class="main-card" style="background-color: #ffffff; border-radius: 32px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="p-mobile" style="padding: 50px 60px;">
                                       
                                        <!-- Header de Notificación -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 15px;">
                                                    <span class="badge">
                                                    @if($project['easybuy']==1)
                                                        Actualización de Pedido ⚡
                                                    @else
                                                        Actualización de Proyecto ⚡
                                                    @endif    
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 20px;">
                                                    <h1 style="margin: 0; color: #0F172A; font-size: 28px; font-weight: 800; letter-spacing: -0.03em; line-height: 1.1;">
                                                        ¡Hola, {{ $project['customer'] }}!
                                                    </h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 40px;">
                                                    <p style="margin: 0; color: #64748B; font-size: 16px; line-height: 1.6;">
                                                        @if($project['easybuy']==1)
                                                         Te enviamos esta notificación como actualización de tu pedido <strong>#{{ $project['id'] }}</strong>. Tu proyecto sigue avanzando según lo planeado.
                                                        @else
                                                            Te enviamos esta notificación como actualización de tu pedido <strong>#{{ $project['id'] }}</strong>. Tu proyecto sigue avanzando según lo planeado.
                                                        @endif   
                                                       
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Bloque de Novedad (Update) -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 40px;">
                                            <tr>
                                                <td class="update-box">
                                                    <!-- Se eliminó el estilo Italic para cumplir con el estándar de UI solicitado -->
                                                    <p style="margin: 0; color: #1E293B; font-size: 17px; font-weight: 600; line-height: 1.6;">
                                                        "{{ $data['description'] }}"
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Botón de Estado -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 50px;">
                                                    @if($project['easybuy']==1)
                                                         <a target="_blank" href="https://easygift.kanbai.co/mis-proyectos/{{ $project['id'] }}" class="btn-primary">
                                                            Consultar Estado del Proyecto
                                                        </a>
                                                        @else
                                                            <a target="_blank" href="{{ url('mis-proyectos/'.$project['id']) }}" class="btn-primary">
                                                                Consultar Estado del Proyecto
                                                            </a>
                                                        @endif 

                                                    
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Resumen de Productos -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 12px;">
                                            <tr>
                                                <td>
                                                    <p style="margin: 0 0 15px 0; color: #0F172A; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Resumen de solicitud</p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Productos -->
										 @foreach($project->productos as $items)
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #F8FAFC; border-radius: 20px; border: 1px solid #F1F5F9; margin-bottom: 12px;">
                                            <tr>
                                                <td style="padding: 18px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="70" class="stack-mobile" valign="top">
                                                                <img src="https://via.placeholder.com/70x70/6366F1/FFFFFF?text=Item" width="70" height="70" class="img-mobile" style="object-fit: cover; border: 1px solid #E2E8F0;">
                                                            </td>
                                                            <td style="padding-left: 18px;" class="stack-mobile" valign="top">
                                                                <h3 style="margin: 0 0 8px 0; color: #1E293B; font-size: 16px; font-weight: 700;">{{ $items['producto'] }}</h3>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="data-label">Entrega</div>
                                                                            <div class="data-value">{{ $project['date_shopping'] }}</div>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <div class="data-label">Cant.</div>
                                                                            <div class="data-value">{{ $items['quantity'] }} und</div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
									@endforeach                                      

                                        <!-- SECCIÓN DE SOPORTE INTEGRADA (ESTILO VANGUARDISTA) -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #F1F5F9; padding-top: 45px; text-align: center;">
                                            <tr>
                                                <td>
                                                    <p style="margin: 0; color: #64748B; font-size: 14px; line-height: 1.5;">¿Tienes alguna duda técnica o comercial?</p>
                                                    <p style="margin: 4px 0 25px 0; color: #94A3B8; font-size: 14px;">Nuestro equipo está listo para ayudarte en tiempo real.</p>
                                                   
                                                    <a target="_blank"  href="https://api.whatsapp.com/send?phone={{ $project['phone_asesor'] }}&text=Hola, ..." style="text-decoration: none; display: inline-block;">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td style="vertical-align: middle; padding-right: 12px;">
                                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" width="22" height="22" alt="WhatsApp">
                                                                </td>
                                                                <td style="vertical-align: middle;">
                                                                    <span style="color: #10B981; font-size: 16px; font-weight: 700; letter-spacing: -0.01em;">Chat directo vía WhatsApp</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer Minimalista -->
                    <tr>
                        <td align="center" style="padding-top: 35px;">
                            <p style="margin: 0; color: #CBD5E1; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
                                © 2026 KANBAI S.A.S. · KANBAI.CO
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>

