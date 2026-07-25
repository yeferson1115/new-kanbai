@extends('layouts.appuser')
@section('title', 'Registro')
@section('content')

@section('content')
<section >
    <div style="padding: 0px 0px 0px 15px;">        
        <div class="d-flex align-items-start mt-1"> 
            <div class="row">
                <div class="bg-navbar-quotations">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item state-quotations-user @foreach($quotation->history as $item) @if($item->state==0) state-active @endif @endforeach">En Espera</li>
                        <li class="list-group-item state-quotations-user @foreach($quotation->history as $item) @if($item->state==1) state-active @endif @endforeach">Presentada</li>
                        <li class="list-group-item state-quotations-user @foreach($quotation->history as $item) @if($item->state==3) state-active @endif @endforeach">En preparación</li>
                        @foreach($quotation->history as $item) @if($item->state==2)<li class="list-group-item state-active">Cancelada</li>@endif @endforeach
                        @foreach($quotation->history as $item) @if($item->state==5)<li class="list-group-item state-active">Cancelada por el Cliente</li> @break @endif @endforeach
                    </ul>  
                    <div class="row mt-5 mb-5">
                        <div class="col-md-6">
                            <h2 class="title-number-quotation">Número de solicitud: {{ $quotation->id }} 
                                @if($quotation->file!=null)
                                    <a style="margin-left: 15px;" href="{{ asset('cotizaciones/'.$quotation->file.'') }}" class="btn btn-dowload-user" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
                                @endif
                            </h2> 
                            
                        </div>
                        <div class="col-md-6">
                            @if($quotation->state==1)
                                <div class="" style="text-align: right;">
                                    <form method="POST" action="" style="display: inline-block;">
                                        <input type="hidden" id="state" name="state" value="4">
                                        <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$quotation->encode_id]) }}" class="btn btn-admin-succes-quotation ganada" value="Delete user">Aprobar</button>                               
                                    </form> 
                                    <button type="button" class="btn btn-admin-danger-quotation" data-bs-toggle="modal" data-bs-target="#cancelarsolicitud">
                                        Rechazar solicitud
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($quotation->state==0 || $quotation->state==5)
                <div class="col-md-12">
                    @foreach($quotation->items as $item)
                    <div class="row information-quotation" style="border-bottom: solid 1px #cfcdcd;">
                        <div class="col-md-3">
                            <img style="max-width: 100%; border-radius: 15px;" class="mb-1" src="{{ asset('images/products/thumbnail/list/'.$item->producto->gallery[0]->file.'') }}">
                        </div>
                        <div class="col-md-4">
                            <p class="name-product-quotation">{{$item->producto->name}}</p>                           
                            <p class="information-price-quantity">Precio: <strong>${{number_format($item->price, 0, 0, '.')}}</strong></p>
                           
                            <p class="information-price-quantity">Cantidad: <strong>{{$item->quantity}} Unidades</strong></p>
                        </div>
                        <div class="col-md-5">
                            <label class="title-especification">Especificaciones</label>
                            <div class="description-info-quantity">{!!$item->producto->description!!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-12" style="background: #fff;">                    
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="Cantidad" class="form-label">Cantidad:</label>
                                <input type="text" class="form-control form-quantity-info" id="Cantidad" value="{{$quotation->quantity}} unidades" readonly >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="Fecha_de_entrega" class="form-label">Fecha de entrega:</label>
                                <input type="text" class="form-control form-quantity-info" id="Fecha_de_entrega" value="{{$quotation->date_delivery}}" readonly >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ubicacion_de_entrega" class="form-label">Ubicación de entrega:</label>
                                <input type="text" class="form-control form-quantity-info" id="ubicacion_de_entrega" value="{{$quotation->address}}" readonly >
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción:</label>
                                <textarea class="form-control form-quantity-info" id="description"readonly >{{$quotation->observations}}</textarea>
                            </div>
                        </div>                        
                    </div>
                </div>
                @endif
                @if($quotation->state==1 || $quotation->state==4)
                <div class="row justify-content-center">
                    <iframe src="{{ asset('cotizaciones/'.$quotation->file.'') }}" width="50%" height="600">
                            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset('cotizaciones/'.$quotation->file.'') }}">Download PDF</a>
                    </iframe>
                </div>
                @endif
            </div>               
        </div>               
    </div>    
</section>


 <!-- Modal -->
 <div class="modal fade" id="cancelarsolicitud" tabindex="-1" aria-labelledby="cancelarsolicitudLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="cancelarsolicitudLabel">Rechazar Solicitud</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('site.quotation.partials.rechazarsolicitud',['quotation'=>$quotation])
            </div>                                    
        </div>
    </div>
</div>

@endsection

@push('scripts')


    <script>
    $('.ganada').click(function(e){

        e.preventDefault();
        var _target=e.target;
        let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
        let token = $(this).attr('data-token');
        var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea aprobar la cotización?',
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
                    'Cotización aprovada',
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
