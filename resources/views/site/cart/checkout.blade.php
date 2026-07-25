@extends('layouts.appwhitoutheader')
@section('title', 'Cotización')
@section('content')
<!-- ======= product Section ======= -->
<section class="section-agents section-t3 quotation">
    <div class="container">
        <div class="row no-gutters justify-content-center">
            <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                <input type="hidden" id="_url" value="{{ url('carrito/easybuy') }}">
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
               
                <div class="col-md-2 col-logo logo-quotation">
                    <a class="logo-desck" href="/">
                        <img class="logo" src="{{ asset('images/logo/logo-kanbai-color.png').'?'.rand() }}" />
                        <!--Marce<span class="color-b">Pets</span>-->
                    </a>                    
                </div>
                
                <ul class="nav nav-tabs justify-content-center" id="cotizacion" role="tablist">
                   
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Tus Datos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pago</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fisnish-tab" data-bs-toggle="tab" data-bs-target="#fisnish" type="button" role="tab" aria-controls="fisnish" aria-selected="false">Comfirmación</button>
                    </li>
                    
                </ul>
                <div class="tab-content" id="cotizacionContent">
                   
                    <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-5">
                            <div class="col-md-7">
                                <div class="row form-cart">
                                    <h4 class="title-form-cotizacion title-cart-checkout mt-5 mb-1">Completa los siguientes campos:</h4>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label" for="email">Correo electrónico *</label>
                                            <input type="email" class="form-control input-cart" id="email" name="email" value="@if(Auth::user()){{Auth::user()->email}}@endif">
                                            <span class="missing_alert text-danger" id="email_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="mt-1rem">
                                            <label class="form-label" for="type_document">Tipo de documento *</label>
                                            <select class="form-control input-cart" id="type_document" name="type_document">
                                                <option value="">Seleccione</option>
                                                <option value="Cédula de Ciudadania">Cédula de Ciudadania</option>
                                                <option value="Cédula de Extranjeria">Cédula de Extranjeria</option>
                                                <option value="Pasaporte">Pasaporte</option>
                                                <option value="Nit">Nit</option>
                                            </select>
                                            <span class="missing_alert text-danger" id="type_document_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="document">Número de documento *</label>
                                            <input type="text" class="form-control input-cart" id="document" name="document" value="@if(Auth::user()){{Auth::user()->document}}@endif">
                                            <span class="missing_alert text-danger" id="document_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="name_business">Nombre de tu empresa *</label>
                                            <input type="text" class="form-control input-cart" id="name_business" name="name_business" value="{{ Auth::check() && Auth::user()->business ? Auth::user()->business->company_name : '' }}">
                                            <span class="missing_alert text-danger" id="name_business_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="name">Tu nombre *</label>
                                            <input type="text" class="form-control input-cart" id="name" name="name" value="@if(Auth::user()){{Auth::user()->name}}@endif">
                                            <span class="missing_alert text-danger" id="name_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="cellphone">Número celular</label>
                                            <input type="text" class="form-control input-cart" id="cellphone" name="cellphone" value="@if(Auth::user()){{Auth::user()->phone}}@endif">
                                            <span class="missing_alert text-danger" id="cellphone_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="address">Dirección de entrega *</label>
                                            <input type="text" class="form-control input-cart" id="address" name="address" value="@if(Auth::user()){{Auth::user()->address}}@endif">
                                            <span class="missing_alert text-danger" id="address_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="city">Municipio *</label>
                                            <input type="text" class="form-control input-cart" id="city" name="city" >
                                            <span class="missing_alert text-danger" id="city_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="date_delivery">Fecha de entrega *</label>
                                            <input type="date" class="form-control input-cart" id="date_delivery" name="date_delivery" >
                                            <span class="missing_alert text-danger" id="date_delivery_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class=" mt-1rem">
                                            <label class="form-label " for="observation">Observaciones a tener en cuenta (Opcional)</label>
                                            <textarea  class="form-control input-cart" id="observation" name="observation" ></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-5 resume-desk" style="padding-left: 45px;">
                                <div class="resume">
                                    <h4 class="title-products-cart text-center-tile mb-5">Resumen carrito</h4> 
                                    <p class="resume-check">Subtotal: <span>${{number_format(Cart::session('secondary')->getTotal(), 0, 0, '.')}}</span></p>
                                    <hr>
                                    @php
                                        $totalenvio = 0;
                                    @endphp
                                    @if (count(Cart::session('secondary')->getContent()))
                                    @php
                                        $totalextras = 0;
                                        $noextras = 0;
                                    @endphp
                                    @foreach (Cart::session('secondary')->getContent() as $item)  
                                        @if($item->attributes->extra!=null && count($item->attributes->extra)>0)
                                            @foreach($item->attributes->extra as $extra)
                                                @php
                                                $totalextras=$totalextras+($extra['price']*$item->quantity);
                                                $noextras++;
                                                @endphp
                                                <p class="resume-check">{{$extra['name']}} <span style="color: #1FD161;">x{{$item->quantity}}</span>: <span>${{number_format($extra['price']*$item->quantity, 0, 0, '.')}}</span></p>
                                                
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @php                                       
                                        $product = \App\Models\Products::where('id', $item->id)->first();
                                    @endphp

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
                                @endif
                                    <hr>
                                    <p class="resume-check" >Valor Total: <span>${{number_format(Cart::session('secondary')->getTotal()+$totalextras+$totalenvio, 0, 0, '.')}}</span></p>
                                    <div class="mt-4">                                       
                                        <a class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg next-d" >Continuar al pago</a>
                                    </div>
                                    @include('site.cart.partials.resume')

                                </div>
                            </div>

                            <div class="col-md-5 resume-mobile mb-5 mt-5" >
                                @include('site.cart.partials.resumemobile')
                                <div class="mt-4">
                                    <a class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg next-d" >Continuar al pago</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row mt-5">
                            <div class="col-md-5">
                                <div class="row form-cart">
                                    <h4 class="title-form-cotizacion title-cart-checkout mt-5 mb-5">Elige un método de pago:</h4>
                                    
                                    <div class="col-md-12 col-12">
                                        <div class="mb-3 mt-1rem">
                                        <div class="list-group">
                                            <label for="payment_method1" class="list-group-item list-group-item-action payment-type " aria-current="true">
                                                <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1 title-payment">Transferencia bancaria</h5>
                                                <small>
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_method1" value="Transferencia bancaria Bancolombia">
                                                </small>
                                                </div>
                                                <p class="mb-1">
                                                    <img class="logo" src="{{ asset('images/logo-bancolombia.png').'?'.rand() }}" />
                                                </p>
                                            </label>
                                           
                                           @if(Auth::check() && Auth::user()->business && Auth::user()->business->term)
                                            <label for="payment_method2" class="list-group-item list-group-item-action payment-type " aria-current="true">
                                                
                                                   <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1 title-payment">Crédito aprobado</h5>
                                                    <small>
                                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method2" value="Plazo de {{Auth::user()->business->term}} días">
                                                    </small>
                                                    </div><br>
                                                    <p class="mb-1">
                                                         <a class="btn" style="background: #1FD161;color: #fff;border-radius: 10px;"><i class="fa-regular fa-circle-check"></i> Plazo de {{Auth::user()->business->term}} días</a>
                                                    </p>
                                                
                                               
                                            </label>
                                            @endif
                                            <!--<label for="payment_method3" class="list-group-item list-group-item-action payment-type " aria-current="true">
                                                <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1 title-payment">PSE, Tarjeta débito o crédito</h5>
                                                <small>
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_method3" value="PSE, Tarjeta débito o crédito">
                                                </small>
                                                </div>
                                                <p class="mb-1">
                                                    <img class="logo" src="{{ asset('images/logo-bancolombia.png').'?'.rand() }}" />
                                                </p>
                                            </label>-->
                                            
                                        </div>
                                        <span class="missing_alert text-danger" id="payment_method_alert"></span>

                                       
                                        <img class="logo imagessl" src="{{ asset('images/pagoseguro.jpg').'?'.rand() }}" />
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="col-md-7 resume-desk" style="padding-left: 45px;">
                                <div class="resume">
                                    <h4 class="title-products-cart text-center-tile mb-5">Resumen carrito</h4> 
                                    <p class="resume-check">Subtotal: <span>${{number_format(Cart::session('secondary')->getTotal(), 0, 0, '.')}}</span></p>
                                    <hr>
                                    @php
                                        $totalenvio = 0;
                                    @endphp
                                    @if (count(Cart::session('secondary')->getContent()))
                                    @php
                                        $totalextras = 0;
                                        $noextras = 0;
                                    @endphp
                                    @foreach (Cart::session('secondary')->getContent() as $item)  
                                        @if($item->attributes->extra!=null && count($item->attributes->extra)>0)
                                            @foreach($item->attributes->extra as $extra)
                                                @php
                                                $totalextras=$totalextras+($extra['price']*$item->quantity);
                                                $noextras++;
                                                @endphp
                                                <p class="resume-check">{{$extra['name']}} <span style="color: #1FD161;">x{{$item->quantity}}</span>: <span>${{number_format($extra['price']*$item->quantity, 0, 0, '.')}}</span></p>
                                                
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @php                                       
                                        $product = \App\Models\Products::where('id', $item->id)->first();
                                    @endphp

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


                                @endif

                                    <hr>
                                    
                                    <p class="resume-check" >Valor Total: <span>${{number_format(Cart::session('secondary')->getTotal()+$totalextras+$totalenvio, 0, 0, '.')}}</span></p>
                                    <div class="mt-4">                                       
                                        <a class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg comfirm" id="comfirm">Continuar al pago</a>
                                    </div>
                                    @include('site.cart.partials.resume')
                                </div>
                            </div>
                            <div class="col-md-5 resume-mobile mb-5 mt-5" >
                                @include('site.cart.partials.resumemobile')
                                <div class="mt-4">
                                    <a class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg comfirm" id="comfirm">Continuar al pago</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="fisnish" role="tabpanel" aria-labelledby="fisnish-tab">
                    
                        <div class="row mt-5">
                            <div class="col-md-7">
                                <div class="row conten-form">
                                    <div id="info-trans" class="row">

                                    </div>
                                    <div class="mt-4">
                                        <a class="btn waves-effect waves-float waves-light ajax btn-send-order btn-lg"  data-bs-toggle="modal" data-bs-target="#exampleModal">Envíar comporbante de pago</a>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Enviar comprobante</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12 col-12">
                                                        <div class=" mt-1rem">
                                                            <label class="form-label " for="vaucher">Comprobante</label>
                                                            <input type="file" class="form-control input-cart" id="vaucher" name="vaucher" >
                                                            <span class="missing_alert text-danger" id="vaucher_alert"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg" id="comprar">Comprar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                               
                            </div>
                            <div class="col-md-5 resume-desk" style="padding-left: 45px;">
                                <div class="resume">
                                    <h4 class="title-products-cart text-center-tile mb-5">Resumen carrito</h4> 
                                    <p class="resume-check">Subtotal: <span>${{number_format(Cart::session('secondary')->getTotal(), 0, 0, '.')}}</span></p>
                                    <hr>
                                    @if (count(Cart::session('secondary')->getContent()))
                                    @php
                                        $totalextras = 0;
                                        $noextras = 0;
                                    @endphp
                                    @foreach (Cart::session('secondary')->getContent() as $item)  
                                        @if($item->attributes->extra!=null && count($item->attributes->extra)>0)
                                            @foreach($item->attributes->extra as $extra)
                                                @php
                                                $totalextras=$totalextras+($extra['price']*$item->quantity);
                                                $noextras++;
                                                @endphp
                                                <p class="resume-check">{{$extra['name']}} <span style="color: #1FD161;">x{{$item->quantity}}</span>: <span>${{number_format($extra['price']*$item->quantity, 0, 0, '.')}}</span></p>
                                                
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                                    <hr>
                                    <p class="resume-check" >Valor Total: <span>${{number_format(Cart::session('secondary')->getTotal()+$totalextras, 0, 0, '.')}}</span></p>
                                    <div class="mt-4"> 
                                        <button class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg comprar" id="comprar">Comprar</button>
                                    </div>
                                    @include('site.cart.partials.resume')
                                </div>
                            </div>
                            <div class="col-md-5 resume-mobile mb-5 mt-5" >
                                @include('site.cart.partials.resumemobile')
                                <div class="mt-4">
                                <button class="btn waves-effect waves-float waves-light ajax btn-go-quotation btn-lg comprar" id="comprar">Comprar</button>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    

