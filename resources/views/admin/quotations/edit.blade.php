@extends('layouts.admin')

@section('title', 'Cotizaciones')
@section('page_title', 'Editar Cotizacion')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: #E{{ $quotation->id }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/quotes">Cotizaciones &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: #{{ $quotation->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <ul class="list-group-horizontal">
    @foreach($quotation->history->unique('state') as $item)
    <li class="list-group-item arrowRight">
    @if($item->state==0)En Espera @endif
    @if($item->state==1)Gestionado  @endif
    @if($item->state==6)Enviado {{$quotation->enviado}}, Version {{$quotation->version}}  @endif
    @if($item->state==2)Cancelado @endif
    @if($item->state==3)Aprobada @endif
    @if($item->state==5)Cancelado por el usuario @endif
    @if($item->state==4)Aprobado por el usuario @endif
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
                            <h4 class="card-title title-solicitud">Número de solicitud: {{ $quotation->id }}</h4>
                        </div>
                        <div class="col-md-7">
                            <!-- Button trigger modal -->
                            
                            <a href="{{ asset('cotizaciones/'.$quotation->file.'') }}" class="btn btn-success mb-2" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
                            <form method="POST" action="" style="width: fit-content;float: left;margin-right: 7px;">
                                <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$quotation->encode_id]) }}" class="btn btn-info waves-effect waves-float waves-light delete-user mb-2" value="Delete user"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>                                
                            </form>
                            @if($quotation->state==1)
                            
                            <form method="POST" action="" style="display: inline-block;">
                                <input type="hidden" id="state" name="state" value="3">
                                <input type="hidden" name="new_state" value="1">
                                <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$quotation->encode_id]) }}" class="btn btn-admin-succes-quotation ganada mb-2" value="Delete user">Aprobar</button>                               
                            </form>
                            @endif
                            @if($quotation->state!=2 && $quotation->state!=3)
                            <button type="button" class="btn btn-admin-succes-quotation mb-2" data-bs-toggle="modal" data-bs-target="#aprovarsolicitud">
                                Gestionar solicitud
                            </button>
                            @endif
                            @if($quotation->state!=2 && $quotation->state!=3)
                            <button type="button" class="btn btn-admin-danger-quotation mb-2" data-bs-toggle="modal" data-bs-target="#cancelarsolicitud">
                                Rechazar solicitud
                            </button>
                            @endif

                            <!-- Modal -->
                            <div class="modal fade" id="aprovarsolicitud" tabindex="-1" aria-labelledby="aprovarsolicitudLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aprovarsolicitudLabel">Editar Solicitud</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('admin.quotations.partials.aporbarsolicitud',['quotation'=>$quotation])
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
                                            @include('admin.quotations.partials.rechazarsolicitud',['quotation'=>$quotation])
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
</div>
                    <div class="card-body">
                        @foreach($quotation->items as $item)
                        <div class="row mt-4 mb-4 info-product-solicitud">
                            <div class="col-md-2">
                                @if(count($item->producto->gallery)>0)
                                <img  class="image-solicitud" src="{{ asset('images/products/thumbnail/list/'.$item->producto->gallery[0]->file.'') }}">
                                @endif
                            </div>
                            <div class="col-md-5">
                                <h4 class="titleproduct-solicitud mt-2">{{$item->producto->name}}</h4> 
                                <p class="price-solicitud mt-2">                                   
                                    Precio Unidad: <span>${{number_format($item->price, 0, 0, '.')}} </span> 
                                    </p>
                                <p class="price-solicitud mt-2">                                   
                                    Cantidad: <span>{{$item->quantity }} </span>
                                </p> 
                                @if(count($item->extras)>0)
                                    @foreach($item->extras as $extra)
                                        <p class="price-solicitud mt-2">
                                            {{$extra->itemextra->name}}: <span>${{number_format($extra->itemextra->price, 0, 0, '.')}}</span>
                                        </p> 
                                    @endforeach
                                
                                @endif

                                @if($item->color)
                                <p class="price-solicitud mt-2">                                   
                                    Color: <span>{{$item->color->name_color }} </span>
                                </p>
                                @endif
                                @if($item->talla)
                                <p class="price-solicitud mt-2">                                   
                                    Talla: <span>{{$item->talla->talla }} </span>
                                </p>
                                @endif
                            </div>
                            <div class="col-md-5">
                                {!!$item->producto->description !!}
                            </div>
                        
                        </div>
                        @endforeach
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" id="_url" value="{{ url('quotes',[$quotation->encode_id]) }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="product_id" value="{{ $quotation->product_id }}">

                            <div class="row">
                                <h4 class="mb-3">Datos</h4>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Nombre:</b> {{$quotation->name}}</li>
                                        <li class="list-group-item"><b>Documento:</b> {{$quotation->document}}</li>
                                        <li class="list-group-item"><b>Teléfono:</b> {{$quotation->cellphone}}</li>
                                        <li class="list-group-item"><b>Ciudad:</b> {{$quotation->city}}</li>
                                        <li class="list-group-item"><b>Fecha Entrega:</b> {{$quotation->date_delivery}}</li>
                                        <li class="list-group-item"><b>Valor Envio:</b> ${{number_format($quotation->price_shiping, 0, 0, '.')}}</li>
                                        @if($quotation->totalextras!=null)<li class="list-group-item"><b>Valor Extras:</b> ${{number_format($quotation->totalextras, 0, 0, '.')}}</li>@endif
                                        <li class="list-group-item"><b>Total Cotización:</b> ${{number_format($quotation->total, 0, 0, '.')}}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Tipo Documento:</b> {{$quotation->type_document}}</li>
                                        <li class="list-group-item"><b>Nombre Empresa:</b> {{$quotation->name_business}}</li>
                                        <li class="list-group-item"><b>E-mail:</b> {{$quotation->email}}</li>
                                        <li class="list-group-item"><b>Dirección:</b> {{$quotation->address}}</li>
                                        <li class="list-group-item"><b>Observaciones:</b> {{$quotation->observations}}</li>
                                        <li class="list-group-item"><b>Canal:</b> {{$quotation->channel}}</li>
                                    </ul>
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
$('.delete-user').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var data=$(e.target).closest('form').serialize();
Swal.fire({
title: 'Seguro que desea enviar cotización al cliente?',
text: "",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Aceptar',
cancelButtonText: 'Cancelar',
}).then((result) => {
if (result.isConfirmed) {
    showloader();
    $.ajax({
      url: href,
      headers: {'X-CSRF-TOKEN': token},
      type: 'DELETE',
      cache: false,
      data: data,
      success: function (response) {
        var json = $.parseJSON(response);
        console.log(json);
        hidenloader();
        Swal.fire(
            'Muy bien!',
            'Cotización enviada correctamente',
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

    $('.ganada').click(function(e){

        e.preventDefault();
        var _target=e.target;
        let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
        let token = $(this).attr('data-token');
        var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea Aprobar esta solicitud y pasarla a una orden?',
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
