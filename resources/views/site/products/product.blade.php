@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<!-- ======= product Section ======= -->
<section class="section-agents section-t8 mt-5 product-desk only-product-desk">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row ">
                    <div class="col-2">
                        <ul id="thumbnails" class="thumbnails small-demo1">
                            @foreach($product->gallery as $item)
                            <li class="thumbnail">
                                <a href="{{ asset('images/products/'.$item->file.'') }}">
                                    <img src="{{ asset('images/products/thumbnail/list/'.$item->file.'') }}" />
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-10">
                        <div id="main-slider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list small-demo">
                                    @foreach($product->gallery as $item)
                                    <li class="splide__slide">
                                        <a href="{{ asset('images/products/thumbnail/'.$item->file.'') }}">
                                            <img src="{{ asset('images/products/thumbnail/'.$item->file.'') }}" />
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($product->questions)>0)
                <div class="col-md-12 mt-5">
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
            <div class="col-md-6 content-info-product">

                <h2 class="title-product-view mb-3">{{$product->name}}</h2>

                <label class="quantity_min mb-3">
                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                    Pedido minímo: <span>{{$cantidadminima }} </span>
                </label>
                @if(!is_null($product->delivery_time))
                <label class="quantity_min mb-3">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                    Tiempo de entrega: <span>{{$product->delivery_time }} </span>
                </label>
                @endif
                <div class="col-md-12">
                    @if(count($product->colores)>0)
                        <label style="display: block;">Elige Color:</label>
                        <div style="display: inline-flex;">
                            <ul class="list-color">
                                @foreach($product->colores as $color)
                                    <li><label id="color_{{$color->id}}" onclick="selectColor({{$color->id}},'{{$color->file}}');" style="background: {{$color->color}};cursor:pointer;"></label></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(count($product->tallas)>0)
                        <label style="display: block;">Tallas disponibles:</label>
                        <div style="display: inline-flex;width: 100%;">
                            <ul class="list-tallas">
                                @foreach($product->tallas as $talla)
                                    <li><label id="talla_{{$talla->id}}" onclick="selectTalla({{$talla->id}});" style="cursor:pointer;position: relative;">{{$talla->talla}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-6"><label class="text-price">${{number_format($pricemax, 0, 0, '.')}}</label> IVA Incl.</div>
                    <div class="col-md-6">
                    @if(count($product->escalas)>0)
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-show-range" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Ver escalas
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 30px;">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title" id="staticBackdropLabel">Escalas de precios</h5>
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

                

                
                @include('site.products.partials.formquantity')
                    <hr>
                {!! $product->description !!}
                
                <!--<div class="mt-4">
                    <a href="/catalogo/cotizacion/porducto/{{$product->id}}" class="btn btn-go-quotation btn-lg">Solicitar Cotización</a>
                </div>-->
            </div>
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
@endpush