</section><!-- End product Section -->
@endsection
@push('scripts')
<script src="{{ asset('js/app/cart/create.js').'?'.rand() }}"></script>
<script>
    function copiarAlPortapapeles(id_elemento) {
        var aux = document.createElement("input");
        if(id_elemento==1){
            id_elemento='cuenta';
        }
        if(id_elemento==2){
            id_elemento='name-cuenta';
        }
        if(id_elemento==3){
            id_elemento='nit';
        }
        
        aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
    }
$('.list-group input:radio').click(function() {
    var tipo=$(this).val();

    
    var logobancolombia="{{ asset('images/logo-bancolombia.png').'?'.rand() }}"
    var bancolombia='<div class="col-md-6"><img class="logo logo-bancolombia" src="'+logobancolombia+'" /><p>A continuación encontrarás los datos de nuestra cuenta para la trasferencia, una vez realizada envíanos una foto del comprobante, dando clic en el botón</p></div><div class="col-md-6"><h4 class="title-info-pago">Cuenta de ahorros Bancolombia</h4><hr><div class="row"><div class="col-7"><label class="texto-info-pago">No. de cuenta:</label><label id="cuenta" class="subtext-info-pago">02900001350</label></div><div class="col-5"><a href="#" class="btn-copy" onclick="copiarAlPortapapeles(1)">Copiar</a></div></div><hr><div class="row"><div class="col-7"><label class="texto-info-pago">Nombre del titular:</label><label id="name-cuenta" class="subtext-info-pago">Alma de Colombia S.A.S</label></div><div class="col-5"><a href="#" class="btn-copy" onclick="copiarAlPortapapeles(2)">Copiar</a></div></div><hr><div class="row"><div class="col-7"><label class="texto-info-pago">Documento del titular:</label><label id="nit" class="subtext-info-pago">NIT 901450303-5</label></div><div class="col-5"><a href="#" class="btn-copy" onclick="copiarAlPortapapeles(3)">Copiar</a></div></div></div>';
    var logoscotianbak="{{ asset('images/scotianbak.png').'?'.rand() }}"
    var cotianbak='<div class="col-md-6"><img class="logo logo-bancolombia" src="'+logoscotianbak+'" /><p>A continuación encontrarás los datos de nuestra cuenta para la trasferencia, una vez realizada envíanos una foto del comprobante, dando clic en el botón</p></div><div class="col-md-6"><h4 class="title-info-pago">Cuenta de ahorros Scotiabank Colpatria </h4><hr><div class="row"><div class="col-7"><label class="texto-info-pago">No. de cuenta:</label><label id="cuenta" class="subtext-info-pago">1882017053</label></div><div class="col-5"><a href="#" class="btn-copy" onclick="copiarAlPortapapeles(1)">Copiar</a></div></div><hr><div class="row"><div class="col-7"><label class="texto-info-pago">Nombre del titular:</label><label id="name-cuenta" class="subtext-info-pago">Alma de Colombia S.A.S</label></div><div class="col-5"><a href="#" class="btn-copy" onclick="copiarAlPortapapeles(2)">Copiar</a></div></div><hr><div class="row"><div class="col-7"><label class="texto-info-pago">Documento del titular:</label><label id="nit" class="subtext-info-pago">NIT 901450303-5</label></div><div class="col-5"><a href="#" class="btn-copy" onclick="copiarAlPortapapeles(3)">Copiar</a></div></div></div>';
    
    $('#info-trans div').remove();
    

    if(tipo=='Transferencia bancaria Bancolombia'){
        $('#info-trans').append(bancolombia);
    }
    if(tipo=='Transferencia bancaria Scotiabank'){
        $('#info-trans').append(cotianbak);  
    }

    
    $('.payment-type').removeClass('active_payment');
    $(this).closest('.payment-type').addClass('active_payment');
  });

   var input = document.querySelector("#cellphone");
    window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function(callback) {
        $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "co";
        callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
    });

    feather.replace({ 'aria-hidden': 'true' });

$(".togglePassword").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".password").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".password").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".password").attr("type","password");
      }
  });

  $(".togglePassword-confirm").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".password-confirm").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".password-confirm").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".password-confirm").attr("type","password");
      }
  });
    </script>
@endpush
