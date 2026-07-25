@extends('layouts.admin')

@section('title', 'Solicitudes personalizadas')
@section('page_title', 'Editar Solicitud personalizada')
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
                            <a href="/solicituded-personalizadas">Solicitudes personalizadas &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: #{{ $customrequest->id }}</li>
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
                    
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <!--<input type="hidden" id="_url" value="{{ url('solicitud-personalizada',[$customrequest->encode_id]) }}">-->
                            <input type="hidden" id="_url" value="{{ route('updateproyect') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $customrequest->encode_id }}">

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card">
                                            <div class="card-header mb-2">
                                                <h4 class="card-title">Información general:</h4>
                                            </div>
                                            <table>
                                                <tr>
                                                    <td><strong>Orden # {{ $customrequest->id }}</strong></td>
                                                    <td>
                                                    @if($customrequest->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                                                    @if($customrequest->state==1) <span class="badge  text-white bg-warning">En Ejecución</span> @endif
                                                    @if($customrequest->state==9) <span class="badge  text-white bg-success">Finalizado</span> @endif
                                                    @if($customrequest->state==2) <span class="badge  text-white bg-danger">Cancelado</span> @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Fecha de inicio</strong></td>
                                                    <td>{{ $customrequest->created_at }}</td>
                                                </tr>
                                            </table>
                                            <hr>
                                            <div class="row mt-4">
                                                <div class="col-4">
                                                <img style="max-width: 100%; border-radius: 30px;" class="mb-1" src="{{ asset('images/custom_request/'.$customrequest->file.'') }}">
                                                </div>
                                                <div class="col-8">
                                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> Envio desde {{ $customrequest->shipping_from }}</p>
                                                    <p><strong>${{number_format($customrequest->budget_unit, 0, 0, '.')}}</strong></p>
                                                </div>

                                            </div>
                                            <hr>
                                            <table>
                                                <tr>
                                                    <td><strong>Cantidad</strong></td>
                                                    <td>{{ $customrequest->quantity }}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td><strong>Valor contrato</strong></td>
                                                    <td>${{number_format($customrequest->budget_unit*$customrequest->quantity, 0, 0, '.')}} </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Entrega Pactada</strong></td>
                                                    <td>{{ $customrequest->date_delivery_agreed }}</td>
                                                </tr>
                                            </table>

                                        </div>


                                    </div>
                                    <div class="col-md-7">

                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Timeline del proyecto:</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="timeline timeline-kn">
                                                    <li class="timeline-item">
                                                        <span class="timeline-point timeline-point-indicator @if($customrequest->confirmed==1) timeline-kanbai-active @else timeline-kanbai @endif">1</span>
                                                        <div class="timeline-event">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>Pedido confirmado</h6>                                                                
                                                            </div>
                                                            <p>{{$customrequest->date_confirmed}}</p>
                                                            @if($customrequest->confirmed!=1)
                                                            <div class="d-flex flex-row align-items-center">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="confirmed" name="confirmed" value="1" >
                                                                    <label class="form-check-label" for="confirmed">Confirmar pedido</label>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </li>
                                                    <li class="timeline-item">
                                                        <span class="timeline-point timeline-point-indicator @if($customrequest->sign_contract==1) timeline-kanbai-active @else timeline-kanbai @endif"">2</span>
                                                        <div class="timeline-event">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>Firma de contrato</h6>
                                                            </div>
                                                            <p>{{$customrequest->date_contract}}</p>
                                                            @if($customrequest->confirmed==1 && $customrequest->sign_contract!=1)
                                                            <div class="d-flex flex-row align-items-center">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="sign_contract" name="sign_contract" value="1" >
                                                                    <label class="form-check-label" for="sign_contract">Firma de Contrato</label>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </li>
                                                    <li class="timeline-item">
                                                        <span class="timeline-point  timeline-point-indicator @if($customrequest->buy_materials==1) timeline-kanbai-active @else timeline-kanbai @endif"">3</span>
                                                        <div class="timeline-event">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>Compra de materiales</h6>                                                                
                                                            </div>
                                                            <p>{{$customrequest->date_buy_materials}}</p>
                                                            
                                                            @if($customrequest->confirmed==1 && $customrequest->sign_contract==1 && $customrequest->buy_materials!=1)
                                                            <div class="d-flex flex-row align-items-center">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="buy_materials" name="buy_materials" value="1" >
                                                                    <label class="form-check-label" for="buy_materials">Compra de Materiales</label>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </li>
                                                    <li class="timeline-item">
                                                        <span class="timeline-point  timeline-point-indicator @if($customrequest->image!=null) timeline-kanbai-active @else timeline-kanbai @endif"">4</span>
                                                        <div class="timeline-event">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6 class="mb-50">Imagen</h6>
                                                            </div>
                                                            @if($customrequest->confirmed==1 && $customrequest->sign_contract==1 && $customrequest->buy_materials==1 && $customrequest->image==null)
                                                            <div class="d-flex flex-row align-items-center">                                                                
                                                                    <input class="form-control" type="file" id="image" name="image"  >                                                                
                                                            </div>
                                                            @endif
                                                            @if($customrequest->image!=null)
                                                            <img  style="max-height: 200px;" class="image-solicitud" src="{{ asset('images/custom_request/images/'.$customrequest->image.'') }}">
                                                            @endif
                                                            
                                                        </div>
                                                    </li>
                                        
                                                </ul>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="name">Nombre</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{$customrequest->name}}" readonly>
                                                <span class="missing_alert text-danger" id="name_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="name_business">Nombre Empresa</label>
                                                <input type="text" class="form-control" id="name_business" name="name_business" value="{{$customrequest->name_business}}" readonly>
                                                <span class="missing_alert text-danger" id="name_business_alert"></span>
                                            </div>
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
                                                <label class="form-label" for="category_id">Categoria</label>
                                                <select  id="category_id" name="category_id" class="form-control" readonly>                                               
                                                    @foreach( $categories as $key => $value )
                                                    <option value="{{ $value->id }}" {{ ($customrequest->category_id==$value->id) ? "selected" : "" }} >{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="missing_alert text-danger" id="category_id_alert"></span>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="quantity">Cantidad</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"  value="{{$customrequest->quantity}}" readonly>
                                                <span class="missing_alert text-danger" id="quantity_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="budget_unit">Presupuesto por unidad</label>
                                                <input type="text" class="form-control" id="budget_unit" name="budget_unit"  value="{{$customrequest->budget_unit}}" readonly>
                                                <span class="missing_alert text-danger" id="budget_unit_alert"></span>
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
                                                <label class="form-label" for="delivery_method">Forma de entrega</label>
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
                                       
                                    </div> 
                                    
                                    <div class="row">      
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="date_delivery_agreed">Fecha de entrega Pactada</label>
                                                <input type="date" class="form-control" id="date_delivery_agreed" name="date_delivery_agreed"  value="{{$customrequest->date_delivery_agreed}}">
                                                <span class="missing_alert text-danger" id="date_delivery_agreed_alert"></span>
                                            </div>
                                        </div>                                   
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="state">Estado</label>
                                                <select  id="state" name="state" class="form-control">
                                                    <option value="0" {{ ($customrequest->state==0) ? "selected" : "" }}>En Espera</option>
                                                    <option value="1" {{ ($customrequest->state==1) ? "selected" : "" }}>En Ejecución</option>
                                                    <option value="2" {{ ($customrequest->state==2) ? "selected" : "" }}>Cancelado</option>
                                                    <option value="2" {{ ($customrequest->state==9) ? "selected" : "" }}>Dinalizado</option>
                                                </select>
                                                <span class="missing_alert text-danger" id="state_alert"></span>
                                            </div>
                                        </div> 
                                    </div> 

                                    <div class="row">      
                                        <div class="col-md-6 col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="shipping_from">Envio desde</label>
                                                <input type="text" class="form-control" id="shipping_from" name="shipping_from"  value="{{$customrequest->shipping_from}}">
                                                <span class="missing_alert text-danger" id="shipping_from_alert"></span>
                                            </div>
                                        </div>                                   
                                       
                                    </div> 
                              
                             


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
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

<script src="{{ asset('js/admin/solicitudpersonalizada/edit.js') }}"></script>

@endpush
