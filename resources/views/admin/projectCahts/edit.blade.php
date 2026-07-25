@extends('layouts.admin')

@section('title', 'Chat Proyecto')
@section('page_title', 'Chat del proyecto')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Chat Proyecto: #{{ $project->id }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/projects">Proyectos &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Chat Proyecto: #{{ $project->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <a  style="color: #7F00FF;" href="{{ url('project', [$project->encode_id,'edit']) }}" title="Volver al Proyecto">< Volver al Proyecto </a>
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="card card-bordered">
                                <div class="card-header">
                                    <h4 class="card-title"><strong>Notas del Proyecto #{{$project->id}}</strong></h4>                                        
                                </div>
                                <div class="ps-container ps-theme-default ps-active-y" id="chat-content" >
                                    @foreach($project->chat as $item)
                                    @if($item->type_sender==2)
                                    <div class="media media-chat media-chat-recive">                                       
                                        <div class="media-body">
                                            <p>{{$item->message}}</p> 
                                            @if($item->file!=null)
                                                <img style="max-width: 50%; border-radius: 30px;float: left;clear: left; border-radius: 30px;" class="mb-1" src="{{ asset('images/chats/'.$item->file.'') }}">
                                            @endif 
                                            <p class="meta"><time datetime="{{$item->created_at}}">{{$item->created_at}}</time></p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($item->type_sender==1)                                    
                                    <div class="media media-chat media-chat-reverse">
                                        <div class="media-body">
                                            <p>{{$item->message}}</p> 
                                            @if($item->file!=null)
                                                <img style="max-width: 50%; border-radius: 30px;float: right;clear: right; border-radius: 30px;" class="mb-1" src="{{ asset('images/chats/'.$item->file.'') }}">
                                            @endif                                           
                                            <p class="meta"><time datetime="{{$item->created_at}}">{{$item->created_at}}</time></p>
                                        </div>
                                    </div> 
                                    @endif
                                    @endforeach
                                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                                    </div>
                                </div>
                                <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                                    <input type="hidden" id="_url" value="{{ url('projectchat') }}">
                                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="type_sender" name="type_sender" value="1">
                                    <input type="hidden" id="project_id" name="project_id" value="{{$project->id}}">
                                    <div class="publisher bt-1 border-light">
                                        <img class="avatar avatar-xs" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                                        <input class="publisher-input" type="text" placeholder="Mensaje" name="message">
                                        <span class="missing_alert text-danger" id="message_alert"></span>
                                        <span class="publisher-btn file-group">
                                            <i class="fa fa-paperclip file-browser"></i>                                            
                                        </span>
                                        <input type="file" id="imagechat" style="display: none;" name="image">
                                        <a class="publisher-btn" href="#" data-abc="true"><i class="fa fa-smile"></i></a>
                                        <button type="submit" class="publisher-btn text-info" id="submit"><i class="fa fa-paper-plane"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')

<script src="{{ asset('js/admin/projectChat/create.js') }}"></script>
<script>
    $('.file-group').click(function() {
        open_file()
    });
    function open_file(){
      $('#imagechat').click();
  }

    
$(document).ready(function() {
    
    
 
    var iCnt=1;
// Crear un elemento div añadiendo estilos CSS
        var container = $(document.createElement('div'));

        $('#btAdd').click(function() {
            if (iCnt <= 19) {
                iCnt = iCnt + 1;
                // Añadir caja de texto.
                $(container).append('<div class="row" id="tb'+iCnt +'"><div class="col-md-6 col-12"><div class="mb-1"><label class="form-label" for="question">Pegunta</label><input type="text" class="form-control"  name="question[]" ></div></div><div class="col-md-6 col-12"><div class="mb-1"><label class="form-label" for="answer">Respuesta</label><textarea class="form-control"  name="answer[]" ></textarea></div></div></div>');

                if (iCnt == 1) {   

                var divSubmit = $(document.createElement('div'));
                    

                }

        $('#main').after(container, divSubmit); 
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                
                $(container).append('<label>Limite Alcanzado</label>'); 
                $('#btAdd').attr('class', 'bt-disable'); 
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function() {   // Elimina un elemento por click
            if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
        
            if (iCnt == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd').removeAttr('disabled'); 
                $('#btAdd').attr('class', 'bt btn-success btn') 

            }
        });
        
    });

    // Obtiene los valores de los textbox al dar click en el boton "Enviar"
    var divValue, values = '';

    function GetTextValue() {

        $(divValue).empty(); 
        $(divValue).remove(); values = '';

        $('.input').each(function() {
            divValue = $(document.createElement('div')).css({
                padding:'5px', width:'200px'
            });
            values += this.value + '<br />'
        });

        $(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
        $('body').append(divValue);

    }

$(document).ready(function(){

// Add new element
$(".add").click(function(){

 // Finding total number of elements added
 var total_element = $(".element").length;

 // last <div> with element class id
 var lastid = $(".element:last").attr("id");
 var split_id = lastid.split("_");
 var nextindex = Number(split_id[1]) + 1;

 var max = 15-{{count($project->timeline)}};
 // Check total number elements
 if(total_element < max ){
  // Adding new div container after last occurance of element class
  $(".element:last").after("<li class='timeline-item element' id='div_"+ nextindex +"'></li>");

  // Adding element to <div>
  $("#div_" + nextindex).append('<span class="timeline-point timeline-point-indicator timeline-kanbai ">'+nextindex+'</span><div class="row"><div class="col-md-8 col-12"><label class="form-label" for="description">Descripcion</label><input type="text" class="form-control" id="description" name="description[]" ><span class="missing_alert text-danger" id="description_alert"></span><label class="form-label" for="image">Imagen</label><input type="file" name="image[]"  class="form-control" placeholder="xxxx" id="txt_1" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="remove_'+nextindex+'" class="btn btn-danger remove" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div></div> ');

 }

});

// Remove element
$('.container').on('click','.remove',function(){

 var id = this.id;
 var split_id = id.split("_");
 var deleteindex = split_id[1];

 // Remove <div> with id
 $("#div_" + deleteindex).remove();

}); 
});

</script>

@endpush
