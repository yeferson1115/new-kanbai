@extends('layouts.admin')

@section('title', 'Solicitudes Perzonalizadas')
@section('page_title', 'Editar Solicitud Perzonalizada')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: #{{ $customrequest->id }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/solicituded-personalizadas">Solicitudes Perzonalizadas &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: #{{ $customrequest->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <ul class="list-group-horizontal">
    @foreach($customrequest->history as $item)
    <li class="list-group-item arrowRight">
    @if($item->state==0)En Espera @endif
    @if($item->state==1)Aprobado  @endif
    @if($item->state==2)Cancelado @endif
    </li>
    @endforeach
    
    </ul>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header header-solicitud">
                    <div class="row heder-quatitons" >
                        <div class="col-md-5">
                            <h4 class="card-title title-solicitud">Número de solicitud: P{{ $customrequest->id }}</h4>
                        </div>
                        <div class="col-md-7">
                            <!-- Button trigger modal -->
                            @if($customrequest->state==1)
                            <a href="{{ asset('cotizaciones/'.$customrequest->filepdf.'') }}" class="btn btn-success" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
                            <form method="POST" action="" style="display: inline-block;">
                                    <input type="hidden" id="state" name="state" value="3">
                                    <input type="hidden" id="customrequest_id" name="customrequest_id" value="{{$customrequest->id}}">
                                    
                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('solicitud-personalizada',[$customrequest->encode_id]) }}" class="btn btn-admin-succes-quotation ganada" value="Delete user">Ganada</button>                               
                            </form>
                            @endif
                            @if($customrequest->state!=1 && $customrequest->state!=3)
                            <button type="button" class="btn btn-admin-succes-quotation" data-bs-toggle="modal" data-bs-target="#aprovarsolicitud">
                                Aprobar solicitud
                            </button>
                            @endif
                            @if($customrequest->state!=2)
                            <button type="button" class="btn btn-admin-danger-quotation" data-bs-toggle="modal" data-bs-target="#cancelarsolicitud">
                                Rechazar solicitud
                            </button>
                            @endif

                            <!-- Modal -->
                            <div class="modal fade" id="aprovarsolicitud" tabindex="-1" aria-labelledby="aprovarsolicitudLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aprovarsolicitudLabel">Aprobar Solicitud</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('admin.customrequest.partials.aporbarsolicitud',['customrequest'=>$customrequest])
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="cancelarsolicitud" tabindex="-1" aria-labelledby="cancelarsolicitudLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cancelarsolicitudLabel">Rechazar Solicitud</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('admin.quotations.partials.rechazarsolicitud',['quotation'=>$customrequest])
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>

                        </div>
</div>
                    </div>
</div>
                    <div class="card-body">
                        <div class="row mt-4 mb-4 info-product-solicitud">
                            <div class="col-md-2">
                                @if($customrequest->image!=null)
                                <img  class="image-solicitud" src="{{ asset('images/custom_request/images/'.$customrequest->image.'') }}">
                                @else
                                <img  class="image-solicitud" src="{{ asset('images/custom_request/'.$customrequest->file.'') }}">
                                @endif
                            </div>
                            <div class="col-md-5">
                                <h4 class="titleproduct-solicitud mt-2">Categoria: {{$customrequest->category->name}}</h4> 
                                <p class="price-solicitud mt-2">                                   
                                    Precio por unidad: <span>$@if($customrequest->price_finish!=null) {{number_format($customrequest->price_finish, 0, 0, '.')}} @else {{number_format($customrequest->budget_unit, 0, 0, '.')}} @endif</span> 
                                    </p>
                                <p class="price-solicitud mt-2">                                   
                                    Cantidad: <span>{{$customrequest->quantity }} </span>
                                </p> 
                            </div>
                            <div class="col-md-5">
                                {!!$customrequest->description !!}
                            </div>
                        
                        </div>
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" id="_url" value="{{ url('quotes',[$customrequest->encode_id]) }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="product_id" value="{{ $customrequest->product_id }}">

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="name">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{$customrequest->name}}" readonly>
                                            <span class="missing_alert text-danger" id="name_alert"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email">Correo Electronico</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{$customrequest->email}}" readonly>
                                                <span class="missing_alert text-danger" id="email_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="cellphone">Número celular</label>
                                                <input type="text" class="form-control" id="cellphone" name="cellphone" value="{{$customrequest->cellphone}}" readonly>
                                                <span class="missing_alert text-danger" id="cellphone_alert"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="name_business">Empresa</label>
                                                <input type="text" class="form-control" id="name_business" name="name_business"  value="{{$customrequest->name_business}}" readonly>
                                                <span class="missing_alert text-danger" id="name_business_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="quantity">Cantidad</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"  value="{{$customrequest->quantity}}" readonly>
                                                <span class="missing_alert text-danger" id="quantity_alert"></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="date_delivery">Fecha de entrega</label>
                                                <input type="date" class="form-control" id="date_delivery" name="date_delivery"  value="{{$customrequest->date_delivery}}" readonly>
                                                <span class="missing_alert text-danger" id="date_delivery_alert"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="delivery_method">Forma de entrega solicitada</label>
                                                <input type="text" class="form-control" id="delivery_method" name="delivery_method"  value="{{$customrequest->delivery_method}}" readonly>
                                                <span class="missing_alert text-danger" id="delivery_method_alert"></span>
                                            </div>
                                        </div> 
                                    </div>
                                    
                                    <div class="row">                                        
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="observations">Observaciones a tener en cuenta</label>
                                                <textarea  name="observations" class="form-control" id="observations" rows="10" cols="80" readonly>{!! $customrequest->observations  !!}</textarea>
                                                <span class="missing_alert text-danger" id="observations_alert"></span>
                                            </div>
                                        </div> 
                                    </div>  
                                    
                                    <div class="row">                                        
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="state">Estado</label>
                                                <select  id="state" name="state" class="form-control">
                                                    <option value="0" {{ ($customrequest->state==0) ? "selected" : "" }}>Sin gestionar</option>
                                                    <option value="1" {{ ($customrequest->state==1) ? "selected" : "" }}>Gestionado</option>
                                                    <option value="2" {{ ($customrequest->state==2) ? "selected" : "" }}>Cancelado</option>
                                                    
                                                </select>
                                                <span class="missing_alert text-danger" id="state_alert"></span>
                                            </div>
                                        </div> 
                                    </div> 
                                  

                                </div>
                             

                             


                                <!--<div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
                                </div>-->
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

<script src="{{ asset('js/admin/quotations/edit.js') }}"></script>

<script>
    $('.ganada').click(function(e){

        e.preventDefault();
        var _target=e.target;
        let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
        let token = $(this).attr('data-token');
        var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea marcar como ganada la cotización perzonalizada?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: href,
              headers: {'X-CSRF-TOKEN': token},
              type: 'PUT',
              cache: false,
    	      data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                console.log(json);
                Swal.fire(
                    'Muy bien!',
                    'Cotización ganada',
                    'success'
                    ).then((result) => {
                        location.reload();
                    });

              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);

              }
           });

        }
        })

    });
</script>

@endpush
