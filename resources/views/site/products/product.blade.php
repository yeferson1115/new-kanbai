@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<!-- ======= product Section ======= -->
<section class="section-agents section-t8 mt-5 product-desk only-product-desk">
    <div class="container">
        <div class="row mt-5">

            <div class="col-md-6 frame-1000004993">
    <!-- Bloque de Galería (Imagen Principal + Miniaturas Sincronizadas) -->
    <div class="frame-1000004988">
        
        <!-- 1. Slider Principal (Visualización grande) -->
        <div id="main-slider" class="splide main-slider-figma w-100">
            <div class="splide__track">
                <ul class="splide__list">
                    @forelse($product->gallery as $item)
                        <li class="splide__slide">
                            <!-- Nota: Ruta a la imagen original HD para el Lightbox -->
                            <a href="{{ asset('images/products/thumbnail/'.$item->file) }}" class="lightbox-trigger">
                                <img src="{{ asset('images/products/thumbnail/'.$item->file) }}" 
                                     class="_1771454440-y-6-j-k-hb-m-1" 
                                     alt="{{ $product->name ?? 'Producto' }}" 
                                     loading="lazy" />
                            </a>
                        </li>
                    @empty
                        <li class="splide__slide">
                            <img src="{{ asset('images/default-product.png') }}" 
                                 class="_1771454440-y-6-j-k-hb-m-1" 
                                 alt="Imagen no disponible" />
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- 2. Slider de Miniaturas (Navegación tipo Carrusel sin scrollbar) -->
        <div id="thumbnail-slider" class="splide thumbnail-slider-figma w-100">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($product->gallery as $index => $item)
                        <li class="splide__slide thumbnail-item">
                            <img class="rectangle-thumb" 
                                 src="{{ asset('images/products/thumbnail/list/'.$item->file) }}" 
                                 alt="Thumbnail {{ $index + 1 }}" 
                                 loading="lazy" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

    <!-- Bloque de Información / Descripción de Figma -->
    <div class="frame-1000004511">
        @if(!empty($product->color_label))
            <div class="select-color">{{ $product->color_label }}</div>
        @endif

        <div class="product-description-figma">
            {!! $product->description !!}
        </div>
    </div>

    <!-- Bloque de Preguntas Frecuentes -->
   
