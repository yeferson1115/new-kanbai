@extends('layouts.appwhitoutheader')

@section('title', 'Checkout')
@section('page_title', 'Checkout')
@section('page_subtitle', 'Checkout')
@section('content')

<section class="section-agents">
    <div class="container">
        <div class="row mt-5">
            <h2 class="titlecart mb-5"><a href="/" class="btn-return" ><</a>Carrito</h2>
            <div class="col-md-8 mt-5">
                <h4 class="title-products-cart">Productos</h4>
                <hr style="margin-bottom: 45px;">
                @if (count(Cart::session('primary')->getContent()))
                @php
                $message = '';
                @endphp
                @foreach (Cart::session('primary')->getContent() as $item)
                    @php
                        $totalextras = 0;
                        
                        $noextras=0;
                        $valExtra=0;
                    @endphp

                    @if(count($item->attributes->extra)>0)
                        @foreach($item->attributes->extra as $extra)
                            @php
                            $totalextras=$totalextras+($extra['price']*$item->quantity);                            
                            $noextras++;
                            @endphp
                        @endforeach
                    @endif
                    <div class="row mt-3">
                        <div class="col-4">
                            <img class="image-cart" src="{{ asset('images/products/thumbnail/'.$item->attributes->urlfoto.'') }}" />
                        </div>
                        <div class="col-8" style="position: relative;">
                            <h5 class="title-product-cart">{{$item->name}}</h5>
                            <p class="info-product-cart">Precio: <span style="color:#5F5F5F;">${{number_format($item->price, 0, 0, '.')}}</span></p>
                            <p class="info-product-cart" >Cantidad: <span style="color:#5F5F5F;">{{$item->quantity}} Unidades</span></p>
                            <input type="hidden" value="{{$product = App\Models\Products::find($item->id)}}">
                            @if(!is_null($product->delivery_time))
                            <p class="info-product-cart" ><i class="fa fa-truck" aria-hidden="true"></i> Tiempo de Entrega: <span style="color:#5F5F5F;">{{$product->delivery_time}}</span></p>
                            @endif
                            <div class="input-group" style="width: 140px;">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-left-minus btn btn-primary  btn-number minus"  data-type="minus" data-field="" id="{{$item->id}}">
                                          -
                                        </button>
                                    </span>
                                    <input type="text" id="quantity" style="text-align: center;" name="quantity" class="form-control input-number" value="{{$item->quantity}}" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-right-plus btn btn-primary  btn-number plus" data-type="plus" data-field="" id="{{$item->id}}">
                                            +
                                        </button>
                                    </span>
                                </div>
                                <form method="POST" action="">
                                        <div class="form-group" style="position: absolute;top: 0;right: 10px;">
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <button type="submit" data-id="{{$item->id}}" data-token="{{ csrf_token() }}" data-attr="{{route('carrito.remove')}}" class="ps-cart-listing__remove remove-item" style="border: none;">X</button>
                                        </div>
                                    </form> 
                        </div>
                       
                    </div>
                    @php
                    $price=number_format($item->price, 0, 0, '.');
                    $message.='- Producto: '.$item->name.' Cantidad:'.$item->quantity.' Precio: $'.$price.' ';
                    @endphp
                    
                    @if(count($item->attributes->extra)>0)
                        @foreach($item->attributes->extra as $extra)
                            @php
                            $message.='Extras '.$extra['name'].' x'.$item->quantity.' $'.number_format($extra['price']*$item->quantity, 0, 0, '.').' ';
                            @endphp
                        @endforeach
                    @endif

                @endforeach
                @endif
            </div>
            <div class="col-md-4 mt-3 resume-mobile1">
            @if (count(Cart::session('primary')->getContent()))
                <div class="resume">
                    <h4 class="title-products-cart text-center-tile mb-5">Resumen carrito</h4> 
                    <p class="resume-check">Subtotal : <span>${{number_format(Cart::getTotal(), 0, 0, '.')}}</span></p>
                    <hr>
                    @php
                        $totalenvio = 0;
                    @endphp
                    @if (count(Cart::session('primary')->getContent()))
                        @foreach (Cart::session('primary')->getContent() as $item)  
                        @php                            
                            $product = \App\Models\Products::find($item->id); 
                        @endphp
                            @if(count($item->attributes->extra)>0)
                                @foreach($item->attributes->extra as $extra)
                                    <p class="resume-check">{{$extra['name']}} <span style="color: #1FD161;">x{{$item->quantity}}</span>: <span>${{number_format($extra['price']*$item->quantity, 0, 0, '.')}}</span></p>
                                    
                                @endforeach
                                <hr>
                            @endif
                            @if($product->shipping_price && $product->shipping_price != 0 && $product->packaging_unit_quantity > 0)
                            @php
                                $packaging_unit_quantity = $product->packaging_unit_quantity;
                                $quantity_requested = $item->quantity;
                                $empaques = ceil($quantity_requested / $packaging_unit_quantity);
                                $totalenvio += $product->shipping_price * $empaques;
                            @endphp

                            <p class="resume-check">
                                Valor Envío <span>${{ number_format($totalenvio, 0, 0, '.') }}</span>
                            </p>
                        @endif
                           
                        @endforeach
                       
                    @endif
                    
                    <p class="resume-check" >Valor Total: <span>${{number_format(Cart::getTotal()+$totalextras+$totalenvio, 0, 0, '.')}}</span></p>
                    <div class="mt-4">
                        @php
                        $message.='Total: $'.number_format(Cart::getTotal()+$totalextras+$totalenvio, 0, 0, '.');
                        @endphp
                        <!--<a href="/carrito/checkout" class="btn mb-4 addcart btn-lg btn-sale">Comprar ahora</a>-->
                        <!-- Botón WhatsApp -->
                        <a href="javascript:void(0)" 
                        class="btn mb-4 addcartfull btn-lg btn-sale open-modal-quotation" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal"
                        data-type="whatsapp">
                        Solicitar cotización vía WhatsApp <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        <!-- Botón Email -->
                        <a href="javascript:void(0)" 
                        class="btn mb-4 addcart btn-lg btn-sale open-modal-quotation" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal"
                        data-type="email">
                        Solicitar cotización vía correo <i class="fa fa-envelope-o"></i>
                        </a>

                            <!--<a href="/catalogo/cotizacion/porducto/{{$item->id}}" class="btn addcartfull btn-lg">Solicitar Cotización</a>-->
                        
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="_tokensearch" value="{{ csrf_token() }}">

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="padding: 30px;border-radius: 30px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Completa para recibir tu cotización</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
            <input type="hidden" id="_url" value="{{ url('carrito') }}">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-md-12">
                    <div class=" mt-1rem">
                        <label class="form-label" for="name">Nombre*</label>
                        <input type="text" class="form-control input-cart" id="name" name="name" value="@if(Auth::user()){{Auth::user()->name}}@endif">
                        <span class="missing_alert text-danger" id="name_alert"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class=" mt-1rem">
                        <label class="form-label" for="company">Empresa*</label>
                        <input type="text" class="form-control input-cart" id="company" name="company" >
                        <span class="missing_alert text-danger" id="company_alert"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class=" mt-1rem">
                        <label class="form-label" for="email">E-mail*</label>
                        <input type="email" class="form-control input-cart" id="email" name="email" >
                        <span class="missing_alert text-danger" id="email_alert"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class=" mt-1rem">
                        <label class="form-label" for="phone">Celular *</label>
                        <input type="text" class="form-control input-cart" id="phone" name="phone" >
                        <span class="missing_alert text-danger" id="phone_alert"></span>
                    </div>
                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <button type="submit" class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg" id="send">Solicitar cotización</button>
                </div>
            </div>

        </form>
                
      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')

<script src="{{ asset('js/app/cart/createv2.js') }}"></script>
<script>
    $('.remove-item').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var data=$(e.target).closest('form').serialize();
Swal.fire({
title: 'Seguro que desea eliminar el item del carrito?',
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
      type: 'POST',
      cache: false,
      data: data,
      success: function (response) {
        var json = $.parseJSON(response);
        console.log(json);
        Swal.fire(
            'Muy bien!',
            'Item eliminado correctamente',
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
$(".plus").click(function(){
    var id=$(this).attr("id");
    updatecart(id,1);
  });

  $(".minus").click(function(){
    var id=$(this).attr("id");
    updatecart(id,-1);
  });

function updatecart(id,quantity){
  
  $.ajax({
        url: "{{route('carrrito.update')}}",
    		headers: {'X-CSRF-TOKEN': $('#_tokensearch').val()},
    		type: 'POST',
        data: { producto_id: id,quantity:quantity },             
        success: function (response) {
          var json = $.parseJSON(response);
          if(json.success){
            location.reload();
            }
          },error: function (data) {
              var errors = data.responseJSON;
              console.log(errors);
              $.each( errors.errors, function( key, value ) {
                  notifications.error(value);
                  return false;
              });                
            }
          });
}
</script>
@endpush
