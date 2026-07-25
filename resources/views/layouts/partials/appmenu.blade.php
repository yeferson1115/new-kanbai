<div class="container relative-container">
    <div class="row align-items-center">
        
        <!-- Carga global de categorías (Evita problema N+1 y consultas duplicadas en Blade) -->
        @php
            $categories = \App\Models\Categories::with('subcategories')
                ->where('is_menu', 1)
                ->get();
            $isLogged = auth()->check();
        @endphp

        <!-- Header / Logo Principal -->
        <div class="col-12 col-md-2 d-flex align-items-center justify-content-between header-mobile-wrapper">
            
            <!-- Grupo Izquierdo: Hamburguesa + Logo -->
            <div class="d-flex align-items-center gap-2">
                <button class="navbar-toggler collapsed menupp" type="button" data-bs-toggle="collapse" data-bs-target="#menu_mov" aria-controls="menu_mov" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <a class="navbar-brand text-brand c-two logo-desck m-0" href="/">
                    <img class="logo" src="{{ asset('images/logo/logo.png') }}" alt="Logo Principal" />                 
                </a>
            </div>

            <!-- Grupo Derecho (Solo Mobile): Íconos -->
            <ul class="icons-menu cont-icons-menu-mobile d-md-none m-0">
                <li><button class="btn-icon-search search-trigger" aria-label="Abrir Buscador"><i class="fa-brands fa-sistrix"></i></button></li>
                <li><a href="/login" class="text-inherit"><i class="fa-regular fa-user"></i></a></li>
                <li><a href="/carrito" class="text-inherit"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>

        </div>

        <!-- Menú de Navegación Desktop -->
        <div class="col-12 col-md-8">
            <div class="navbar-collapse collapse" id="navbarDefault">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Inicio</a>
                    </li>

                    @foreach ($categories as $category)
                        @if ($isLogged || $category->name !== 'EasyGift')                                
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('catalogo/' . $category->slug) ? 'active' : '' }} {{ $category->name === 'EasyGift' ? 'easy-gift-link' : '' }}" href="/catalogo/{{ $category->slug }}">
                                    {{ $category->name }} 
                                    @if($category->name === 'EasyGift') 
                                        <i class="fa-solid fa-bolt"></i> 
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Menú Colapsable Mobile -->
            <div class="mobile_menu navbar-collapse collapse" id="menu_mov">
                <ul class="navbar-nav">
                    <span class="title_menu">Menú</span>
                    
                    <li class="nav-item">
                       <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="/">
                        <div class="logo-menu-mobil">
                            <img class="imagen-menu-producto" src="{{ asset('images/categories/1665624762.png') }}" alt="Inicio">
                        </div>
                        Inicio</a>
                    </li>

                    @foreach ($categories as $category)
                        @if ($isLogged || $category->name !== 'EasyGift')
                            @if ($category->subcategories && $category->subcategories->count() > 0)
                                <li>                        
                                    <label class="a-label__chevron item-sub" for="item-{{ $category->id }}">
                                        <div class="logo-menu-mobil">
                                            <img class="imagen-menu-producto responsive" 
                                                src="{{ asset('images/categories/'.$category->file) }}" 
                                                alt="{{ $category->name }}">
                                        </div>
                                        {{ $category->name }} <i class="fa-solid fa-bolt"></i>
                                    </label>

                                    <input type="checkbox" id="item-{{ $category->id }}" name="item-{{ $category->id }}" class="m-menu__checkbox">

                                    <div class="m-menu">
                                        <div class="m-menu__header">
                                            <label class="m-menu__toggle" for="item-{{ $category->id }}">
                                                <svg width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="butt" stroke-linejoin="arcs">
                                                    <path d="M19 12H6M12 5l-7 7 7 7"/>
                                                </svg>
                                            </label>
                                            <span>{{ $category->name }}</span>
                                        </div>

                                        <ul class="mobile-subcategories-list">
                                            @foreach ($category->subcategories as $subcategory)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->is('catalogo/' . $subcategory->slug) ? 'active' : '' }}" 
                                                    href="/catalogo/{{ $category->name }}/{{ $subcategory->slug }}">
                                                        <div class="logo-menu-mobil">
                                                            <img class="imagen-menu-producto responsive" 
                                                                src="{{ asset('images/subcategories/'.$subcategory->file) }}" 
                                                                alt="{{ $subcategory->name }}">
                                                        </div>
                                                        {{ $subcategory->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>  
                                    </div>                 
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('catalogo/' . $category->slug) ? 'active' : '' }}" href="/catalogo/{{ $category->slug }}">
                                        <div class="logo-menu-mobil">
                                            <img class="imagen-menu-producto responsive" src="{{ asset('images/categories/'.$category->file) }}" alt="{{ $category->name }}">
                                        </div>
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Íconos Desktop -->
        <div class="col-md-2 cont-icons-menu d-none d-md-block">
            <ul class="icons-menu justify-content-end">
                <li><button class="btn-icon-search search-trigger" aria-label="Abrir Buscador"><i class="fa-brands fa-sistrix"></i></button></li>
                <li><a href="/login" class="text-inherit"><i class="fa-regular fa-user"></i></a></li>
                <li><a href="/carrito" class="text-inherit"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </div>

    <!-- Buscador Flotante Unificado -->
    <div id="search-overlay-container" class="search-overlay d-none">
        <div class="search-box-wrapper">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="search" id="global-search-input" class="form-control border-start-0" placeholder="Buscar productos, categorías..." autocomplete="off">
                <button class="btn btn-outline-secondary border-start-0" type="button" id="close-search-overlay">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <!-- Contenedor dinámico de resultados -->
            <div id="global-search-results" class="search-results-dropdown d-none"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchOverlay = document.getElementById("search-overlay-container");
    const searchInput = document.getElementById("global-search-input");
    const searchResults = document.getElementById("global-search-results");
    const closeBtn = document.getElementById("close-search-overlay");
    const searchTriggers = document.querySelectorAll(".search-trigger");

    let debounceTimer = null;

    // Abrir Buscador
    searchTriggers.forEach(trigger => {
        trigger.addEventListener("click", function(e) {
            e.preventDefault();
            searchOverlay.classList.remove("d-none");
            searchInput.focus();
        });
    });

    // Cerrar Buscador
    function closeSearch() {
        searchOverlay.classList.add("d-none");
        searchResults.classList.add("d-none");
        searchInput.value = "";
        searchResults.innerHTML = "";
    }

    closeBtn.addEventListener("click", closeSearch);

    // Cerrar al presionar la tecla ESC
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && !searchOverlay.classList.contains("d-none")) {
            closeSearch();
        }
    });

    // Búsqueda AJAX optimizada con Debounce
    searchInput.addEventListener("input", function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 3) {
            searchResults.classList.add("d-none");
            searchResults.innerHTML = "";
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('search.ajax') }}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error("Error en la consulta");
                return response.json();
            })
            .then(data => {
                searchResults.innerHTML = "";
                
                if (data.length > 0) {
                    data.forEach(item => {
                        const itemHtml = `
                            <a href="${item.url}" class="search-result-item d-flex align-items-center p-2 text-decoration-none">
                                <img src="${item.image}" alt="${item.name}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">${item.name}</span>
                                    <small class="text-muted">${item.category}</small>
                                </div>
                            </a>`;
                        searchResults.insertAdjacentHTML('beforeend', itemHtml);
                    });
                    searchResults.classList.remove("d-none");
                } else {
                    searchResults.innerHTML = `<div class="p-3 text-center text-muted">No se encontraron resultados para "${query}"</div>`;
                    searchResults.classList.remove("d-none");
                }
            })
            .catch(error => console.error("Error al obtener resultados:", error));
        }, 300); // 300ms delay para evitar peticiones masivas
    });

    // Cerrar si se da click fuera del componente
    document.addEventListener("click", function(e) {
        if (!searchOverlay.contains(e.target) && !e.target.closest('.search-trigger')) {
            closeSearch();
        }
    });
});
</script>
@endpush