</div>

            
            <div class="col-md-6">
                <div class="frame-1000004992">
  {{-- Header del Producto --}}
  <div class="frame-1000004989">
    <h1 class="mug-paja-de-trigo m-0">{{ $product->name }}</h1>
    
    <div class="frame-1000004513">
      <div class="etiqueta">
        <div class="frame-1000004498">
          <div class="prize">
            <i class="fa fa-shopping-bag brand-icon" aria-hidden="true"></i>
          </div>
          <div class="pedido-m-nimo-15">
            Pedido mínimo: <strong>{{ $cantidadminima }}</strong>
          </div>
        </div>
      </div>

      @if(!is_null($product->delivery_time))
      <div class="etiqueta">
        <div class="frame-1000004498">
          <div class="truck-delivery">
            <i class="fa fa-truck brand-icon" aria-hidden="true"></i>
          </div>
          <div class="pedido-m-nimo-15">
            Tiempo de entrega: <strong>{{ $product->delivery_time }}</strong>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>

  {{-- Descripción --}}
  <div class="mug-con-manija-elaborado-en-paja-de-trigo-ligero-reutilizable-e-ideal-para-bebidas-calientes-o-fr-as-temperatura-recomendada-60-c-capacidad-350-ml-12-oz">
    {!! $product->description_short !!}
  </div>

  {{-- Tabla de Escalas de Precios (Grid Adaptado de Figma) --}}
  @if(count($product->escalas) > 0)
  <div class="group-186-grid">
    <div class="scale-header cantidad">Cantidad</div>
    <div class="scale-header precio-por-unidad">Precio por unidad</div>
    
    @foreach($product->escalas as $escala)
      <div class="scale-cell _25-100">{{ $escala->quantity_min }} - {{ $escala->quantity_max }}</div>
      <div class="scale-cell _8-914">${{ number_format($escala->price, 0, ',', '.') }}</div>
    @endforeach
  </div>
  @endif

  {{-- Selección de Colores --}}
  @if(count($product->colores) > 0)
  <div class="frame-1000004991">
    <div class="select-color">Seleccionar Color</div>
    <div class="selecci-n-colores">
      @foreach($product->colores as $color)
        <div id="color_{{ $color->id }}" 
             class="rectangle-color-item" 
             style="background-color: {{ $color->color }};" 
             onclick="selectColor({{ $color->id }}, '{{ $color->file }}');"
             title="{{ $color->nombre ?? 'Color' }}">
        </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Selección de Tallas (si aplican) --}}
  @if(count($product->tallas) > 0)
  <div class="frame-1000004991">
    <div class="select-color">Tallas Disponibles</div>
    <div class="selecci-n-colores gap-2">
      @foreach($product->tallas as $talla)
        <div id="talla_{{ $talla->id }}" 
             class="size-box-item" 
             onclick="selectTalla({{ $talla->id }});">
             {{ $talla->talla }}
        </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Formulario Principal de Cotización / Añadir al Carrito --}}
  <form action="javascript:void(0)" id="main-form" autocomplete="off" class="w-100">
    <input type="hidden" name="producto_id" id="producto_id" value="{{ $product->id }}">
    <input type="hidden" id="_url" value="{{ route('cart.add') }}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="minima" value="{{ $cantidadminima }}">
    <input type="hidden" id="color" name="color">
    <input type="hidden" id="size" name="size">

    {{-- Opciones Extras/Adicionales --}}
    @if(isset($product->adicional) && count($product->adicional) > 0)
      <div class="extras-container mb-4">
        @foreach($product->adicional as $additional)
          <div class="mb-3">  
            <label for="extra_{{ $additional->extra->id }}" class="form-label fw-bold neutral-100-text">
              {{ $additional->extra->name }} (Opcional)
            </label>
            <select class="form-select extra custom-input-rounded" id="extra_{{ $additional->extra->id }}" name="extras[]">
              <option value="" selected>Seleccione una opción</option>
              @foreach($additional->extra->items as $i)
                <option value="{{ $i->id }}">{{ $i->name }}</option>
              @endforeach
            </select>
          </div> 
        @endforeach
      </div>
    @endif

    {{-- Visualización del Precio --}}
    <div class="_8-914-iva-incluido-8-914-valor-por-unidad mb-4">
      <span>
        <span class="_8-914-iva-incluido-8-914-valor-por-unidad-span text-price">
          ${{ number_format($pricemax * $cantidadminima, 0, ',', '.') }}
        </span>
        <span class="_8-914-iva-incluido-8-914-valor-por-unidad-span3">
          IVA Incluido
          <br />
          <span class="price-unit">${{ number_format($pricemax, 0, ',', '.') }} valor por unidad</span>
        </span>
      </span>
    </div>

    {{-- Controles de Cantidad y Botones de Acción --}}
    <div class="frame-1000004990">
      <div class="frame-1000004512">
        <div class="cantidad2">Cantidad</div>
        <div class="frame-1000004506">
          <div class="frame-1000004504">
            <input type="number" 
                   id="quantity" 
                   name="quantity" 
                   class="_1 border-0 bg-transparent text-center" 
                   value="{{ $cantidadminima }}" 
                   min="{{ $cantidadminima }}">
          </div>
        </div>
      </div>

      <div class="d-flex gap-2 flex-grow-1 align-items-center">
        @guest
          <button type="submit" id="btn-cotizar" class="buttons-primary-text-icon border-0 w-100 cursor-pointer">
            <div class="frame-1000004809">
              <span class="button">Solicitar cotización</span>
            </div>
          </button>
        @endguest

        @auth
          <button type="submit" id="btn-cotizar" class="buttons-outline-text-icon w-100 cursor-pointer">
            <div class="frame-1000004809">
              <span class="button-outline">Solicitar cotización</span>
            </div>
          </button>
          <button type="submit" id="btn-pedir-ahora" class="buttons-primary-text-icon border-0 w-100 cursor-pointer">
            <div class="frame-1000004809">
              <span class="button">Pedir ahora</span>
            </div>
          </button>
        @endauth
      </div>
    </div>
  </form>
</div>

