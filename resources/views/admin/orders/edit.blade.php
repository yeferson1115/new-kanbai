@extends('layouts.admin')

@section('title', 'Ordenes')
@section('page_title', 'Editar Orden')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: {{ $order->name }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/ordenes">Ordenes &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: {{ $order->name }}</li>
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
                    <div class="card-header">
                        <h4 class="card-title">Editar Orden</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" id="_url" value="{{ url('ordenes',[$order->encode_id]) }}">                            
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $order->encode_id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="reference">Referencia</label>
                                        <input type="text" class="form-control" id="reference" name="reference" placeholder="Referencia" value="{{ $order->reference }}" readonly >
                                        <span class="missing_alert text-danger" id="reference_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="payment_method">Metodo de Pago</label>
                                        <input type="text" class="form-control" id="payment_method" name="payment_method" placeholder="Metodo de PAgo" value="{{ $order->payment_method }}" readonly >
                                        <span class="missing_alert text-danger" id="payment_method_alert"></span>
                                    </div>                                    
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="total">Total Orden</label>
                                        <input type="text" class="form-control" id="total" name="total" placeholder="Total" value="{{ $order->total }}" readonly >
                                        <span class="missing_alert text-danger" id="total_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="date_delivery">Fecha de Entrega</label>
                                        <input type="text" class="form-control" id="date_delivery" name="date_delivery" placeholder="Fecha Entrega" value="{{ $order->date_delivery }}" readonly >
                                        <span class="missing_alert text-danger" id="date_delivery_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="observation">Observaciones</label>
                                        <textarea class="form-control" id="observation" name="observation"  readonly >{{ $order->observation }}</textarea>
                                        <span class="missing_alert text-danger" id="observation_alert"></span>
                                    </div>
                                </div>
                                <h2>Productos</h2>
                                <div class="col-md-12 mb-1">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Talla</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">Valor Unidad</th>
                                                <th scope="col">Sub Total</th>
                                                <th scope="col">Adicionales</th>
                                                <th scope="col">Vendido Por</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $key=>$item)
                                                <tr>
                                                    <th scope="row">{{$key+1}}</th>
                                                    <td>{{$item->producto->name}}</td>
                                                    <td>{{$item->quantity}}</td>
                                                    <td>
                                                        @if($item->talla)
                                                        {{$item->talla->talla}}
                                                        @else
                                                        N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->color)
                                                        {{$item->color->name_color}}
                                                        @else
                                                        N/A
                                                        @endif
                                                    </td>
                                                    <td>${{number_format($item->price_unit, 0, 0, '.')}}</td>
                                                    <td>${{number_format($item->price_unit*$item->quantity, 0, 0, '.')}}</td>
                                                    
                                                    @if(count($item->extras)>0)
                                                        <td>
                                                        <table class="table">
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
                                                        @else
                                                        <td>N/A</td>
                                                        @endif

                                                    <td>{{$item->comercio->name}}</td>
                                                </tr>
                                                @endforeach                                               
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <h2 class="mt-3">Datos Cliente</h2>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre Cliente</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre Cliente" value="{{ $order->name }}" readonly >
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type_document">Tipo Documento</label>
                                        <input type="text" class="form-control" id="type_document" name="type_document" placeholder="Tipo Documento" value="{{ $order->type_document }}" readonly >
                                        <span class="missing_alert text-danger" id="type_document_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="document">Documento</label>
                                        <input type="text" class="form-control" id="document" name="document" placeholder="Documento" value="{{ $order->document }}" readonly >
                                        <span class="missing_alert text-danger" id="document_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="cellphone">Celular</label>
                                        <input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="Celular" value="{{ $order->cellphone }}" readonly >
                                        <span class="missing_alert text-danger" id="cellphone_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="address">Dirección</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="{{ $order->address }}" readonly >
                                        <span class="missing_alert text-danger" id="address_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city">Ciudad</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Dirección" value="{{ $order->city }}" readonly >
                                        <span class="missing_alert text-danger" id="city_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">E-mail</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Dirección" value="{{ $order->email }}" readonly >
                                        <span class="missing_alert text-danger" id="email_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="state">Nombre Empresa</label>
                                        <input type="text" class="form-control" id="name_business" name="name_business" placeholder="Dirección" value="{{ $order->name_business }}" readonly >
                                        <span class="missing_alert text-danger" id="name_business_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="state">Estado</label>
                                        <select  class="form-control" id="state" name="state"  >
                                            <option value="1" {{ ($order->state==1)? "selected" : "" }}>Ordenada</option>
                                            <option value="2" {{ ($order->state==2)? "selected" : "" }}>Pendiente Por Pago</option>
                                            <option value="3" {{ ($order->state==3)? "selected" : "" }}>En Proceso</option>
                                            <option value="4" {{ ($order->state==4)? "selected" : "" }}>Despachada</option>
                                            <option value="5" {{ ($order->state==5)? "selected" : "" }}>Entregada</option>
                                            <option value="0" {{ ($order->state==0)? "selected" : "" }}>Cancelada</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="state_alert"></span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-7">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Timeline del proyecto:</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="timeline timeline-kn container">
                                                    <li class="timeline-item element" id='div_1'>
                                                        <span class="timeline-point timeline-point-indicator @if($order->state==1) timeline-kanbai-active @else timeline-kanbai @endif">1</span>
                                                        <div class="timeline-event row">
                                                            <div class="col-md-9">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>Pedido ordenado</h6>                                                                
                                                            </div>
                                                            <p>{{$order->created_at}}</p>
                                                          
                                                            </div>
                                                            <div class="col-md-3 col-12 pt-2 ">                                           
                                                                <a href="#" title="Agregar" class="btn btn-success add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </li> 
                                                    @if(count($order->timeline)>0)
                                                        @foreach($order->timeline as $key=>$item)

                                                        <li class="timeline-item element" id='div_{{$key+2}}'>
                                                        <span class="timeline-point timeline-point-indicator  timeline-kanbai-active">{{$key+2}}</span>
                                                        <div class="timeline-event row">
                                                            <div class="col-md-9">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>{{$item->description}}</h6>                                                                
                                                            </div>
                                                            <p>{{$item->created_at}}</p>
                                                            @if($item->file!=null)
                                                            <img style="max-width: 100%; border-radius: 30px;" class="mb-1" src="{{ asset('images/orders/'.$item->file.'') }}">
                                                            @endif
                                                            </div>
                                                            
                                                        </div>
                                                    </li> 

                                                        @endforeach
                                                    @endif 
                                                                                                  
                                        
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')

<script src="{{ asset('js/admin/orders/edit.js') }}"></script>
<script>
$(document).ready(function(){

// Add new element
$(".add").click(function(){

 // Finding total number of elements added
 var total_element = $(".element").length;

 // last <div> with element class id
 var lastid = $(".element:last").attr("id");
 var split_id = lastid.split("_");
 var nextindex = Number(split_id[1]) + 1;

 var max=15-{{count($order->timeline)}};;
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
