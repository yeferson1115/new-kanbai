@extends('layouts.app')
@section('title', 'Registro')
@section('content')

@section('content')
<section class="section-agents section-t8 home">
    <div class="container">

        <div class="row mt-5">
            <div class="col-md-12">
                <!-- Cronómetro en una línea a la derecha -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div>
                        @if($updateRequest->titulo)
                            <p class="text-muted mb-0 mt-1">{{ $updateRequest->titulo }}</p>
                        @endif
                    </div>
                    
                    @if($mostrarCronometro)
                    <div class="timer-container-right" style="
                        background: #E85252;
                        color: #fff;
                        padding: 10px 20px;
                        border-radius: 30px;
                        display: inline-flex;
                        align-items: center;
                        gap: 10px;
                        white-space: nowrap;
                    ">
                        <span class="timer-label" style="font-size: 14px; margin-right: 5px;">
                            <i class="fa fa-clock-o"></i> Tiempo restante:
                        </span>
                        <div class="timer d-flex align-items-center gap-2" id="cronometro" style="
                            font-size: 18px;
                            font-weight: bold;
                        ">
                            <span id="horas">00</span>h 
                            <span id="minutos">00</span>m 
                            <span id="segundos">00</span>s
                        </div>
                        <input type="hidden" id="tiempo-restante" value="{{ $tiempoRestante }}">
                    </div>
                    @elseif($tiempoExpirado)
                    <div class="timer-container-right" style="
                        background: #6c757d;
                        color: #fff;
                        padding: 10px 20px;
                        border-radius: 30px;
                        display: inline-flex;
                        align-items: center;
                        gap: 10px;
                    ">
                        <i class="fa fa-exclamation-circle"></i>
                        <span>Tiempo expirado</span>
                    </div>
                    @endif
                </div>

                <div class="card" style="border: none; border-radius: 30px !important; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background: transparent; padding: 20px 30px 10px;">
                        <h4 class="mb-1" style="color:#636363;">
                            Proyecto #{{ $project->id }}
                        </h4>                        
                    </div>
                    
                    <div class="card-body" style="padding: 30px;">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 15px;">
                                <i class="fa fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 15px;">
                                <i class="fa fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if($updateRequest->estado === 'completado')
                            <!-- Mostrar alerta de completado como en la imagen -->
                            <div class="alert alert-success text-center d-flex align-items-center justify-content-center" 
                                 style="border-radius: 15px; background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                                <i class="fa fa-check-circle me-2" style="font-size: 1.5rem;"></i>
                                <strong style="font-size: 1.1rem;">¡Listo realizaste tu update!</strong>
                            </div>
                            
                            <!-- Mostrar el formulario deshabilitado con la información que ya se envió -->
                            <div class="completed-form-container">
                                <form id="update-form-disabled">
                                    <div class="mb-4">
                                        <p class="text-muted mb-0">Escribe sobre el avance que tuvo el proyecto</p>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="6" 
                                                  style="border-radius: 15px; padding: 15px; background-color: #f8f9fa;" 
                                                  disabled>{{ $updateRequest->descripcion ?? 'Descripción del avance enviado anteriormente' }}</textarea>                                    
                                    </div>
                                    
                                    <!-- Mostrar imágenes cargadas (si existen) -->
                                    @if(isset($updateRequest->imagenes) && count($updateRequest->imagenes) > 0)
                                    <div class="evidence-section mt-4" style="
                                        background: #f8f9fa;
                                        border-radius: 20px;
                                        padding: 25px;
                                    ">
                                        <h5 class="mb-3" style="color:#636363;">
                                            <i class="fa fa-image me-2"></i> Evidencias cargadas
                                        </h5>
                                        
                                        <div class="row">
                                            @foreach($updateRequest->imagenes as $imagen)
                                            <div class="col-md-3 mb-3">
                                                <div class="card" style="border-radius: 10px;">
                                                    <img src="{{ asset('images/projects/' . $imagen) }}" 
                                                         class="card-img-top" 
                                                         alt="Evidencia {{ $loop->iteration }}"
                                                         style="height: 150px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                                    <div class="card-body text-center">
                                                        <small class="text-muted">Imagen {{ $loop->iteration }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Botón para ir al proyecto -->
                                    <div class="d-flex justify-content-center align-items-center mt-5 pt-4" style="border-top: 1px solid #eee;">
                                        <a href="{{ url('project', [$project->encode_id,'edit']) }}" class="btn btn-outline-primary" 
                                           style="border-radius: 10px; padding: 10px 30px;">
                                            <i class="fa fa-arrow-right me-2"></i> Ir al proyecto
                                        </a>
                                    </div>
                                </form>
                            </div>
                            
                        @elseif($tiempoExpirado)
                            <div class="alert alert-warning text-center" style="border-radius: 15px;">
                                <i class="fa fa-clock-o me-2"></i>
                                <strong>¡Tiempo Expirado!</strong> El tiempo para responder a esta solicitud ha expirado.
                            </div>
                        @else
                            <!-- Formulario activo para responder -->
                            <form action="{{ route('update.solicitudupdate.store', $uid) }}" method="POST" 
                                  enctype="multipart/form-data" id="update-form">
                                @csrf
                                
                                <div class="mb-4">
                                    <p class="text-muted mb-0">Escribe sobre el avance que tuvo el proyecto</p>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="6" required style="border-radius: 15px; padding: 15px;">{{ old('descripcion') }}</textarea>                                    
                                </div>
                                
                                <div class="evidence-section mt-4" style="
                                    background: #f8f9fa;
                                    border-radius: 20px;
                                    padding: 25px;
                                ">
                                    <h5 class="mb-3" style="color:#636363;">
                                        <i class="fa fa-image me-2"></i> Carga algunas evidencias
                                    </h5>
                                    
                                    <!-- Imágenes -->
                                    <div class="mb-4">
                                        <label class="form-label mb-3 d-flex align-items-center">
                                            <span style="margin-right: 10px;">Imágenes</span>
                                            <small class="text-muted">(Formatos: JPG, PNG, GIF - Máx: 5MB)</small>
                                        </label>
                                        <div id="imagenes-container">
                                            <div class="row file-input-group">
                                                <div class="col-10">
                                                    <input type="file" name="imagenes[]" 
                                                           class="form-control" 
                                                           accept="image/*" 
                                                           style="border-radius: 10px;">
                                                    <div class="form-text mt-1">Seleccionar archivo</div>
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-success btn-add-imagen" 
                                                            style="border-radius: 10px; padding: 10px 15px;">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4" style="border-top: 1px solid #eee;">  
                                    <div>
                                        <button type="submit" class="btn btn-primary" id="submit-btn" 
                                                style="border-radius: 10px; padding: 10px 30px; background: linear-gradient(135deg, #7D71FF 0%, #7D71FF 100%); border: none;">
                                            <i class="fa fa-save me-2"></i> Guardar Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                
                @if(!$tiempoExpirado && $mostrarCronometro && $updateRequest->estado !== 'completado')
                <div class="footer text-center mt-4">
                    <p class="mb-0 text-muted">
                        <i class="fa fa-info-circle me-1"></i> 
                        Esta solicitud expira automáticamente al llegar a la fecha límite.
                        <br>
                        <small>Código: <strong>{{ $uid }}</strong></small>
                    </p>
                </div>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection

@push('styles')
<style>
    .blink {
        animation: blinker 1s linear infinite;
    }
    
    @keyframes blinker {
        50% { opacity: 0.5; }
    }
    
    .timer-container-right {
        box-shadow: 0 4px 10px rgba(232, 82, 82, 0.3);
        transition: all 0.3s ease;
    }
    
    .timer-container-right:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(232, 82, 82, 0.4);
    }
    
    #cronometro.text-danger {
        color: #ffd700 !important; /* Dorado para advertencia */
    }
    
    #cronometro.blink {
        animation: blinker 0.8s linear infinite;
    }
    
    @media (max-width: 768px) {
        .timer-container-right {
            flex-direction: column;
            padding: 15px;
            gap: 5px;
        }
        
        .timer-label {
            margin-right: 0 !important;
            margin-bottom: 5px;
        }
        
        .timer {
            font-size: 16px !important;
        }
        
        .completed-form-container .row .col-md-3 {
            width: 50%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Contador de tiempo restante (solo si no está completado)
        function actualizarCronometro() {
            let tiempoRestante = parseInt($('#tiempo-restante').val());
            
            if (tiempoRestante > 0) {
                tiempoRestante--;
                $('#tiempo-restante').val(tiempoRestante);
                
                // Calcular horas, minutos y segundos
                let horas = Math.floor(tiempoRestante / 3600);
                let minutos = Math.floor((tiempoRestante % 3600) / 60);
                let segundos = tiempoRestante % 60;
                
                // Formatear con ceros a la izquierda
                horas = horas.toString().padStart(2, '0');
                minutos = minutos.toString().padStart(2, '0');
                segundos = segundos.toString().padStart(2, '0');
                
                // Actualizar display
                $('#horas').text(horas);
                $('#minutos').text(minutos);
                $('#segundos').text(segundos);
                
                // Cambiar estilos según tiempo restante
                let cronometro = $('#cronometro');
                
                if (tiempoRestante < 3600) { // Menos de 1 hora
                    cronometro.removeClass('text-warning').addClass('text-danger');
                    if (tiempoRestante < 600) { // Menos de 10 minutos
                        cronometro.addClass('blink');
                    }
                } else if (tiempoRestante < 7200) { // Menos de 2 horas
                    cronometro.removeClass('text-danger').addClass('text-warning');
                } else {
                    cronometro.removeClass('text-danger text-warning blink');
                }
            } else {
                clearInterval(cronometroInterval);
                $('#cronometro').html('<span class="text-white">¡TIEMPO AGOTADO!</span>');
                $('#submit-btn').prop('disabled', true).addClass('btn-secondary');
                
                // Mostrar mensaje y deshabilitar formulario
                $('#update-form :input').prop('disabled', true);
                $('#update-form textarea').prop('disabled', true);
                
                // Mostrar alerta
                if (!$('.alert-warning').length) {
                    $('.card-body').prepend(`
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 15px;">
                            <i class="fa fa-exclamation-triangle me-2"></i>
                            <strong>¡Tiempo agotado!</strong> El tiempo para responder ha expirado.
                        </div>
                    `);
                }
            }
        }
        
        // Iniciar cronómetro si existe y no está completado
        let estado = "{{ $updateRequest->estado }}";
        if ($('#tiempo-restante').length > 0 && estado !== 'completado') {
            // Actualizar inmediatamente
            actualizarCronometro();
            
            // Actualizar cada segundo
            let cronometroInterval = setInterval(actualizarCronometro, 1000);
        }
        
        // Agregar más campos de imagen (solo si no está completado)
        if (estado !== 'completado') {
            $(document).on('click', '.btn-add-imagen', function() {
                if ($('#imagenes-container .row').length < 5) {
                    $('#imagenes-container').append(`
                        <div class="row file-input-group mt-2">
                            <div class="col-10">
                                <input type="file" name="imagenes[]" 
                                       class="form-control" 
                                       accept="image/*"
                                       style="border-radius: 10px;">
                                <div class="form-text mt-1">Seleccionar archivo</div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-danger btn-remove" 
                                        style="border-radius: 10px; padding: 10px 15px;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `);
                } else {
                    alert('Máximo 5 imágenes permitidas');
                }
            });
            
            // Eliminar campo
            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.row').remove();
            });
            
            // Validación del formulario
            $('#update-form').on('submit', function(e) {
                let descripcion = $('#descripcion').val().trim();
                
                if (descripcion.length < 10) {
                    e.preventDefault();
                    alert('La descripción debe tener al menos 10 caracteres');
                    $('#descripcion').focus();
                    return false;
                }
                
                // Verificar límite de tiempo
                let tiempoRestante = parseInt($('#tiempo-restante').val());
                if (tiempoRestante <= 0) {
                    e.preventDefault();
                    alert('El tiempo para responder ha expirado');
                    return false;
                }
                
                // Deshabilitar botón para evitar doble envío
                $('#submit-btn').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...');
                
                return true;
            });
            
            // Validar tamaño de archivos
            $('body').on('change', 'input[type="file"]', function() {
                let file = this.files[0];
                let maxSize = 5 * 1024 * 1024; // 5MB para imágenes
                
                if (file && file.size > maxSize) {
                    alert('El archivo es demasiado grande. Máximo permitido: 5MB');
                    $(this).val('');
                }
            });
            
            // Mostrar nombre del archivo seleccionado
            $('body').on('change', 'input[type="file"]', function() {
                let fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $(this).next('.form-text').text(fileName);
                }
            });
        }
    });
</script>
@endpush