@push('scripts')
<script src="{{ asset('js/app/cart/addcart.js').'?'.rand() }}"></script>
<script>
$(document).ready(function() {
    $("#quantity").on("keyup change blur", function(){
        Getprice();
    });

    $(document).on('change', '.extra', function () {
        Getprice();
    });
});

function selectColor(id, file) {
    $('#color').val(id);
    $('.rectangle-color-item').removeClass('active-variant');
    $('#color_' + id).addClass('active-variant');
}

function selectTalla(id) {
    $('#size').val(id);
    $('.size-box-item').removeClass('active-variant');
    $('#talla_' + id).addClass('active-variant');
}

function Getprice(){
    var min = parseInt($('#minima').val()) || 1;
    var currentQty = parseInt($('#quantity').val()) || 0;

    if(currentQty < min){
        $('.text-price').text('$0');
        $('.price-unit').text('$0 valor por unidad');
        return false;
    }

    $.ajax({
        url: "{{ route('getprice') }}",
        headers: {'X-CSRF-TOKEN': $('#_token').val()},
        type: 'POST',
        data: {
            quantity: currentQty,
            producto_id: $('#producto_id').val(),
            extras: $("select[name='extras[]']").length
                ? $("select[name='extras[]']").map(function () { return $(this).val(); }).get()
                : []
        },
        success: function (response) {
            var json = (typeof response === 'string') ? $.parseJSON(response) : response;
            if(json.success){
                var totalPrice = json.price * currentQty;
                $('.text-price').text('$' + formatNumber(totalPrice));
                $('.price-unit').text('$' + formatNumber(json.price) + ' valor por unidad');
            }
        },
        error: function (data) {
            if(data.responseJSON && data.responseJSON.errors) {
                $.each(data.responseJSON.errors, function(key, value) {
                    if (typeof toastr !== 'undefined') toastr.error(value);
                });
            }
        }
    });  
}

