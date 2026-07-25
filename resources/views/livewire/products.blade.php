



<div class="row" id="list-products">
    <div class="col-md-12 filtro-mobile mb-2 ">
        <div class="row">
            <div class="col-8">
                <h2 class="title-categoryorsub">
                @if($info['namesubcategory']==null)
                {{$info['namecategory']}}
                @else
                    {{$info['namesubcategory']}}
                @endif
                </h2>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-warning btn-filter" id='toggle'>Filtro</button>
            </div>
        </div>

        <div id='content' class="is-hidden">

            @if($info['subcategory_id']==null)
            <div class="row mb-4 mt-5">
                <h4 class="title-filter">Subcategorias</h4>
                <input type="hidden" value="{{$subcategories = App\Models\SubCategories::where('category_id',$info['category_id'])->with('category')->get()}}">
                @foreach ($subcategories as $subcategory)
                    <div class="col-6">
                        <a class="dropdown-item bt-subcategory-filter {{ (request()->is('catalogo/$subcategory->category->slug/subcategory->slug')) ? 'active' : '' }}" href="/catalogo/{{ $subcategory->category->slug }}/{{ $subcategory->slug }}">
                        <img class="image-subcategory-list-product" src="{{ asset('images/subcategories/'.$subcategory->file.'') }}" alt="{{ $subcategory->name }}">
                        {{ $subcategory->name }}</a>
                    </div>
                @endforeach
            </div>
            @endif
            <!--<div class="row background-item-filter mb-4">
                <div class="col-9">
                    <label class="form-check-label" for="shipping_price">Envío gratis</label>
                </div>
                <div class="col-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" wire:model="shipping_price" id="shipping_price">
                    </div>
                </div>
            </div>-->
            <div class="form-group">
                <label for="exampleFormControlSelect1">Ordenar por</label>
                <select class="form-control" wire:model="keyword" id="exampleFormControlSelect1">
                    <option >Seleccione</option>
                    <option value="1">Por defecto</option>
                    <option value="2" >Últimos</option>
                    <option value="3">Por Precio: bajo a alto</option>
                    <option value="4">Por Precio: alto a bajo</option>
                </select>
            </div>

            <div class="form-group">
                <div class="mall-property mt-3">
                    <div class="mall-property__label" >
                        Precio
                    </div>
                    <div class="row filter-container-1">
                    <div class="col-md-6 col-6">
                        <input type="number" min="0" class="form-control" wire:model.lazy="min_price" placeholder="Precio mínimo">
                    </div>
                    <div class="col-md-6 col-6">
                        <input type="number" min="0" class="form-control" wire:model.lazy="max_price" placeholder="Precio máximo">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


        <div class="col-md-3 filtro-desk">

        @if($info['subcategory_id']==null)
            <input type="hidden" value="{{$subcategories = App\Models\SubCategories::where('category_id',$info['category_id'])->with('category')->get()}}">

        @endif

            <div class="filtro-desk">
                <aside class="filter-sidebar">
                    <!-- Título de Categoría / Subcategoría -->
                    <h2 class="filter-sidebar__title">
                        {{ $info['namesubcategory'] ?? $info['namecategory'] }}
                    </h2>
                    <hr class="filter-sidebar__divider" />

                    <!-- Acordeón / Lista de Subcategorías -->
                    @if(empty($info['subcategory_id']) && isset($subcategories) && $subcategories->count() > 0)
                        <div class="filter-accordion">
                            <details class="filter-accordion__item" open>
                                <summary class="filter-accordion__header">
                                    <span class="filter-accordion__title">Subcategorías</span>
                                    <svg class="filter-accordion__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 9l6 6 6-6"/>
                                    </svg>
                                </summary>
                                <div class="filter-accordion__content">
                                    <ul class="subcategory-list">
                                        @foreach ($subcategories as $subcategory)
                                            <li class="subcategory-list__item">
                                                <a class="subcategory-list__link {{ request()->is('catalogo/' . $subcategory->category->slug . '/' . $subcategory->slug) ? 'is-active' : '' }}"
                                                href="{{ url('/catalogo/' . $subcategory->category->slug . '/' . $subcategory->slug) }}">
                                                    @if($subcategory->file)
                                                        <img class="subcategory-list__img"
                                                            src="{{ asset('images/subcategories/' . $subcategory->file) }}"
                                                            alt="{{ $subcategory->name }}"
                                                            loading="lazy">
                                                    @endif
                                                    <span>{{ $subcategory->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </details>
                        </div>
                    @endif

                    <!-- Filtro Presupuesto / Rango de Precio -->
                    <div class="filter-accordion">
                        <details class="filter-accordion__item" open>
                            <summary class="filter-accordion__header">
                                <span class="filter-accordion__title">Presupuesto</span>
                                <svg class="filter-accordion__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </summary>
                            <div class="filter-accordion__content">
                                <div class="price-range">
                                    <div class="price-range__inputs">
                                        <input type="number" min="0" class="form-control" wire:model.lazy="min_price" placeholder="Precio mínimo">
                                        <input type="number" min="0" class="form-control" wire:model.lazy="max_price" placeholder="Precio máximo">
                                    </div>
                                </div>
                            </div>
                        </details>
                    </div>

                    <!-- Filtro Ordenar Por (Select) -->
                    <div class="filter-accordion">
                        <details class="filter-accordion__item" open>
                            <summary class="filter-accordion__header">
                                <span class="filter-accordion__title">Cantidad</span>
                                <svg class="filter-accordion__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </summary>
                            <div class="filter-accordion__content">
                                <input type="number" min="1" class="form-control" wire:model.lazy="quantity" placeholder="Cantidad requerida">
                            </div>
                        </details>
                    </div>

                    <!-- Toggles de estado (Entrega inmediata / Personalizable) -->
                    <div class="filter-toggle">
                        <label class="filter-toggle__label" for="immediate_delivery">Entrega inmediata</label>
                        <label class="ui-switch">
                            <input type="checkbox" id="immediate_delivery" wire:model="immediate_delivery">
                            <span class="ui-switch__slider"></span>
                        </label>
                    </div>

                    <div class="filter-toggle">
                        <label class="filter-toggle__label" for="customizable">Personalizable</label>
                        <label class="ui-switch">
                            <input type="checkbox" id="customizable" wire:model="customizable">
                            <span class="ui-switch__slider"></span>
                        </label>
                    </div>

                    <!-- Botón Limpiar Filtros -->
                    <button type="button" class="btn-filter-reset" wire:click="resetFilters">
                        Limpiar filtros
                    </button>

                    <!-- Card Banner Promo "Crear Proyecto" -->
                    <div class="banner-promo">
                        <div class="banner-promo__image-wrapper">
                            <img src="{{ asset('images/iconos/kanbai1.png') }}"
                                alt="Ilustración proyecto"
                                class="banner-promo__img"
                                loading="lazy">
                        </div>
                        <h3 class="banner-promo__title">¿No encuentras lo que buscas?</h3>
                        <p class="banner-promo__description">
                            Cuéntanos qué necesitas y construiremos una propuesta a tu medida.
                        </p>
                        <a href="{{ url('/solicitud-personalizada') }}" class="btn-primary-action">
                            Crear proyecto
                        </a>
                    </div>
                </aside>
            </div>

        </div>



        <div class="col-md-9 mt-5 products-list-mobile">

            <!-- Contenedor principal que empuja el control a la derecha -->
<div class="sorting-toolbar">
    <div class="sort-container">
        <!-- Label a la izquierda, perfectamente alineado verticalmente -->
        <label for="sort-keyword-select" class="sort-label">Ordenar</label>

        <div class="filter-accordion__content">
            <select
                id="sort-keyword-select"
                class="form-select filter-select sort-select-clean"
                wire:model="keyword"
                aria-label="Ordenar productos"
            >
                <option value="">Seleccione</option>
                <option value="1">Por defecto</option>
                <option value="2">Últimos</option>
                <option value="3">Por Precio: bajo a alto</option>
                <option value="4">Por Precio: alto a bajo</option>
            </select>
        </div>
    </div>
</div>
            <div class="catalogo-wrapper">
    <!-- Grid Unificado de Productos (Móvil y Desktop) -->
    <div class="products-grid">
        @foreach($products as $item)
            @php
                // Mantenemos tu lógica inline intacta
                $imagen = $item->gallery->first();
                $primeraEscala = $item->escalas->first();
                $precio = $primeraEscala ? $primeraEscala->price : 0;

                $precioMinimo = App\Models\ProductsPriceRange::where('product_id', $item->id)
                    ->orderBy('quantity_min', 'asc')
                    ->first();
            @endphp

            <article class="tarjeta-producto">
                <a href="{{ url('/catalogo/producto/'.$item->id.'/'.Str::slug($item->name)) }}" class="tarjeta-link">

                    <!-- Contenedor de Imagen -->
                    <div class="imagen-wrapper">
                        @if($imagen)
                            <img class="imagen-producto" src="{{ asset('images/products/thumbnail/list/'.$imagen->file) }}" alt="{{ $item->name }}" />
                        @else
                            <img class="imagen-producto" src="{{ asset('images/placeholder.png') }}" alt="Sin imagen" />
                        @endif
                    </div>

                    <!-- Detalles del Producto -->
                    <div class="info-producto">

                        <!-- Lista de Colores -->
                        @if($item->colores->count() > 0)
                            <div class="colores-container">
                                @foreach($item->colores as $color)
                                    <span class="color-bullet" style="background-color: {{ $color->color }};" title="Color"></span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Lista de Tallas -->
                        @if($item->tallas->count() > 0)
                            <div class="tallas-container">
                                @foreach($item->tallas as $talla)
                                    <span class="talla-badge">{{ $talla->talla }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Título del Producto -->
                        <h3 class="titulo-producto">{{ $item->name }}</h3>

                        <!-- Meta: Precios y Cantidades -->
                        <div class="meta-producto">
                            <div class="meta-row">
                                <span class="meta-texto">
                                    Desde: <strong>${{ number_format($precio, 0, ',', '.') }}</strong>
                                </span>
                            </div>

                            @if($precioMinimo)
                                <div class="meta-row">
                                    <span class="meta-texto">
                                        Pedido mínimo: <strong>{{ $precioMinimo->quantity_min }}</strong>
                                    </span>
                                </div>
                            @endif
                        </div>

                    </div>
                </a>
            </article>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="paginacion-wrapper">
        {{ $products->links() }}
    </div>
</div>

            <div class="row">


            @foreach($products as $item)
            <!--Estructura desk-->

            <input type="hidden" value="{{$cantidadminima = App\Models\ProductsPriceRange::where('product_id',$item->id)->min('quantity_min')}}">

            <!--Fin Estructura desk-->
            <!--Estructura mobile-->

            <div class="col-6 list-products-mobile">
                <a href="/catalogo/producto/{{$item->id}}/{{$item->name}}">
                    <div class="card card-products-mobile mb-3 mt-3" >
                        <div class="card-body cardproducts">
                            <div class="row card-mobile-list">
                                <div class="col-md-12 col-12 content-image-mobile" >

                                <div class="image-thumnail" @if(count($item->gallery)>0) style="background-image: url({{ asset('images/products/thumbnail/list/'.$item->gallery[0]->file.'') }});" @endif></div>

                                </div>
                                <div class="col-md-12 col-12 info-list-mobile">
                                @if(count($item->colores)>0)
                                    <div style="display: inline-flex;">
                                        <ul class="list-color">
                                            @foreach($item->colores as $color)
                                            <li><label style="background: {{$color->color}};"></label></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @if(count($item->tallas)>0)
                                    <div style="display: inline-flex;width: 100%;">
                                        <ul class="list-tallas">
                                            @foreach($item->tallas as $talla)
                                            <li><label>{{$talla->talla}}</label></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <h5 class="card-title title-card-products mb-2 title-card-mobile-list">{{$item->name}}</h5>
                                    <p class="price">
                                        <img src="{{ asset('images/Precio_Icono.png') }}" alt="Rango" class="img-d img-fluid">
                                        Desde: <span>${{number_format($item->escalas[0]->price, 0, 0, '.')}}</span>
                                    </p>
                                    <!--<p class="card-text delivery_time delivery-lis-product"><i class="bi bi-truck"></i> Recibelo en {{$item->delivery_time}}</p>-->
                                    <p class="quantity">
                                        <img src="{{ asset('images/Cantidad_Icono.png') }}" alt="Pedido minímo" class="img-d img-fluid">
                                        Pedido minímo: <span>{{$cantidadminima }}</span>
                                    </p>

                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>

            <!--Fin Estructura mobile-->
          @endforeach
            </div>

          </div>
          {{ $products->links() }}
</div>

@push('scripts')

<script>
var boton = $('ul.pagination li:last button');
//$(boton).text('Siguiente');
$(boton).addClass('next-pagination');

var boton0 = $('ul.pagination li:last span');
//$(boton0).text('Anterior');
$(boton0).addClass('next-pagination');



var boton1 = $('ul.pagination li:first span');
//$(boton1).text('Anterior');
$(boton1).addClass('previus-pagination');

var boton2 = $('ul.pagination li:first button');
//$(boton2).text('Anterior');
$(boton2).addClass('previus-pagination');

        const elToggle  = document.querySelector("#toggle");
        const elContent = document.querySelector("#content");

        if (elToggle && elContent) {
            elToggle.addEventListener("click", function() {
                elContent.classList.toggle("is-hidden");
            });
        }

        $(document).on('click', '.page-item', function (e) {
  $("html, body").animate({ scrollTop: 0 }, "fast");
  return false;
});
    </script>


@endpush


