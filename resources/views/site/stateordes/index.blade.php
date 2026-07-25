@extends('layouts.app')
@section('title', 'Mi perfil')
@section('content')

@section('content')
<section class="section-agents section-t8 home">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="mt-2 content-menu-profile">
                    <div class="d-flex align-items-start">
                        <ul class="menu-profile-mobile">
                            <li>
                                <div class="row">
                                    <div class="col-4 icon-profile">
                                        <label class="content-icon-profile"><i class="bi bi-person"></i></label>
                                    </div>
                                    <div class="col-8">
                                        <h4 class="mb-0">Hola, {{ $order->name}} </h4>
                                    </div>
                                </div>
                                <hr>
                            </li>
                            <li>
                                <div class="infoasesor">
                                    <label class="icon-image-user"><i class="fa fa-circle" aria-hidden="true"></i></label>
                    
                                    <label class="name-asesor">Asesor</label>
                                    <p class="description-asesor">Contactanos si tienes alguna duda</p>
                                    <a class="whatsapp-asesor" target="_blank" href="https://api.whatsapp.com/send?phone=3111111111&text=Hola, ...">Contactar vía Whatsapp <i class="bi bi-whatsapp"></i></a>
                   
                                </div>
                            </li>                
                        <ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-2">
                <div class="row cont-indicator-user">
                    <div class="col-md-6">
                        @foreach($order->items as $item)
                        <div class="row">
                            <div class="col-md-4">
                                <img style="max-width: 100%; border-radius: 30px;" class="mb-1" src="{{ asset('images/products/thumbnail/'.$item->producto->gallery[0]->file.'') }}">
                            </div>
                            <div class="col-md-8">
                                <h4>{{$item->producto->name}}</h4>
                                <p class="mb-0"><b>Cantidad:</b> {{$item->quantity}}</p>
                                <p class="mb-0"><b>Precio Unidad:</b> ${{number_format($item->price_unit, 0, 0, '.')}}</p>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                        <div class="row">
                            <p class="mb-0"><b>Fecha entrega:</b> {{$order->date_delivery}}</p>
                            <p class="mb-0"><b>Direccion entrega:</b> {{$order->address}}</p>
                            <h4 class="mt-2 total-order-view">Total: ${{number_format($order->total, 0, 0, '.')}}</h4>                            
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <h4>Estado Orden #{{$order->id}}</h4>
                        <div class="card-body">
                            <ul class="timeline timeline-kn container">
                                <li class="timeline-item element" id='div_1'>
                                    <span class="timeline-point timeline-point-indicator @if($order->state==1) timeline-kanbai-active @else timeline-kanbai @endif">1</span>
                                    <div class="timeline-event row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6>Pedido ordenado</h6>
                                            </div>
                                            <p>{{$order->created_at}}</p>
                                        </div>
                                    </div>
                                </li>
                                @if(count($order->timeline)>0)
                                    @foreach($order->timeline as $key=>$item)
                                    <li class="timeline-item element" id='div_{{$key+2}}'>
                                        <span class="timeline-point timeline-point-indicator  timeline-kanbai-active">{{$key+2}}</span>
                                        <div class="timeline-event row">
                                            <div class="col-md-12">
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
        </div>
    </div>
</section>
@endsection