function formatNumber(n) {
    n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString("es-CO");
}
</script>
@endpush
            </div>
        </div>

        <div class="row">
            @if(count($product->questions) > 0)
    <section class="faq-section-wrapper my-5">
        <div class="row gx-lg-5 gy-4 align-items-start">
            <!-- Columna Izquierda: Título Principal de Figma -->
            <div class="col-12 col-lg-6">
                <h2 class="preguntas-frecuentes-title">Preguntas Frecuentes</h2>
            </div>

            <!-- Columna Derecha: Acordeón Dinámico de Preguntas -->
            <div class="col-12 col-lg-6">
                <div class="accordion accordion-figma" id="accordionQuestions">
                    @foreach($product->questions as $q)
                        <div class="accordion-item faq-item-container">
                            <h3 class="accordion-header" id="heading{{ $q->id }}">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ $q->id }}" 
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                        aria-controls="collapse{{ $q->id }}">
                                    
                                    <span class="faq-question-text">{{ $q->question }}</span>
                                    
                                    <!-- Contenedor del ícono encasillado de Figma -->
                                    <span class="faq-icon-box" aria-hidden="true">
                                        <i class="fa-solid fa-square-plus faq-icon-plus"></i>
                                        <i class="fa-solid fa-square-minus faq-icon-minus"></i>
                                    </span>

                                </button>
                            </h3>

                            <div id="collapse{{ $q->id }}" 
                                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                 aria-labelledby="heading{{ $q->id }}" 
                                 data-bs-parent="#accordionQuestions">
                                <div class="accordion-body faq-answer-text">
                                    {{ $q->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
        </div>
        <div class="row mt-5">
            <h2 class="mt-5 mb-5 title-related">Productos relacionados</h4>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach($related as $item)
                        <div class="swiper-slide list-products-desk">
                            <a href="/catalogo/producto/{{$item->id}}/{{$item->name}}">
                                <div class="card mb-3 card-related">
                                    <div class="card-body padding-0">
                                        <div class="row">
                                            <div class="col-md-12 col-12 padding-0">
                                                @if(count($item->gallery)>0)
                                                <img src="{{ asset('images/products/'.$item->gallery[0]->file.'') }}" alt="{{$item->name}}" class="img-d img-fluid image-list image-products-related">
                                                @endif
                                            </div>
                                            <div class="col-md-12 mt-3 info-related">
                                                <h4 class="title-product-related">{{$item->name}}</h4>
                                                <p class="vendido-po-desk">por {{$item->user->name}}</p>
                                                <p class="price">
                                                    <img src="{{ asset('images/Precio_Icono.png') }}" alt="Rango" class="img-d img-fluid">
                                                    Desde: <span>${{number_format($item->escalas[0]->price, 0, 0, '.')}} </span>
                                                </p>
                                                <!--<p class="quantity">
                                                    <img src="{{ asset('images/Cantidad_Icono.png') }}" alt="Pedido minímo" class="img-d img-fluid">
                                                    Pedido minímo: <span>{{$item->quantity_min }} </span>
                                                </p>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
        </div>
    </div>
</section><!-- End product Section -->
<!-- ======= product Section ======= -->
<section class="section-agents section-t8 mt-3 product-mobile only-product-mobile">
    <div class="container">
        <div class="row ">            
            <div class="col-md-12">
                <div id="galleryproduct" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($product->gallery as $key=>$item)
                        <button type="button" data-bs-target="#galleryproduct" data-bs-slide-to="{{$key}}" class="@if($key==0) active @endif" aria-label="Slide {{$key}}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner small-demo2">
                        @foreach($product->gallery as $key=>$item)
                        <div class="carousel-item @if($key==0) active @endif">
                            <a href="/images/products/thumbnail/{{$item->file}}">
                                <img src="{{ asset('images/products/thumbnail/'.$item->file.'') }}" alt="{{$item->name}}" class="img-d img-fluid image-list" style="max-height: initial;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#galleryproduct" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#galleryproduct" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
            <div class="col-md-12 ">
                <h2 class="title-product-view mb-2 mt-2">{{$product->name}}</h2>
                <!--<span class="seller"><i class="bi bi-star-fill"></i> Seller verificado</span>-->
            </div>
            <div class="col-md-12 mt-2">                
                <label class="quantity_min mb-4">
                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                    Pedido minímo: <span>{{$cantidadminima}} </span>
                </label>
                @if(!is_null($product->delivery_time))
                <label class="quantity_min mb-4">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                    Tiempo de entrega: <span>{{$product->delivery_time }} </span>
                </label>
                @endif
            </div>
            <div class="col-md-12">
            @if(count($product->colores)>0)
            <label style="display: block;">Elige Color:</label>
                <div style="display: inline-flex;">
                    <ul class="list-color">
                        @foreach($product->colores as $color)
                            <li><label id="color_mobile_{{$color->id}}" onclick="selectColorMobile({{$color->id}},'{{$color->file}}');"style="background: {{$color->color}};cursor:pointer;"></label></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(count($product->tallas)>0)
            <label style="display: block;">Tallas disponibles:</label>
                <div style="display: inline-flex;width: 100%;">
                    <ul class="list-tallas">
                        @foreach($product->tallas as $talla)
                            <li><label id="talla_mobile_{{$talla->id}}" onclick="selectTallaMobile({{$talla->id}});" style="cursor:pointer;position: relative;">{{$talla->talla}}</label></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>

            <div class="row mt-2">
                    <div class="col-6"><label class="text-price">${{number_format($pricemax, 0, 0, '.')}} </label> IVA Incl.</div>
                    <div class="col-6">
                    @if(count($product->escalas)>0)
                    <!-- Button trigger modal -->
                    

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-show-range" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Ver escalas
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 30px;">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title" id="exampleModalLabel">Escalas de precios</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                             
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio x Unidad</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->escalas as $escala)
                                    <tr>
                                        <td>{{$escala->quantity_min}} - {{$escala->quantity_max}}</td>
                                        <td>${{number_format($escala->price, 0, 0, '.')}}</td>                               
                                    </tr>   
                                    @endforeach                            
                                </tbody>
                            </table>
                        </div>
                       
                        </div>
                    </div>
                    </div>
                  
                    @endif

                    </div>
                </div>
                @include('site.products.partials.formquantitymobile')
                

            <div class="col-md-12 mt-3">
                <hr>
            </div>
            <div class="col-md-12 mt-3">
                <h2 class="title-product-view mb-3">Especificaciones</h2>
                {!! $product->description !!}
                <!--<div class="mt-4">
                    <a href="/catalogo/cotizacion/porducto/{{$product->id}}" class="btn btn-go-quotation btn-lg">Solicitar Cotización</a>
                </div>-->
            </div>
            <div class="col-md-12 mt-3">
                <hr>
            </div>
            @if(count($product->questions)>0)
            <div class="col-md-12">
                <h2 class="title-product-view mb-3 title-question">Preguntas Frecuentes</h2>
                <div class="accordion" id="accordionExample">
                    @foreach($product->questions as $q)
                    <div class="accordion-item item-acordeon">
                        <h2 class="accordion-header" id="heading{{$q->id}}">
                            <button class="accordion-button title-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$q->id}}" aria-expanded="true" aria-controls="collapse{{$q->id}}">
                                {{$q->question}}
                            </button>
                        </h2>
                        <div id="collapse{{$q->id}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$q->id}}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {{$q->answer}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <h2 class="mt-5 mb-5 titles-questions"><strong>Preguntas frecuentes</strong></h2>
            <div class="row mt-5">
                <!-- INICIO -->
                <div class="accordion" id="myAccordion">
                    <div class="accordion-item este">
                        <h2 class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. Por que elegir Kanbai?</button>                                  
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
                            <div class="card-body">
                                <p>HTML stands for HyperText Markup Language. HTML is the standard markup language for describing the structure of web pages. <a href="https://www.tutorialrepublic.com/html-tutorial/" target="_blank">Learn more.</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">2. Que tiene de especial este producto?</button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                            <div class="card-body">
                                <p>Bootstrap is a sleek, intuitive, and powerful front-end framework for faster and easier web development. It is a collection of CSS and HTML conventions. <a href="https://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn more.</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree">3. Como puedo dar un obsequio?</button>                     
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
                            <div class="card-body">
                                <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FINAL -->
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <h2 class="mt-5 mb-5 titles-home title-nosotros"><strong>Por que nosotros?</strong></h4>
                <div class="row mt-5">
                    <div class="col-md-3 mb-3 itemnosotros">
                        <div class="card-nosotros">
                            <img src="{{ asset('images/iconocheck.png') }}" alt="Razas" class="img-d img-nosotros">
                            Todo lo que necesita tu empresa en un solo lugar. Reunimos las mejores empresas de categorías no core todos verificados y con capacidad de cumplimiento.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 itemnosotros">
                        <div class="card-nosotros ">
                            <img src="{{ asset('images/iconocheck.png') }}" alt="Razas" class="img-d img-nosotros">
                            Ahórale dinero a tu empresa reduciendo los tiempos de investigación, vinculación y contratación.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 itemnosotros">
                        <div class="card-nosotros">
                            <img src="{{ asset('images/iconocheck.png') }}" alt="Razas" class="img-d img-nosotros">
                            Damos acompañamiento permanente a tus proyectos y los respaldamos con contratos de cumplimiento que aseguran el abastecimiento del bien.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 itemnosotros">
                        <div class="card-nosotros">
                            <img src="{{ asset('images/iconocheck.png') }}" alt="Razas" class="img-d img-nosotros">
                            La mejor relación costo beneficio. Monitoreamos el mercado para ofrecer lo mejor a los mejores precios.
                        </div>
                    </div>
                </div>
        </div>
</section><!-- End product Section -->
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    let $gallery = new SimpleLightbox('.small-demo a', {});
    let $gallery1 = new SimpleLightbox('.small-demo1 a', {});
    let $gallery2= new SimpleLightbox('.small-demo2 a', {});

    var myCarousel = document.querySelector('#galleryproduct')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 2000,
        wrap: false
    })


    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 15,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

    });


    var splide = new Splide('#main-slider', {
        pagination: false,
    });


    var thumbnails = document.getElementsByClassName('thumbnail');
    var current;


    for (var i = 0; i < thumbnails.length; i++) {
        initThumbnail(thumbnails[i], i);
    }


    function initThumbnail(thumbnail, index) {
        thumbnail.addEventListener('click', function() {
            splide.go(index);
        });
    }


    splide.on('mounted move', function() {
        var thumbnail = thumbnails[splide.index];


        if (thumbnail) {
            if (current) {
                current.classList.remove('is-active');
            }


            thumbnail.classList.add('is-active');
            current = thumbnail;
        }
    });


    splide.mount();


});

