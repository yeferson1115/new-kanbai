@extends('layouts.app')
@section('title', 'Productos')
@section('content')
<section class="section-banner-desk section-t8 " style="padding-top: 6rem;">
    @if($info['banners']!=null)
    <div id="carusel" class="carousel slide carousel-fade" data-bs-ride="carusel">
        <div class="carousel-inner">
            @foreach($info['banners'] as $key=>$item)
                @php $n = 0 @endphp 
                @if($item->type==1)               
                <div class="carousel-item @if($key==0) active @endif banner-category" style="padding: 0;">
                    <a href="{{$item->url}}" target="_blank">
                        <img style="border-radius: 0px;" src="{{ asset('images/categories/banners/'.$item->file.'') }}" class="d-block w-100"></a>  
                </div>
                @php $n++ @endphp 
                @endif
            @endforeach 
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carusel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    @endif
</section>
<section class="section-banner-mobile section-t8 " style="padding-top: 11rem;">
    @if($info['banners']!=null)
    <div id="carusel-mobile" class="carousel slide carousel-fade" data-bs-ride="carusel-mobile">
        <div class="carousel-inner">
            @foreach($info['banners'] as $key=>$item)
                @php $x = 0 @endphp 
                @if($item->type==2)               
                <div class="carousel-item @if($x==0) active @endif banner-category" >
                    <a href="{{$item->url}}" target="_blank"><img src="{{ asset('images/categories/banners/'.$item->file.'') }}" class="d-block w-100"></a>  
                </div>
                @php $x++ @endphp 
                @endif
            @endforeach 
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carusel-mobile" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carusel-mobile" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    @endif
</section>
<!-- ======= list products Section ======= -->
<section class="section-agents mb-5">
    @if($info['namesubcategory']!=null)
      <div class="container breadcrumb">
        <div class="breadcrumb2">
          <div class="breadcrumb-main">
            <div class="breadcrumb-items-core">
              <div class="text">Inicio</div>
            </div>
            <img class="chevron-right" src="{{ asset('images/iconos/chevron-right.svg') }}" />
            <div class="breadcrumb-items-core">
              <a class="text" href="/catalogo/{{ $info['slugcategory'] }}">{{$info['namecategory']}} </a>
            </div>
            <img class="chevron-right2" src="{{ asset('images/iconos/chevron-right.svg') }}" />
            <div class="breadcrumb-items-core">
              <div class="text2">{{$info['namesubcategory']}}</div>
            </div>
          </div>
        </div>
      </div>    
    @endif 

    <div class="container">
    @if($info['namesubcategory']==null)
    
        <div class="row mt-4">
          <!-- Contenedor Marquee Infinito -->
          <div class="marquee-container">
              <div class="marquee-track">
                  
                  <!-- Renderizado Original (Bloque 1) -->
                  <div class="marquee-content">
                      @foreach($categories as $item)
                          <a href="{{ url('/catalogo/' . $info['namecategory'] . '/' . $item->slug) }}" class="subcategor-a-link">
                              <article class="subcategor-a">
                                  <div class="frame-1000002470">
                                      <div class="frame-1000002469">
                                          <div class="frame-1000004279">
                                              <img 
                                                  class="icono-ilustrado" 
                                                  src="{{ asset('images/subcategories/' . $item->file) }}" 
                                                  alt="{{ $item->name }}" 
                                                  loading="lazy"
                                              />
                                          </div>
                                      </div>
                                      <div class="frame-1000002468">
                                          <span class="subcategory-title">{{ $item->name }}</span>
                                          <div class="arrow-right-up-circle">
                                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <circle cx="12" cy="12" r="12" fill="white" fill-opacity="0.2"/>
                                                  <path d="M9 15L15 9M15 9H10M15 9V14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                              </svg>
                                          </div>
                                      </div>
                                  </div>
                              </article>
                          </a>
                      @endforeach
                  </div>

                  <!-- Duplicado idéntico para completar el ciclo sin saltos (Bloque 2) -->
                  <div class="marquee-content" aria-hidden="true">
                      @foreach($categories as $item)
                          <a href="{{ url('/catalogo/' . $info['namecategory'] . '/' . $item->slug) }}" class="subcategor-a-link" tabindex="-1">
                              <article class="subcategor-a">
                                  <div class="frame-1000002470">
                                      <div class="frame-1000002469">
                                          <div class="frame-1000004279">
                                              <img 
                                                  class="icono-ilustrado" 
                                                  src="{{ asset('images/subcategories/' . $item->file) }}" 
                                                  alt="{{ $item->name }}" 
                                                  loading="lazy"
                                              />
                                          </div>
                                      </div>
                                      <div class="frame-1000002468">
                                          <span class="subcategory-title">{{ $item->name }}</span>
                                          <div class="arrow-right-up-circle">
                                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <circle cx="12" cy="12" r="12" fill="white" fill-opacity="0.2"/>
                                                  <path d="M9 15L15 9M15 9H10M15 9V14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                              </svg>
                                          </div>
                                      </div>
                                  </div>
                              </article>
                          </a>
                      @endforeach
                  </div>

              </div>
          </div>
      </div>
        

        @if($info['bannerscommerce']!=null)
        <div class="row mt-4">
            <!-- Slider -->
            <div class="slider bannerscommerce">
                @foreach($info['bannerscommerce'] as $item) 
                @if((new \Jenssegers\Agent\Agent())->isDesktop() || (new \Jenssegers\Agent\Agent())->isTablet())
                @if($item->type==1)                
                <a href="{{$item->url}}" target="_blank">
                    <img style="border-radius: 20px;    max-width: 100%;" src="{{ asset('images/categories/commerce/desk/'.$item->file) }}" alt="" />
                </a>
                @endif
                @endif
                @if((new \Jenssegers\Agent\Agent())->isMobile())
                @if($item->type==2)                
                <a href="{{$item->url}}" target="_blank">
                    <img style="border-radius: 20px;    max-width: 100%;" src="{{ asset('images/categories/commerce/mobile/'.$item->file) }}" alt="" />
                </a>
                @endif
                @endif
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty($info['imagesattributes']))
          <div class="row mt-4">
              <div class="feature-cards-grid">
                  @foreach($info['imagesattributes'] as $item)
                      @php
                          $cleanTitle = trim($item->title);
                          $words = array_values(array_filter(explode(' ', $cleanTitle)));
                          $firstWord = !empty($words) ? array_shift($words) : '';
                          $restOfTitle = !empty($words) ? implode(' ', $words) : '';
                      @endphp

                      <div class="feature-card">
                          <!-- Columna Imagen: Ancho automático según la imagen -->
                          <div class="feature-card__col-image">
                              <img 
                                  class="feature-card__image" 
                                  src="{{ asset('images/categories/attributes/' . $item->file) }}" 
                                  alt="{{ $cleanTitle }}"
                                  loading="lazy"
                              />
                          </div>

                          <!-- Columna Texto: Pegada inmediatamente a la derecha de la imagen -->
                          <div class="feature-card__col-content">
                              <h3 class="feature-card__title">
                                  <span class="feature-card__title--primary">{{ $firstWord }}</span>
                                  @if($restOfTitle !== '')
                                      <br><span class="feature-card__title--secondary">{{ $restOfTitle }}</span>
                                  @endif
                              </h3>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
          @endif
        @endif
        <div class="mt-5">
         @livewire('productos',['info'=>$info])
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
    
    $(document).ready(function(){
        $('.imagesattributes').slick({
  dots: false,
	prevArrow: $('.prev'),
	nextArrow: $('.next'),
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
$('.responsive').slick({
  dots: false,
  autoplay:true,
	prevArrow: $('.prev'),
	nextArrow: $('.next'),
  infinite: false,
  speed: 300,
  slidesToShow: 7,
  slidesToScroll: 7,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 5,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

$('.bannerscommerce').slick({
  dots: false,
	prevArrow: $('.prev'),
	nextArrow: $('.next'),
  infinite: false,
  speed: 300,
  slidesToShow: 2,
  slidesToScroll: 2,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});


    var myCarousel = document.querySelector('#carusel')
    var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 2000,
    wrap: false
    });

});

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var subcategoryCarousel = document.querySelector('#subcategoryCarousel');
        if (subcategoryCarousel) {
            new bootstrap.Carousel(subcategoryCarousel, {
                interval: 3500,
                pause: false,
                wrap: true
            });
        }
    });
</script>

</script>
@endpush
