@extends('layouts.appuser')
@section('title', 'Mi perfil')
@section('content')

@section('content')

<section class="row">
    <div class="col-md-12" style="padding: 0px 30px;">
        <a href="javascript:history.back()" class="previos-profile">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
        
        <div class="container detailmobile">

    <!-- Usuarios -->
    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <div class="card-user" style="background: #ffff;border: none;">
                @if($project->comercio!=null && $project->comercio->asesor!=null)
                    
                    @if($project->comercio->asesor->photo!=null)
                            <img src="{{ asset('images/asesor/'.$project->comercio->asesor->photo.'') }}" class="img-fluid mb-3"  style="width: 130px;
        border-radius: 50%;
        height: 130px;"/><br>
                        
                            @endif
                <strong>{{$project->comercio->asesor->name}} {{$project->comercio->asesor->lastname}}</strong><br>   
                <small>Asesor comercial</small>
                <div class="contact-btns mt-2">
                    <a href="https://api.whatsapp.com/send?phone={{$project->comercio->asesor->whatsapp}}&text=Hola,%20..." class="btn btn-success btn-sm mb-2" style="background: #1ED161;border: none;padding-left: 15px;padding-right: 15px;">WhatsApp <i class="fa-brands fa-whatsapp"></i></a>
                    <a href="mailto:{{$project->comercio->asesor->email}}" class="btn btn-primary btn-sm" style="background: #1E85D1;border: none;padding-left: 15px;padding-right: 15px;">Correo <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </div>
                 @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-user" style="background: #ffff;border: none;">
                <strong>Felipe Restán Zuluaga</strong><br>
                <small>Gestión</small>
                <div class="contact-btns mt-2">
                    <a href="#" class="btn btn-success btn-sm mb-2" style="background: #1ED161;border: none;padding-left: 15px;padding-right: 15px;">WhatsApp <i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="btn btn-primary btn-sm" style="background: #1E85D1;border: none;padding-left: 15px;padding-right: 15px;">Correo <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info general y línea del tiempo -->
    <div class="row section-box" style="background: #ffff;border: none;margin: 0px; margin-bottom: 25px;">
        <div class="col-md-6">
            <h2 class="mt-5 mb-2 tittles-project-view" style="padding-left: 0;">Información general</h2>
            <p><strong>Cliente:</strong> {{$project->customer}}</p>
            <p><strong>Estado:</strong> <a href="#">En elaboración</a></p>
            <p class="mb-4"><strong>Fecha de creación:</strong> {{ \Carbon\Carbon::parse($project->created_at)->translatedFormat('F j, Y') }}</p>
            <hr>
            <table>
                @foreach($project->productos as $key=>$product)                                                
                <tr>
                    <td>
                         @if($project->easybuy==1)
                            <img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="{{ asset('images/products/'.$product->imagen.'') }}"> 
                        @else
                        <img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="{{ asset('images/custom_request/'.$product->imagen.'') }}"> 
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <label style="display: block;"><b>{{$product->producto}}</b></label>
                        <label style="display: block;">{{$product->quantity}} uds</label>
                        <label style="display: block;"><b>${{number_format($product->price, 0, 0, '.')}}</b></label>
                    </td>
                </tr>
                @endforeach
            </table>
            <hr>
            <p class="mt-4"><strong>Valor pedido:</strong> ${{number_format($total, 0, 0, '.')}}</p>
            <p><small>Fecha de entrega: {{ \Carbon\Carbon::parse($project->date_shopping)->translatedFormat('F j, Y') }}</small></p>
        </div>
        <div class="col-md-6">
            <h2 class="mt-5 mb-2 tittles-project-view" style="padding-left: 0;">Línea del proyecto</h2>
            <ul class="timeline timeline-kn container">
                <li class="timeline-item element" id='div_1'>
                    <span class="timeline-point timeline-point-indicator  timeline-kanbai-active">1</span>
                    <div class="timeline-event row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                <h6>Pedido confirmado</h6>                                                                
                            </div>
                            <p>{{$project->created_at}}</p>                          
                        </div>                                                                    
                    </div>
                </li>  
                @if(count($project->timeline)>0)
                    @foreach($project->timeline as $key=>$item)
                    <li class="timeline-item element" id='div_{{$key+2}}'>
                        <span class="timeline-point timeline-point-indicator  timeline-kanbai-active">{{$key+2}}</span>
                        <div class="timeline-event row">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                    <h6>{{$item->description}}</h6>                                                                
                                </div>
                                <p>{{$item->created_at}}</p>
                                @if($item->file!=null)
                                    <img style="max-width: 100%; border-radius: 30px;" class="mb-1" src="{{ asset('images/projects/'.$item->file.'') }}">
                                @endif
                            </div>                                                                    
                        </div>
                    </li> 
                    @endforeach
                @endif                                                
            </ul>
            
            @if($project->guia!=null)
                    <h2 class="mt-5 mb-2 tittles-project-view" style="padding-left: 0;">Evidencias despacho:</h2>
                    <table>
                        <tr>
                            <td>Número de guía:</td>
                            <td><strong>{{ $project->guia }}</strong></td>
                        </tr>
                        <tr>
                            <td>Empresa:</td>
                            <td><strong>{{ $project->empresa }}</strong></td>
                        </tr>
                        <tr>
                        <td>
                            @if ($project->imagenes)
                                @foreach ($project->imagenes as $img)
                                <img src="{{ asset($img) }}"
                 alt="imagen"
                 width="80"
                 height="80"
                 class="img-thumbnail img-ampliable me-2 mb-2 rounded"
                 style="object-fit: cover; cursor: zoom-in;">
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($project->videos)
                                @foreach ($project->videos as $vid)
                                    <video width="150" controls class="mb-2 me-2">
                                        <source src="{{ asset($vid) }}" type="video/mp4">
                                        Tu navegador no soporta videos.
                                    </video>
                                @endforeach
                            @endif
                        </td>
                        </tr>
                    </table>
                    @endif
        </div>
    </div>

    <!-- Updates -->
    <div class="section-box">
    <h2 class="mb-5 tittles-project-view">Updates de proyecto:</h2>
                <hr>
                @if(count($project->updates)>0)
                @foreach($project->updates as $key=>$item)
                <div class="row">
                    <div class="col-md-8">
                        <p>{{$item->description}}</p>
                        <p class="text-crete">{{$item->created_at}}</p>
                    </div>
                    <div class="col-md-4">
                    @if($item->file!=null)
                        <img style="max-width: 100%; border-radius: 30px;" class="mb-1" src="{{ asset('images/projects/'.$item->file.'') }}">
                    @endif
                    </div>
                </div>
                <hr>
                @endforeach
                @endif
    </div>