function selectColor(color,file){
    var path="{{ asset('images/products/color/') }}";
    if(file!=''){
        $('li.is-active  img').attr('src', path+'/'+file);
    }    
    $('.color-active i').remove();
    $('.color-active').removeClass('color-active');
    $('#color_'+color).append('<i class="fa fa-check" aria-hidden="true"></i>');
    $('#color_'+color).addClass('color-active');
    $('#color').val(color);
}
function selectColorMobile(color,file){
    var path="{{ asset('images/products/color/') }}";
    if(file!=''){
        $('div.carousel-inner div.active  img').attr('src', path+'/'+file);
    }  
    $('.color-active i').remove();
    $('.color-active').removeClass('color-active');
    $('#color_mobile_'+color).append('<i class="fa fa-check" aria-hidden="true"></i>');
    $('#color_mobile_'+color).addClass('color-active');
    $('#color_mobile').val(color);
}

function selectTalla(talla){
    $('.talla-active i').remove();
    $('.talla-active').removeClass('talla-active');
    $('#talla_'+talla).append('<i class="fa fa-check" aria-hidden="true"></i>');
    $('#talla_'+talla).addClass('talla-active');
    $('#size').val(talla);
}

function selectTallaMobile(talla){
    $('.talla-active i').remove();
    $('.talla-active').removeClass('talla-active');
    $('#talla_mobile_'+talla).append('<i class="fa fa-check" aria-hidden="true"></i>');
    $('#talla_mobile_'+talla).addClass('talla-active');
    $('#size_mobile').val(talla);
}



