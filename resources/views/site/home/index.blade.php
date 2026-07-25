@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<!-- END SERVICES -->
<section class="section-agents section-t8 home">

<section class="hero-banner py-4 py-lg-5">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <!-- Columna Izquierda: Contenido de Texto -->
            <div class="col-lg-5 col-12">
                <div class="hero-content">
                    <h1 class="hero-title mb-4 mb-lg-5">
                        Todo para tu empresa en <span class="text-highlight">un solo lugar.</span>
                    </h1>
                    <a href="#productos" class="btn-primary-custom">
                        Explorar productos
                    </a>
                </div>
            </div>

            <!-- Columna Derecha: Imagen Ilustrativa -->
            <div class="col-lg-7 col-12 text-center">
                <div class="hero-media">
                    <img 
                        src="{{ asset('images/bannerinicio.png') }}" 
                        alt="Todo para tu empresa en un solo lugar" 
                        class="img-fluid hero-img"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>
    </div>
</section>
    <!--<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if((new \Jenssegers\Agent\Agent())->isDesktop() || (new \Jenssegers\Agent\Agent())->isTablet())
            @foreach($banners as $key=>$banner)
            <div class="carousel-item @if($key==0) active @endif desk">
                <a target="_blank" href="{{$banner->url_desk}}">
                    <img src="{{ asset('images/banners/desktop/'.$banner->imagedesk) }}" class="d-block w-100" alt="...">
                </a>
            </div>
            @endforeach
            @endif
            @if((new \Jenssegers\Agent\Agent())->isMobile())
            @foreach($banners as $key=>$banner)
            <div class="carousel-item @if($key==0) active @endif banner-mobile">
                <a target="_blank" href="{{$banner->url_mobile}}">
                    <img src="{{ asset('images/banners/mobile/'.$banner->imagemobile) }}" class="d-block w-100" >
                </a>
            </div>
            @endforeach
            @endif
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>-->


    <div class="container">
        <section class="categories-section">
            <h2 class="categories-title">Categorías únicas</h2>

            <div class="categories-grid">
                @foreach($categories as $item)
                @if($item->name != 'EasyGift')
                    <a href="{{ route('categories.show', $item->slug ?? $item->id) }}" class="category-card" title="{{ $item->name }}">
                        <!-- Contenedor Visual de la Imagen -->
                        <div class="card-media">
                            <img 
                                class="category-image" 
                                src="{{ asset('images/categories/' . $item->file) }}" 
                                alt="Categoría {{ $item->name }}"
                                loading="lazy"
                            />
                        </div>

                        <!-- Pie de la tarjeta: Nombre e Icono -->
                        <div class="card-footer">
                            <span class="category-name">{{ $item->name }}</span>
                            <div class="category-icon-wrapper">
                                <img 
                                    class="category-icon" 
                                    src="{{ asset('images/iconos/arrow-right-up-circle.svg') }}" 
                                    alt="Ir a {{ $item->name }}" 
                                />
                            </div>
                        </div>
                    </a>
                    @endif
                @endforeach
            </div>
        </section>
    </div>

    <section class="empresas-section">
        <h2 class="empresas-title">Empresas que confían en nosotros</h2>
        
        <div class="empresas-banner">
            <div class="swiper mySwiperclientes ">
            <div class="swiper-wrapper">
                @foreach($imagesFactory as $img)
                <div class="swiper-slide empresas-slide">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <img src="{{ asset($img.'?'.rand()) }}" alt="{{ $img }}" class="img-d img-fluid">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="swiper mySwiperclientesmobile ">
            <div class="swiper-wrapper">              
                @foreach($imagesFactory as $img)
                <div class="swiper-slide empresas-slide">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <img src="{{ asset($img.'?'.rand()) }}" alt="{{ $img }}" class="img-d img-fluid">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        </div>
    </section>

    
    <div class="container">
        <section class="feature-card">
            <div class="feature-card__media-wrapper">
                <img 
                class="feature-card__media" 
                src="{{ asset('images/queeskanbai.png') }}" 
                alt="Plataforma de compras corporativas Kanbai" 
                loading="lazy" 
                width="650" 
                height="433"
                />
            </div>
            
            <div class="feature-card__content">
                <h2 class="feature-card__title">¿Qué es Kanbai?</h2>
                <p class="feature-card__description">
                Kanbai es una plataforma empresarial creada para simplificar y
                modernizar las compras corporativas. Su propuesta consiste en reunir
                múltiples soluciones en un solo lugar, eliminando la complejidad de
                tratar con numerosos proveedores y procesos lentos. Kanbai se
                posiciona como un ecosistema ágil, creativo y humano, enfocado en
                ahorrar tiempo, reducir fricción y resolver necesidades empresariales
                de manera eficiente.
                </p>
                <p class="feature-card__highlight">
                Te damos la bienvenida al futuro de las compras empresariales.
                </p>
            </div>
        </section>
    </div>

    <div class="container">
        <section class="why-us">
            <div class="why-us__container">
                <h2 class="why-us__title">¿Por qué elegirnos?</h2>

                <div class="why-us__grid">
                <!-- Tarjeta 1 -->
                <article class="why-card">
                    <div class="why-card__icon-wrapper">
                    <img 
                        src="{{ asset('images/iconos/GP1.svg') }}" 
                        alt="Icono red de proveedores" 
                        class="why-card__icon" 
                        loading="lazy" 
                        width="116" 
                        height="128"
                    />
                    </div>
                    <div class="why-card__body">
                    <h3 class="why-card__title">Un solo aliado para todas tus compras corporativas.</h3>
                    <p class="why-card__description">
                        Accede a una red de proveedores verificados y soluciones empresariales sin gestionar múltiples contactos.
                    </p>
                    </div>
                </article>

                <!-- Tarjeta 2 -->
                <article class="why-card">
                    <div class="why-card__icon-wrapper">
                    <img 
                        src="{{ asset('images/iconos/GP2.svg') }}" 
                        alt="Icono optimización de procesos" 
                        class="why-card__icon" 
                        loading="lazy" 
                        width="196" 
                        height="129"
                    />
                    </div>
                    <div class="why-card__body">
                    <h3 class="why-card__title">Menos gestión, más resultados.</h3>
                    <p class="why-card__description">
                        Optimiza tiempos y elimina procesos innecesarios en la búsqueda y contratación de proveedores.
                    </p>
                    </div>
                </article>

                <!-- Tarjeta 3 -->
                <article class="why-card">
                    <div class="why-card__icon-wrapper">
                    <img 
                        src="{{ asset('images/iconos/GP3.svg') }}" 
                        alt="Icono acompañamiento estratégico" 
                        class="why-card__icon" 
                        loading="lazy" 
                        width="150" 
                        height="128"
                    />
                    </div>
                    <div class="why-card__body">
                    <h3 class="why-card__title">Acompañamiento que respalda cada decisión.</h3>
                    <p class="why-card__description">
                        Estamos presentes en cada proyecto, garantizando seguimiento, cumplimiento y tranquilidad.
                    </p>
                    </div>
                </article>

                <!-- Tarjeta 4 -->
                <article class="why-card">
                    <div class="why-card__icon-wrapper">
                    <img 
                        src="{{ asset('images/iconos/GP4.svg') }}" 
                        alt="Icono máximo valor de inversión" 
                        class="why-card__icon" 
                        loading="lazy" 
                        width="144" 
                        height="129"
                    />
                    </div>
                    <div class="why-card__body">
                    <h3 class="why-card__title">Más valor por cada inversión.</h3>
                    <p class="why-card__description">
                        Analizamos el mercado constantemente para ofrecer la mejor combinación entre calidad, servicio y precio.
                    </p>
                    </div>
                </article>
                </div>
            </div>
        </section>
    </div>

    <div class="container">

        <section class="testimonials" aria-label="Opiniones de clientes">
            <div class="testimonials__container" style="padding: 0px 75px;">
                <h2 class="testimonials__title">¿Qué dicen nuestros clientes?</h2>

                <!-- Tarjeta de Testimonio -->
                <article class="testimonial-card">
                <!-- Columna Izquierda: Imagen del Cliente con Fondo Violeta -->
                <div class="testimonial__media">
                    <img 
                    id="testimonial-image"
                    class="testimonial__avatar" 
                    src="{{ asset('images/testimonios/felipe.png') }}" 
                    alt="Fotografía de Felipe Roldan Zuluaga" 
                    loading="lazy"
                    width="453"
                    height="435"
                    />
                </div>

                <!-- Columna Derecha: Contenido del Testimonio y Navegación -->
                <div class="testimonial__content">
                    <div class="testimonial__body">                    
                    <img 
                        src="{{ asset('images/iconos/comillas.png') }}" 
                        class="testimonial__quote-icon" 
                        loading="lazy" 
                        width="47" 
                        height="37"
                    />
                    
                    <blockquote class="testimonial__quote">
                        <p id="testimonial-text" class="testimonial__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </blockquote>

                    <div class="testimonial__author">
                        <strong id="testimonial-name" class="testimonial__name">Felipe Roldan Zuluaga</strong>
                        <span id="testimonial-role" class="testimonial__role">CEO Kanbai</span>
                    </div>
                    </div>

                    <!-- Botones de Control de Navegación -->
                    <div class="testimonial__nav">
                    <button id="btn-prev" class="testimonial__control" aria-label="Testimonio anterior" type="button">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <circle cx="16" cy="16" r="15.5" stroke="#0E0D35"/>
                        <path d="M18 20L14 16L18 12" stroke="#0E0D35" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    
                    <button id="btn-next" class="testimonial__control" aria-label="Siguiente testimonio" type="button">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <circle cx="16" cy="16" r="15.5" stroke="#0E0D35"/>
                        <path d="M14 12L18 16L14 20" stroke="#0E0D35" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    </div>
                </div>
                </article>

                <!-- Indicadores de Paginación -->
                <div id="testimonial-indicators" class="testimonials__indicators" role="tablist" aria-label="Seleccionar testimonio">
                <!-- Los puntos se generan dinámicamente con JavaScript -->
                </div>
            </div>
        </section>

  
    </div>
 
    <div class="conatainer">

        <section class="news-products-section mt-5">
    <!-- Encabezados de la Sección -->
    <h2 class="titles-home title-new-products">
        Nuestros productos más populares
    </h2>
    <p class="text-center subtitle-new-products">Productos nuevos todas las semanas</p>

    <!-- Carrusel Swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($newproducts as $item)
                <div class="swiper-slide">
                    <a href="{{ url('/catalogo/producto/' . $item->id . '/' . \Illuminate\Support\Str::slug($item->name)) }}" 
                       class="tarjeta-producto-link" 
                       title="{{ $item->name }}">
                        
                        <article class="tarjeta-productos">
                            <div class="tarjeta-content">
                                <!-- Contenedor de Imagen -->
                                <div class="product-image-container">
                                    @if(isset($item->gallery) && count($item->gallery) > 0)
                                        <img src="{{ asset('images/products/' . $item->gallery[0]->file) }}" 
                                             alt="{{ $item->name }}" 
                                             class="product-image"
                                             loading="lazy">
                                    @else
                                        <img src="{{ asset('images/placeholder.png') }}" 
                                             alt="{{ $item->name }}" 
                                             class="product-image"
                                             loading="lazy">
                                    @endif
                                </div>

                                <!-- Detalles del Producto -->
                                <div class="product-info">
                                    <h3 class="product-title">{{ $item->name }}</h3>
                                    
                                    <div class="product-meta">
                                        <p class="product-price">
                                            Desde: 
                                            <strong>
                                                @if(isset($item->escalas) && count($item->escalas) > 0)
                                                    ${{ number_format($item->escalas[0]->price, 0, ',', '.') }}
                                                @else
                                                    N/A
                                                @endif
                                            </strong>
                                        </p>
                                        <p class="product-quantity">
                                            Pedido mínimo: <strong>{{ $item->quantity_min ?? 1 }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>

                    </a>
                </div>
            @endforeach
        </div>

        <!-- Botones de Navegación del Carrusel -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
    
    </div>
    
   
    </div>
</section>

<div class="container">

    <section class="meeting-section py-5">
    <div class="container">
        <div class="meeting-card">
            <div class="row align-items-center g-4">
                <!-- Columna Izquierda: Formulario e Información -->
                <div class="col-lg-7 col-12">
                    <div class="meeting-content">
                        <!-- Cabecera -->
                        <div class="meeting-header mb-4">
                            <h2 class="meeting-title">Creemos algo especial</h2>
                            <p class="meeting-subtitle">
                                Las mejores soluciones nacen de una buena conversación. Cuéntanos qué necesita tu empresa y encontraremos la mejor manera de hacerlo realidad.
                            </p>
                        </div>

                        <!-- Formulario Laravel AJAX -->
                        <form class="meeting-form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('agendar-reunion') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">

                            <!-- Grid de Inputs de 2 Columnas -->
                            <div class="inputs-grid">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="name" class="form-label">Nombre</label>
                                    <div class="input-wrapper">
                                        <input type="text" class="custom-input" id="name" name="name" placeholder="Nombre">
                                    </div>
                                    <span class="missing_alert text-danger" id="name_alert"></span>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-wrapper">
                                        <input type="email" class="custom-input" id="email" name="email" placeholder="ejemplo@gmail.com">
                                    </div>
                                    <span class="missing_alert text-danger" id="email_alert"></span>
                                </div>

                                <!-- Teléfono -->
                                <div class="form-group">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <div class="input-wrapper">
                                        <input type="tel" class="custom-input" id="phone" name="phone" placeholder="0000000000">
                                    </div>
                                    <span class="missing_alert text-danger" id="phone_alert"></span>
                                </div>

                                <!-- Empresa -->
                                <div class="form-group">
                                    <label for="organization" class="form-label">Empresa</label>
                                    <div class="input-wrapper">
                                        <input type="text" class="custom-input" id="organization" name="organization" placeholder="Nombre empresa">
                                    </div>
                                    <span class="missing_alert text-danger" id="organization_alert"></span>
                                </div>
                            </div>

                            <!-- Textarea (Fila Completa) -->
                            <div class="form-group mt-3">
                                <label for="message" class="form-label">¿En qué podemos ayudarte?</label>
                                <div class="input-wrapper">
                                    <textarea class="custom-textarea" id="message" name="message" rows="3" placeholder="Escribe tu mensaje..."></textarea>
                                </div>
                                <span class="missing_alert text-danger" id="message_alert"></span>
                            </div>

                            <!-- Botón de Envío -->
                            <div class="form-actions mt-4">
                                <button type="submit" class="btn-submit-primary">
                                    Agendar reunión
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Columna Derecha: Imagen Ilustrativa -->
                <div class="col-lg-5 col-12 text-center">
                    <div class="meeting-image-container">
                        <img src="{{ asset('images/kanbaicontacto.png') }}" alt="Agendar reunión" class="img-fluid meeting-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>




@endsection
@push('scripts')
<script src="{{ asset('js/app/schedulemeeting/create.js') }}"></script>
<script>
$(document).ready(function() {

    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
        loopFillGroupWithBlank: true,


        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

    });

    var swiper = new Swiper(".mySwiperclientesmobile", {
        slidesPerView: 3,
        spaceBetween: 15,
        loop: true,
        loopFillGroupWithBlank: true,

        autoplay: {
            delay: 500,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

    });

    var swiper = new Swiper(".mySwiperclientes", {
        slidesPerView: 7,
        spaceBetween: 15,
        loop: true,
        loopFillGroupWithBlank: true,

        autoplay: {
            delay: 500,
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

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


   
});

document.addEventListener("DOMContentLoaded", () => {
  // Datos del carrusel de testimonios
  const testimonials = [
    {
      name: "Felipe Roldan Zuluaga",
      role: "CEO Kanbai",
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
      image: "{{ asset('images/testimonios/felipe.png') }}"
    },
    {
      name: "María Camila Gómez",
      role: "Directora de Compras - Nutresa",
      text: "La plataforma de Kanbai redujo nuestros tiempos de adquisición de suministros corporativos en un 40%. La atención y el seguimiento constante respaldan cada operación.",
      image: "{{ asset('images/testimonios/felipe.png') }}"
    },
    {
      name: "Carlos Eduardo Silva",
      role: "VP de Operaciones - Bancolombia",
      text: "Unificar múltiples proveedores en un solo portal nos dio una visibilidad financiera impecable. Totalmente recomendado para empresas de gran escala.",
      image: "{{ asset('images/testimonios/felipe.png') }}"
    }
  ];

  let currentIndex = 0;

  // Selección de elementos del DOM
  const imgEl = document.getElementById("testimonial-image");
  const textEl = document.getElementById("testimonial-text");
  const nameEl = document.getElementById("testimonial-name");
  const roleEl = document.getElementById("testimonial-role");
  const btnPrev = document.getElementById("btn-prev");
  const btnNext = document.getElementById("btn-next");
  const indicatorsContainer = document.getElementById("testimonial-indicators");
  const bodyEl = document.querySelector(".testimonial__body");

  // Renderizar indicadores dinámicamente
  function renderIndicators() {
    indicatorsContainer.innerHTML = "";
    testimonials.forEach((_, index) => {
      const button = document.createElement("button");
      button.classList.add("testimonials__indicator");
      
      if (index === currentIndex) {
        button.classList.add("testimonials__indicator--active");
        button.setAttribute("aria-selected", "true");
      } else {
        button.setAttribute("aria-selected", "false");
      }
      
      button.setAttribute("aria-label", `Ir al testimonio ${index + 1}`);
      button.addEventListener("click", () => goToSlide(index));
      indicatorsContainer.appendChild(button);
    });
  }

  // Actualizar contenido con micro-animación de desvanecimiento
  function updateTestimonial() {
    bodyEl.style.opacity = "0";
    imgEl.style.opacity = "0";

    setTimeout(() => {
      const item = testimonials[currentIndex];
      textEl.textContent = item.text;
      nameEl.textContent = item.name;
      roleEl.textContent = item.role;
      imgEl.src = item.image;
      imgEl.alt = `Fotografía de ${item.name}`;

      bodyEl.style.opacity = "1";
      imgEl.style.opacity = "1";
    }, 150);

    // Sincronizar estado de las viñetas
    const indicators = indicatorsContainer.querySelectorAll(".testimonials__indicator");
    indicators.forEach((ind, i) => {
      if (i === currentIndex) {
        ind.classList.add("testimonials__indicator--active");
        ind.setAttribute("aria-selected", "true");
      } else {
        ind.classList.remove("testimonials__indicator--active");
        ind.setAttribute("aria-selected", "false");
      }
    });
  }

  function goToSlide(index) {
    currentIndex = index;
    updateTestimonial();
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % testimonials.length;
    updateTestimonial();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
    updateTestimonial();
  }

  // Controladores de eventos
  btnNext.addEventListener("click", nextSlide);
  btnPrev.addEventListener("click", prevSlide);

  // Inicialización
  renderIndicators();
});

</script>
@endpush
