@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<!-- END SERVICES -->
<section class="section-agents section-t8 home">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active desk">
                <img src="{{ asset('images/banners/bannerdesk.png') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item active banner-mobile">
                <img src="{{ asset('images/banners/banner-mobile.png') }}" class="d-block w-100" alt="...">
            </div>
            
        </div> 
        <div class="container boton-sorteo">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <a  href="#" class="btn-suscribe-desk btn-sorteo">Juega el 24 de Diciembre</a>
                    </div>
                    
                    <div class="col-md-3"></div>
                </div>
            </div>     
    </div>
   
</section>


<section class="section-testimonials nav-arrow-a  mt-5" >
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <h2 class="mt-5 title-sorteo">Debes tener en cuenta las siguientes reglas antes de participar</h2>
                <p style="text-align: left;font-size: 16px;">Participantes que no cumplan las reglas del concurso serán automáticamente descalificados</p>
            </div>
            <div class="col-md-12">
                <ul class="list-sorteo">
                    <li><i class="fa-solid fa-check"></i>Solo se permite participar una vez por persona</li>
                    <li><i class="fa-solid fa-check"></i>Solo pueden participar beneficiarios del producto donde vení a la invitación a participar</li>
                    <li><i class="fa-solid fa-check"></i>Sube la foto de la publicación en LinkedIn como detallamos en las instrucciones donde te enteraste del concurso</li>
                    <li><i class="fa-solid fa-check"></i>El sorteo se realizará el día 24 de diciembre y él o la ganadora será publicado en esta página, así como el proceso de sorteo</li>
                </ul>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 contenedor-agenda">
                <div class="row">
                
                    <div class="col-md-4 text-center">
                        <div class="circle-logo-desk">
                            <img src="{{ asset('images/purple-calendar.png?'.rand()) }}"  class="img-agenda">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h2 class="title-form-sorteo">Participa aquí</h2>
                        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('inscripcion-sorteo') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="col-12 divinput-desk">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Nombre" id="name" name="name">
                                    <span class="missing_alert text-danger" id="name_alert"></span>
                                </div>
                            </div>
                            <div class="col-12 divinput-desk">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                                    <span class="missing_alert text-danger" id="email_alert"></span>
                                
                                </div>
                            </div>
                            <div class="col-12 divinput-desk">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Documento" id="document" name="document">
                                    <span class="missing_alert text-danger" id="document_alert"></span>                               
                                </div>
                            </div>
                            <div class="col-12 divinput-desk">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Telefono"  id="phone" name="phone">
                                    <span class="missing_alert text-danger" id="phone_alert"></span>
                                
                                </div>
                            </div>
                            <div class="col-12 divinput-desk">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Organizacion" id="organization" name="organization">
                                    <span class="missing_alert text-danger" id="organization_alert"></span>
                                
                                </div>
                            </div>

                            <div class="file-drop-area mb-4">
                                <label class="fake-btn">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span class="file-msg">Carga Foto</span>
                                </label>
                                <input class="file-input" type="file" id="file" name="file">
                                <span class="missing_alert text-danger" id="file_alert"></span>
                            </div>
                            <div class="col-12 text-center" style="margin-bottom: 25px;">
                                <button type="submit" class="btn-suscribe-desk">Enviar</button>
                            </div>
                        </form>   
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@push('scripts')
<script src="{{ asset('js/app/lottery/create.js') }}"></script>
<script>
$(document).ready(function() {

    var $fileInput = $('.file-input');
var $droparea = $('.file-drop-area');

// highlight drag area
$fileInput.on('dragenter focus click', function() {
  $droparea.addClass('is-active');
});

// back to normal state
$fileInput.on('dragleave blur drop', function() {
  $droparea.removeClass('is-active');
});

// change inner text
$fileInput.on('change', function() {
  var filesCount = $(this)[0].files.length;
  var $textContainer = $(this).prev();

  if (filesCount === 1) {
    // if single file is selected, show file name
    var fileName = $(this).val().split('\\').pop();
    $textContainer.text(fileName);
  } else {
    // otherwise show number of files
    $textContainer.text(filesCount + ' files selected');
  }
});

   

});

</script>
@endpush
