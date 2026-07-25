<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Kanbai</title>
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
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; }
       
        .main-card {
            background-color: #ffffff;
            border-radius: 32px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #E2E8F0;
        }

        .btn-primary {
            background-color: #6366F1;
            color: #ffffff !important;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            display: inline-block;
            font-size: 15px;
        }

        .badge {
            background-color: #ECFDF5;
            color: #10B981;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-label {
            color: #64748B;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .data-value {
            color: #0F172A;
            font-size: 14px;
            font-weight: 700;
        }

        @media screen and (max-width: 600px) {
            .p-mobile { padding: 30px 20px !important; }
            .stack-mobile { display: block !important; width: 100% !important; }
            .img-mobile { margin-bottom: 15px !important; width: 80px !important; }
        }
    </style>
</head>
<body style="background-color: #F8FAFC; padding: 40px 15px;">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="100%" max-width="600" style="max-width: 600px;" border="0" cellspacing="0" cellpadding="0">
                   
                    <!-- Logo Superior -->
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <img src="{{ asset('images/logo/logo-kanbai-color.png') }}" alt="Kanbai" width="120">
                        </td>
                    </tr>

                    <!-- Card Principal -->
                    <tr>
                        <td class="main-card" style="background-color: #ffffff; border-radius: 32px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="p-mobile" style="padding: 45px 50px;">
                                       
                                        <!-- Header Mensaje -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 12px;">
                                                    <span class="badge">Proyecto Iniciado 🚀</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 15px;">
                                                    <h1 style="margin: 0; color: #0F172A; font-size: 26px; font-weight: 800; letter-spacing: -0.02em; line-height: 1.2;">
                                                        ¡Hola, {{ $project['customer'] }}!
                                                    </h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 35px;">
                                                    <p style="margin: 0; color: #64748B; font-size: 15px; line-height: 1.6;">
                                                        Nos alegra darte la bienvenida. Ya hemos registrado los detalles iniciales y estamos listos para comenzar.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ID de Solicitud -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #F1F5F9; margin-bottom: 30px;">
                                            <tr>
                                                <td style="padding-bottom: 15px;">
                                                    <span style="color: #94A3B8; font-size: 13px;">Número de Solicitud:</span>
                                                    <span style="color: #1E293B; font-size: 13px; font-weight: 700; margin-left: 5px;">#{{ $project['id'] }}</span>
                                                </td>
                                            </tr>
                                        </table>
										@php
										$totalenvio=0;
										@endphp

                                        <!-- Detalle del Producto -->
										 @foreach($project->productos as $product)
											@php
												$packaging_unit_quantity = (float) ($product->packaging_unit_quantity ?? 0);
												$quantity_requested = (float) ($product->pivot->quantity ?? 0); // o el campo donde tengas la cantidad
												$shipping_price = (float) ($product->shipping_price ?? 0);

												if ($packaging_unit_quantity > 0) {
													$empaques = ceil($quantity_requested / $packaging_unit_quantity);
												} else {
													$empaques = 0;
												}

												$totalenvio += $shipping_price * $empaques;
											@endphp
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #F8FAFC; border-radius: 20px; border: 1px solid #F1F5F9; margin-bottom: 16px;">
                                            <tr>
                                                <td style="padding: 20px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="80" class="stack-mobile" valign="top">
                                                                <img src="{{ asset('images/custom_request/'.$product->imagen.'') }}" width="80" height="80" class="img-mobile" style="object-fit: cover; border: 1px solid #E2E8F0;">
                                                            </td>
                                                            <td style="padding-left: 20px;" class="stack-mobile" valign="top">
                                                                <h3 style="margin: 0 0 10px 0; color: #1E293B; font-size: 17px; font-weight: 700;">{{ $product->producto }}</h3>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style="padding-bottom: 8px;">
                                                                            <div class="data-label">Entrega</div>
                                                                            <div class="data-value">{{ $product->date_shopping }}</div>
                                                                        </td>
                                                                        <td style="padding-bottom: 8px; padding-left: 15px;">
                                                                            <div class="data-label">Cantidad</div>
                                                                            <div class="data-value">{{ $product->quantity }} unidades</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="data-label">Precio Unit.</div>
                                                                            <div class="data-value" style="color: #10B981;">${{number_format($product->price, 0, 0, '.')}}</div>
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

										@if($totalenvio > 0)
                                        <!-- Detalle Logístico -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #F8FAFC; border-radius: 20px; border: 1px solid #F1F5F9; margin-bottom: 30px;">
                                            <tr>
                                                <td style="padding: 20px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="80" class="stack-mobile" valign="top">
                                                                <div style="background-color: #EEF2FF; border-radius: 12px; width: 80px; height: 80px; text-align: center; line-height: 80px;">
                                                                    <img src="https://cdn-icons-png.flaticon.com/512/2830/2830305.png" width="36" style="vertical-align: middle;">
                                                                </div>
                                                            </td>
                                                            <td style="padding-left: 20px;" class="stack-mobile" valign="top">
                                                                <h3 style="margin: 0 0 10px 0; color: #1E293B; font-size: 17px; font-weight: 700;">Logística y Envío</h3>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style="padding-bottom: 8px;">
                                                                            <div class="data-label">Despachos</div>
                                                                            <div class="data-value">1 envío</div>
                                                                        </td>
                                                                        <td style="padding-bottom: 8px; padding-left: 15px;">
                                                                            <div class="data-label">Total Flete</div>
                                                                            <div class="data-value" style="color: #10B981;">${{number_format($totalenvio, 0, 0, '.')}}</div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
										@endif

                                        <!-- Botón de Acción Principal -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 40px;">
                                                    <a target="_blank" href="{{ url('mis-proyectos/'.$project['id']) }}" class="btn-primary">
                                                        Gestionar Proyecto
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Notas de Envío -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 40px;">
                                            <tr>
                                                <td style="background-color: #F9FAFB; border-radius: 20px; padding: 24px; border: 1px dashed #E2E8F0;">
                                                    <p style="margin: 0; color: #64748B; font-size: 13px; line-height: 1.6;">
                                                        <strong style="color: #475569;">Información de destino:</strong> {{ $project['information_shopping'] }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- SECCIÓN DE SOPORTE (Ahora dentro del card) -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #F1F5F9; padding-top: 40px;">
                                            <tr>
                                                <td align="center">
                                                    <p style="margin: 0; color: #64748B; font-size: 14px; line-height: 1.5;">¿Tienes alguna duda técnica o comercial?</p>
                                                    <p style="margin: 4px 0 24px 0; color: #94A3B8; font-size: 14px;">Nuestro equipo está listo para ayudarte en tiempo real.</p>
                                                   
                                                    <a target="_blank" href="https://api.whatsapp.com/send?phone={{ $project['phone_asesor'] }}&text=Hola, ..." style="text-decoration: none;">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td style="vertical-align: middle; padding-right: 10px;">
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

                    <!-- Pie de página Minimalista -->
                    <tr>
                        <td align="center" style="padding-top: 30px;">
                            <p style="margin: 0; color: #CBD5E1; font-size: 11px; letter-spacing: 0.02em;">
                                © 2026 KANBAI S.A.S. · MEDELLÍN, COLOMBIA · KANBAI.CO
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
