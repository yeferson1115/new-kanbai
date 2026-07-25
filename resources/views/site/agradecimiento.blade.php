@extends('layouts.app')
@section('title', 'Agradecimiento')
@section('content')

<section class="section-t8 mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            
            <!-- Columna izquierda (texto + imagen) -->
            <div class="col-12 col-md-6 text-center">
                <a href="{{ url('/') }}" class="d-block mb-3 fw-bold link-volver">
                    ← Volver al inicio
                </a>
                
                <h3 class="fw-bold text-gris mt-4">¡Recibimos tu solicitud!</h3>
                <p class="text-muted text-gris px-3">
                    Ya comenzamos a trabajar en tu cotización, en minutos la tendrás en tu correo electrónico.
                </p>

                <img src="{{ asset('images/comercio.png') }}" 
                     alt="Gracias" class="img-fluid mt-3" style="max-width:250px;">

                <!-- Botones en mobile -->
                <div class="row mt-4 d-md-none">
                    <p class="fw-bold mb-4 text-gris">
                        No dudes en contactarnos si necesitas ayuda:
                    </p>
                    <div class="col-6">
                        <a href="https://wa.me/573502045177" 
                           class="btn whatsapp-asesor w-100" target="_blank">
                            WhatsApp <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="mailto:ventas@kanbai.co" 
                           class="btn email-asesor w-100">
                            Correo <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Columna derecha (solo desktop) -->
            <div class="col-md-4 text-center d-none d-md-block">
                <div class="p-4 bg-light rounded-3 shadow-sm card-agradecimiento">
                    <p class="fw-bold mb-4 text-gris">
                        No dudes en contactarnos si<br> necesitas ayuda:
                    </p>
                    
                    <a href="https://wa.me/573502045177" 
                       class="btn whatsapp-asesor w-100 mb-3" target="_blank">
                        WhatsApp <i class="bi bi-whatsapp"></i>
                    </a>

                    <a href="mailto:ventas@kanbai.co" 
                       class="btn email-asesor w-100">
                        Correo <i class="bi bi-envelope"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