</script>
<script>
$(document).ready(function() {
    let galleryMain = null;

    // 1. Validar presencia de los contenedores en el DOM
    const mainSliderEl = document.querySelector('#main-slider');
    const thumbSliderEl = document.querySelector('#thumbnail-slider');

    if (mainSliderEl && thumbSliderEl) {
        
        // 2. Instancia del Slider Principal
        var main = new Splide('#main-slider', {
            type: 'fade',
            rewind: true,
            pagination: false,
            arrows: true,
        });

        // 3. Instancia del Slider de Miniaturas (Carrusel continuo sin scrollbar)
        var thumbnails = new Splide('#thumbnail-slider', {
            fixedWidth: 100,
            fixedHeight: 100,
            gap: 15,
            rewind: true,
            pagination: false,
            isNavigation: true, // Indica que este slider funciona como controlador
            focus: 'center',
            breakpoints: {
                600: {
                    fixedWidth: 70,
                    fixedHeight: 70,
                    gap: 10,
                },
            },
        });

        // 4. Sincronizar ambos sliders
        main.sync(thumbnails);
        main.mount();
        thumbnails.mount();
    }

    // 5. Inicialización de SimpleLightbox para las imágenes ampliadas
    if (typeof SimpleLightbox !== 'undefined') {
        galleryMain = new SimpleLightbox('#main-slider .splide__slide a', {
            overlay: true,
            caption: true,
            close: true,
        });
        window.galleryMainInstance = galleryMain;
    }
});

// 6. Función de actualización dinámica por Color
function selectColor(color, file) {
    var basePath = "{{ asset('images/products/color/') }}";
    
    if (file && file.trim() !== '') {
        var fullPath = basePath + '/' + file;
        
        var $activeSlide = $('#main-slider .splide__slide.is-active');
        if ($activeSlide.length === 0) {
            $activeSlide = $('#main-slider .splide__slide').first();
        }

        var $img = $activeSlide.find('img');
        var $link = $activeSlide.find('a');

        if ($img.length) $img.attr('src', fullPath);
        if ($link.length) $link.attr('href', fullPath);

        if (window.galleryMainInstance) {
            window.galleryMainInstance.refresh();
        }
    }

    $('.color-active i').remove();
    $('.color-active').removeClass('color-active');
    
    var $selectedColorBtn = $('#color_' + color);
    if ($selectedColorBtn.length) {
        $selectedColorBtn.append('<i class="fa fa-check" aria-hidden="true"></i>');
        $selectedColorBtn.addClass('color-active');
    }
    
    $('#color').val(color);
}
</script>
@endpush