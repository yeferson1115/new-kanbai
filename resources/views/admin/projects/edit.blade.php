@extends('layouts.admin')

@section('title', 'Proyectos')
@section('page_title', 'Editar Proyecto')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: #{{ $project->id }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ $project->easybuy == 1 ? route('easygift.index') : route('projects.index') }}">
                                {{ $project->easybuy == 1 ? 'EasyGift' : 'Proyectos' }}
                                &nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item active">Editar: #{{ $project->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- En la sección donde está el timeline, después del timeline o en una sección visible --}}
@if($mostrarCronometro && $updaterequest)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="fa fa-clock-o"></i> Solicitud de Update Pendiente
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6><strong>{{ $updaterequest->titulo }}</strong></h6>
                        <p>{{ $updaterequest->mensaje }}</p>
                        <p class="mb-1">
                            <small>
                                <strong>Solicitado a:</strong> {{ $updaterequest->correo_vendedor }}
                            </small>
                        </p>
                        <p class="mb-0">
                            <small>
                                <strong>Fecha límite:</strong> 
                                {{ \Carbon\Carbon::parse($updaterequest->fecha_limite)->format('d/m/Y H:i') }}
                            </small>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-danger">Tiempo restante:</h5>
                            <div id="cronometro-container" class="display-4 text-danger">
                                <span id="cronometro-dias">00</span>d 
                                <span id="cronometro-horas">00</span>h 
                                <span id="cronometro-minutos">00</span>m 
                                <span id="cronometro-segundos">00</span>s
                            </div>
                            <input type="hidden" id="tiempo-restante" value="{{ $tiempoRestante }}">
                            <input type="hidden" id="update-request-id" value="{{ $updaterequest->id }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($updaterequest && $updaterequest->estado == 'vencido')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <h6><i class="fa fa-exclamation-triangle"></i> Solicitud de Update Vencida</h6>
            <p><strong>{{ $updaterequest->titulo }}</strong> - Vencida el {{ \Carbon\Carbon::parse($updaterequest->fecha_limite)->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>
@endif
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <!--<input type="hidden" id="_url" value="{{ url('solicitud-personalizada',[$project->encode_id]) }}">-->
                            <input type="hidden" id="_url" value="{{ route('updateproyect') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $project->encode_id }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2 class="mb-5">Información general:</h2>
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
                                                            @if($project->state==9) <span class="badge  text-white bg-info stado">Por Completar</span> @endif
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
                                                        @if($item->color)
                                                        <label style="display: block;">Color: <b>{{$item->color->name_color}}</b></label>
                                                        @endif
                                                        @if($item->talla)
                                                        <label style="display: block;">Talla: <b>{{$item->talla->talla}}</b></label>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </table>
                                                <hr>
                                                <table>

                                                @if(count($item->extras)>0)
                                                    <tr>
                                                        <td colspan="2">
                                                        <table class="table mb-2">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Extra</th>
                                                                    <th scope="col">Precio</th>
                                                                    <th scope="col">Cantidad</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($item->extras as $extra)
                                                            <tr>
                                                                <td>{{$extra->itemextra->name}}</td>
                                                                <td>${{number_format($extra->itemextra->price, 0, 0, '.')}}</td>
                                                                <td>{{$extra->quantity}}</td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        </td>  
                                                        </tr>                                                      
                                                        @endif  
                                                    <tr>
                                                                                                              
                                                        <td><strong>Valor contrato:</strong></td>
                                                        <td> @if($project->easybuy==1)
                                                            ${{number_format($project->total, 0, 0, '.')}}
                                                            @else
                                                            ${{number_format($total, 0, 0, '.')}}
                                                            @endif
                                                        </td>
                                                    </tr>                                                    
                                                    
                                                    <tr>
                                                        <td><strong>Entrega pactada:</strong></td>
                                                        <td>{{ $project->date_shopping }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Información de envío:</strong></td>
                                                        <td>{{ $project->information_shopping }}</td>
                                                    </tr>
                                                    @if($project->easybuy==1)
                                                    <tr>
                                                        <td><strong>Cliente:</strong></td>
                                                        <td>{{ $project->customer }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Documento:</strong></td>
                                                        <td>{{ $project->document }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td>{{ $project->email_customer }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Teléfono:</strong></td>
                                                        <td>{{ $project->cellphone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Dirección:</strong></td>
                                                        <td>{{ $project->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Ciudad:</strong></td>
                                                        <td>{{ $project->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Metodo de pago:</strong></td>
                                                        <td>{{ $project->payment_method }}</td>
                                                    </tr>
                                                    @if($project->upload_design!=null && $project->easybuy==1 )
                                                    <tr>
                                                        <td><strong>Diseño:</strong></td>
                                                        <td><img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="https://easygift.kanbai.co/design/{{ $project->upload_design}}"> </td>
                                                    </tr>
                                                    @endif
                                                    @if($project->information_shopping!=null && $project->easybuy==1)
                                                    <tr>
                                                        <td><strong>Mensaje:</strong></td>
                                                        <td>{{$project->information_shopping}}</td>
                                                    </tr>
                                                    @endif
                                                    @if($project->date_finish!=null)
                                                    <tr>
                                                        <td><strong>Fecha de finalización:</strong></td>
                                                        <td><span class="badge  text-white bg-danger stado">{{ $project->date_finish }}</span></td>
                                                    </tr>
                                                    @endif
                                                    
                                                    @endif
                                                   
                                                </table>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Timeline del {{ $project->easybuy == 1 ? 'EasyGift' : 'Proyecto' }}:</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="timeline timeline-kn container">
                                                            <li class="timeline-item element" id='div_1'>
                                                                <span class="timeline-point timeline-point-indicator @if($project->state==1) timeline-kanbai-active @else timeline-kanbai @endif">1</span>
                                                                <div class="timeline-event row">
                                                                    <div class="col-md-9">
                                                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                        <h6>Pedido confirmado</h6>                                                                
                                                                    </div>
                                                                    <p>{{$project->created_at}}</p>
                                                                    @if($project->state!=1)
                                                                    <div class="d-flex flex-row align-items-center">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="checkbox" id="confirmed" name="confirmed" value="1" >
                                                                            <label class="form-check-label" for="confirmed">Confirmar pedido</label>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    </div>
                                                                    <div class="col-md-3 col-12 pt-2 ">
                                                                    @can('Crear Proyectos')                                           
                                                                        <a href="#" title="Agregar" class="btn btn-success add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                    @endcan
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
                                                    </div>
                                                </div>
                                                <a class="btn btn-green" data-bs-toggle="modal" data-bs-target="#envioModal">
                                                    Notificar despacho <i class="fa fa-truck" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>                                  


                                    
                                   
                                </div> 
                                <div class="row mt-5">  
                                    @can('Crear Proyectos')       
                                        <div class="col-md-4 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="state">Estado</label>
                                                <select  id="state" name="state" class="form-control">
                                                    <option value="9" {{ ($project->state==9) ? "selected" : "" }}>Por Completar</option>
                                                    <option value="0" {{ ($project->state==0) ? "selected" : "" }}>En Ejecución</option>
                                                    <option value="2" {{ ($project->state==2) ? "selected" : "" }}>Cancelado</option>
                                                    <option value="1" {{ ($project->state==1) ? "selected" : "" }}>Finalizado</option>
                                                </select>
                                                <span class="missing_alert text-danger" id="state_alert"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-4 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="bussine_id">comercios</label>
                                                <select  id="bussine_id" name="bussine_id" class="form-control">
                                                    <option value="">Seleccione Comercio</option>
                                                    @foreach( $comercios as $key => $value )
                                                    <option value="{{ $value->id }}" {{ ($project->bussine_id==$value->id) ? "selected" : "" }}>{{ $value->company_name }}</option>
                                                    @endforeach                                                    
                                                </select>
                                                <span class="missing_alert text-danger" id="bussine_id_alert"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-4 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="seller_id">Vendedor</label>
                                                <select  id="seller_id" name="seller_id" class="form-control">
                                                    <option value="">Seleccione Vendedor</option>
                                                    @foreach( $vendedores as $key => $value )
                                                    <option value="{{ $value->id }}" {{ ($project->seller_id==$value->id) ? "selected" : "" }} >{{ $value->name }} {{ $value->lastname }}</option>
                                                    @endforeach                                                    
                                                </select>
                                                <span class="missing_alert text-danger" id="state_alert"></span>
                                            </div>
                                        </div> 

                                        @endcan
                                        <div class="col-md-3 col-12">
                                            <button style="margin-top: 25px;" type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
                                        </div>
                                       

                                    </div> 
                                    <div class="row">
                                        <!--<a href="/project/chat/{{ $project->encode_id }}" class="btn btn-chat">Abrir chat del proyecto</a>-->
                                        
                                    </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-5">
            
            <div class="card-body">
                <h5 class="card-title">
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-chat">Nuevo update</a>
                    @can('Administración')
                    <a href="#" data-bs-toggle="modal" data-bs-target="#solicitarUpdateModal" class="btn  btn-blue-1">Solicitar update</a>
                    @endcan
                </h5>
                @if(count($project->updates)>0)
                @foreach($project->updates as $key=>$item)
                <div class="row">
                    <div class="col-md-8">
                        <p>{{$item->description}}</p>
                        <p>{{$item->created_at}}</p>
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
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="form" role="form" id="main-form-updates" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" id="_url_update" value="{{ route('updatesproyect') }}">
            <input type="hidden" id="_token_update" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $project->encode_id }}">

        <div class="modal-body">
            <div class="mb-1">
                <label class="form-label" for="update_text">Escribe sobre el avance que tuvo el proyecto</label>
                <textarea  class="form-control" id="update_text" name="update_text" > </textarea>
                <span class="missing_alert text-danger" id="update_text_alert"></span>
            </div>
            <div class="mb-1">
                <label class="form-label" for="image_update">Imagen</label>
                <input type="file" class="form-control" id="image_update" name="image_update" >
                <span class="missing_alert text-danger" id="image_update_alert"></span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade" id="envioModal" tabindex="-1" aria-labelledby="envioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="envioForm" enctype="multipart/form-data">
        <input type="hidden" name="project_id" value="{{ $project->encode_id }}">
        <div class="modal-header">
          <h5 class="modal-title">Registrar Envío</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          
          <div class="mb-3">
            <label>Número de Guía</label>
            <input type="text" name="guia" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Empresa Transportadora</label>
            <input type="text" name="empresa" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Imágenes</label>
            <div id="imagenesContainer">
              <div class="input-group mb-2">
                <input type="file" name="imagenes[]" class="form-control" accept="image/*">
                <button type="button" class="btn btn-success btn-add-imagen">+</button>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label>Videos</label>
            <div id="videosContainer">
              <div class="input-group mb-2">
                <input type="file" name="videos[]" class="form-control" accept="video/*">
                <button type="button" class="btn btn-success btn-add-video">+</button>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Solicitar Update -->
<div class="modal fade" id="solicitarUpdateModal" tabindex="-1" aria-labelledby="solicitarUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="solicitarUpdateModalLabel">Solicitar Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" role="form" id="solicitar-update-form" autocomplete="off">
                <input type="hidden" id="_url_solicitar_update" value="{{ route('solicitar-update.store') }}">
                <input type="hidden" id="_token_solicitar_update" value="{{ csrf_token() }}">
                <input type="hidden" name="project_id" value="{{ $project->encode_id }}">
                <input type="hidden" name="vendedor_id" value="{{ $project->seller_id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="correo_vendedor">Correo del vendedor</label>
                        @php
                            $vendedorCorreo = '';
                            if($project->seller_id) {
                                $vendedor = $vendedores->where('id', $project->seller_id)->first();
                                $vendedorCorreo = $vendedor ? $vendedor->email : '';
                            }
                        @endphp
                        <input type="email" class="form-control" id="correo_vendedor" name="correo_vendedor" 
                               value="{{ $vendedorCorreo }}" required>
                    </div> 
                    <div class="mb-3">
                        <label class="form-label" for="fecha_limite">Fecha y hora límite</label>
                        <input type="datetime-local" class="form-control" id="fecha_limite" name="fecha_limite" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<script src="{{ asset('js/admin/solicitudpersonalizada/updates.js') }}"></script>
<script src="{{ asset('js/admin/solicitudpersonalizada/edit.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

// Agregar más campos de imagen
$(document).on('click', '.btn-add-imagen', function() {
  $('#imagenesContainer').append(`
    <div class="input-group mb-2">
      <input type="file" name="imagenes[]" class="form-control" accept="image/*">
      <button type="button" class="btn btn-danger btn-remove">-</button>
    </div>
  `);
});

// Agregar más campos de video
$(document).on('click', '.btn-add-video', function() {
  $('#videosContainer').append(`
    <div class="input-group mb-2">
      <input type="file" name="videos[]" class="form-control" accept="video/*">
      <button type="button" class="btn btn-danger btn-remove">-</button>
    </div>
  `);
});

// Eliminar campo
$(document).on('click', '.btn-remove', function() {
  $(this).closest('.input-group').remove();
});

// Validación y envío AJAX
$('#envioForm').on('submit', function(e) {
  e.preventDefault();

  let formData = new FormData(this);

  $.ajax({
    url: "{{ route('envios.store') }}", // Ruta en Laravel
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(res) {
      _alertGeneric('success','Muy bien! ','Guardado exitosamente','/projects');
      $('#envioForm')[0].reset();
      $('#envioModal').modal('hide');
    },
    error: function(err) {
      console.error(err);
      _alertGeneric('success','Muy bien! ','Ocurrio un Error al guardar',null);
    }
  });
});

});


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


$(document).ready(function() {
    // Formulario para solicitar update
    $('#solicitar-update-form').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        let url = $('#_url_solicitar_update').val();
        let token = $('#_token_solicitar_update').val();
        
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': token
            },
            beforeSend: function() {
                $('#solicitar-update-form button[type="submit"]').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...');
            },
            success: function(response) {
                if(response.success) {
                    _alertGeneric('success', '¡Éxito!', response.message, null);
                    $('#solicitarUpdateModal').modal('hide');
                    $('#solicitar-update-form')[0].reset();
                    
                    // Opcional: recargar la página o actualizar una sección específica
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    _alertGeneric('error', 'Error', response.message || 'Ocurrió un error', null);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Ocurrió un error al procesar la solicitud';
                
                if(errors) {
                    errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n';
                    });
                }
                
                _alertGeneric('error', 'Error', errorMessage, null);
            },
            complete: function() {
                $('#solicitar-update-form button[type="submit"]').prop('disabled', false)
                    .text('Enviar');
            }
        });
    });
    
    // Limpiar formulario cuando se cierre el modal
    $('#solicitarUpdateModal').on('hidden.bs.modal', function() {
        $('#solicitar-update-form')[0].reset();
    });
});

$(document).ready(function() {
    // Función para actualizar el cronómetro
    function actualizarCronometro() {
        let tiempoRestante = parseInt($('#tiempo-restante').val());
        
        if (tiempoRestante > 0) {
            tiempoRestante--;
            $('#tiempo-restante').val(tiempoRestante);
            
            // Calcular días, horas, minutos y segundos
            let dias = Math.floor(tiempoRestante / (24 * 60 * 60));
            let horas = Math.floor((tiempoRestante % (24 * 60 * 60)) / (60 * 60));
            let minutos = Math.floor((tiempoRestante % (60 * 60)) / 60);
            let segundos = tiempoRestante % 60;
            
            // Formatear con ceros a la izquierda
            dias = dias.toString().padStart(2, '0');
            horas = horas.toString().padStart(2, '0');
            minutos = minutos.toString().padStart(2, '0');
            segundos = segundos.toString().padStart(2, '0');
            
            // Actualizar display
            $('#cronometro-dias').text(dias);
            $('#cronometro-horas').text(horas);
            $('#cronometro-minutos').text(minutos);
            $('#cronometro-segundos').text(segundos);
            
            // Cambiar color cuando queden menos de 24 horas
            if (tiempoRestante < (24 * 60 * 60)) {
                $('#cronometro-container').removeClass('text-danger').addClass('text-warning');
            }
            
            // Cambiar color cuando queden menos de 1 hora
            if (tiempoRestante < (60 * 60)) {
                $('#cronometro-container').removeClass('text-warning').addClass('text-danger');
                $('#cronometro-container').addClass('blink'); // Añadir clase de parpadeo
            }
        } else {
            // Tiempo agotado
            clearInterval(cronometroInterval);
            $('#cronometro-container').html('<span class="text-danger">¡TIEMPO AGOTADO!</span>');
            
            // Actualizar estado en el servidor
            let updateRequestId = $('#update-request-id').val();
            if (updateRequestId) {
                $.ajax({
                    url: "{{ route('update-request.vencido') }}",
                    method: "POST",
                    data: {
                        id: updateRequestId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Recargar la página para mostrar el estado actualizado
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            }
        }
    }
    
    // Iniciar cronómetro si existe
    if ($('#tiempo-restante').length > 0) {
        let tiempoInicial = parseInt($('#tiempo-restante').val());
        
        // Actualizar inmediatamente
        actualizarCronometro();
        
        // Actualizar cada segundo
        let cronometroInterval = setInterval(actualizarCronometro, 1000);
    }
    
    // Estilo CSS para el parpadeo
    let style = document.createElement('style');
    style.innerHTML = `
        .blink {
            animation: blinker 1s linear infinite;
        }
        @keyframes blinker {
            50% {
                opacity: 0.5;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>

@endpush
