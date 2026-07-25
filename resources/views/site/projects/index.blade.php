@extends('layouts.app')
@section('title', 'Registro')
@section('content')

@section('content')
<section class="section-agents section-t8 home">
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-md-4">
                <h2 class="title-num-project">Proyecto: # {{$project->no_project}}</h2>
            </div>
            <div class="col-md-8">
                <a class="btn-4" href="https://api.whatsapp.com/send?phone={{ $project->phone_asesor }}&text=Hola, ...">Contactar asesor <i class="fa-brands fa-whatsapp"></i></a>
                <a class="btn-azul" href="mailto:{{ $project->email_customer }}">Enviar mail a mi asesor <i class="fa-solid fa-envelope"></i></a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8 ">
                <div class="row card-project" style="margin: 0;">
                    <h2 class="mb-5 tittles-project-view">Información general:</h2>
                    <table>
                        <tr>
                            <td><strong>Cliente:</strong></td>
                            <td>{{ $project->customer }}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado proyecto:</strong></td>
                            <td>
                                @if($project->state==0) <span class="badge  text-white bg-warning stado">En Ejecución</span> @endif
                                @if($project->state==1) <span class="badge  text-white bg-success stado">Finalizado</span> @endif
                                @if($project->state==2) <span class="badge  text-white bg-danger stado">Cancelado</span> @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de inicio</strong></td>
                            <td>{{ $project->created_at }}</td>
                        </tr>
                    </table>
                    <hr>
                    <table style="width: 100%;">
                                    @foreach($project->productos as $key=>$item)                                                
                                    <tr>
                                        <td style="width: 50%;">
                                            @if($project->easybuy==1)
                                                <img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="{{ asset('images/products/'.$item->imagen.'') }}"> 
                                            @else
                                            <img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="{{ asset('images/custom_request/'.$item->imagen.'') }}"> 
                                            @endif
                                            
                                        </td>
                                        <td style="width: 50%;">
                                            <label style="display: block;"><b>{{$item->producto}}</b></label>
                                            <label style="display: block;">{{$item->quantity}} uds</label>
                                            <label style="display: block;"><b>${{number_format($item->price, 0, 0, '.')}}</b></label>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </table>
                                    <hr>
                                    <table>
                                        <tr>
                                            <td><strong>Valor contrato:</strong></td>
                                            <td>${{number_format($total, 0, 0, '.')}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Entrega pactada:</strong></td>
                                            <td>{{ $project->date_shopping }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Información de envío:</strong></td>
                                            <td>{{ $project->information_shopping }}</td>
                                        </tr>
                                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row card-project" style="margin: 0;">
                    <h4 class="card-title tittles-project-view">Timeline del proyecto:</h4>
                    <ul class="timeline timeline-kn container">
                        <li class="timeline-item element" id='div_1'>
                            <span class="timeline-point timeline-point-indicator  timeline-kanbai-active">1</span>
                            <div class="timeline-event row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6 class="fw-700">Pedido confirmado</h6>
                                    </div>
                                    <p class="text-crete">{{$project->created_at}}</p>
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
                                                                <h6 class="fw-700">{{$item->description}}</h6>                                                                
                                                            </div>
                                                            <p class="text-crete">{{$project->created_at}}</p>
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

            
           
        </div>
        <div class="row mt-5">
        <div class="col-md-12 card-project">
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