</div>
    </div>
</section>



<!-- Galería de imágenes -->
<div class="modal fade" id="modalGaleria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-dark bg-opacity-75 border-0">
      <div class="modal-body d-flex justify-content-center align-items-center position-relative p-0">
        
        <!-- Imagen principal -->
        <img id="imagenGaleria" src="" class="img-fluid rounded shadow" style="max-height: 90vh; max-width: 90vw;">

        <!-- Botón cerrar -->
        <button type="button" class="btn btn-light position-absolute top-0 end-0 m-3" data-bs-dismiss="modal">
          &times;
        </button>

        <!-- Botón anterior -->
        <button type="button" class="btn btn-light position-absolute start-0 top-50 translate-middle-y ms-3" id="anteriorImagen">
          ‹
        </button>

        <!-- Botón siguiente -->
        <button type="button" class="btn btn-light position-absolute end-0 top-50 translate-middle-y me-3" id="siguienteImagen">
          ›
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/app/user/create.js') }}"></script>
    <script>
let imagenesGaleria = [];
let indiceActual = 0;

$(document).on('click', '.img-ampliable', function() {
    // Recopilar todas las imágenes
    imagenesGaleria = $('.img-ampliable').map(function() {
        return $(this).attr('src');
    }).get();

    // Establecer imagen actual
    let src = $(this).attr('src');
    indiceActual = imagenesGaleria.indexOf(src);
    mostrarImagen(indiceActual);
    $('#modalGaleria').modal('show');
});

function mostrarImagen(indice) {
    $('#imagenGaleria').attr('src', imagenesGaleria[indice]);
}

// Botón siguiente
$('#siguienteImagen').click(function() {
    if (indiceActual < imagenesGaleria.length - 1) {
        indiceActual++;
        mostrarImagen(indiceActual);
    }
});

// Botón anterior
$('#anteriorImagen').click(function() {
    if (indiceActual > 0) {
        indiceActual--;
        mostrarImagen(indiceActual);
    }
});
</script>
@endpush
