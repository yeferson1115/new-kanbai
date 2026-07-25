

<div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="html/ltr/vertical-menu-template/index.html">
                        <span class="brand-logo">
                            <img src="{{ asset('images/logo/logo-kanbai-color.png') }}" />
                        </span>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/home"><i class="fa fa-home" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Home">Home</span></a>
                </li>
                @can('Administración')
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Menu Levels">Administración</span></a>
                    <ul class="menu-content">
                        @can('Ver Sedes')
                        <!--<li>
                            <a class="d-flex align-items-center" href="/campus"><i data-feather='map-pin'></i><span class="menu-item text-truncate" data-i18n="Second Level">Sedes</span></a>
                        </li>-->
                        @endcan
                        @can('Ver Usuario')
                        <li>
                            <a class="d-flex align-items-center" href="/user"><i data-feather='users'></i><span class="menu-item text-truncate" data-i18n="Second Level">Usuarios</span></a>
                        </li>
                        @endcan

                        @can('Ver Permisos')
                        <li><a class="d-flex align-items-center" href="#"><i data-feather='lock'></i><span class="menu-item text-truncate" data-i18n="Second Level">Permisos</span></a>
                            <ul class="menu-content">
                                <input type="hidden" value="{{$roles = Spatie\Permission\Models\Role::get()}}">
                                @foreach ($roles as $role)
                                <li>
                                    <a class="d-flex align-items-center" href="/permission/{{ $role->name }}"><span class="menu-item text-truncate" data-i18n="Third Level">{{ $role->name }}</span></a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endcan
                        @can('Ver Role')
                        <li>
                            <a class="d-flex align-items-center" href="/roles"><i data-feather='user-check'></i><span class="menu-item text-truncate" data-i18n="Second Level">Roles</span></a>
                        </li>
                        @endcan
                        @can('Ver Logins')
                        <li>
                            <a class="d-flex align-items-center" href="/logins"><i data-feather='log-in'></i><span class="menu-item text-truncate" data-i18n="Second Level">Logs  de Login</span></a>
                        </li>
                        @endcan
                        @can('Ver Log Sistema')
                        <li>
                            <a class="d-flex align-items-center" href="/logs"><i data-feather='database'></i><span class="menu-item text-truncate" data-i18n="Second Level">Logs Sistema</span></a>
                        </li>
                        @endcan
                        @can('Configuracion')
                        <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Ajustes">Ajustes Generales</span></a>
                            <ul class="menu-content">                        
                                @can('Ver Banners')
                                <li class=" nav-item">
                                    <a class="d-flex align-items-center" href="/banners"><i class="fa fa-picture-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Banners Home">Banners Home</span></a>
                                </li>
                                @endcan
                                
                            
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('Tienda')
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Tienda">Tienda</span></a>
                    <ul class="menu-content">                        
                        @can('Ver Categorías')
                        <li class=" nav-item">
                            <a class="d-flex align-items-center" href="/categories"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Categorías">Categorías</span></a>
                        </li>
                        @endcan
                        @can('Ver Sub Categoría')
                        <li class=" nav-item">
                            <a class="d-flex align-items-center" href="/subcategories"><i class="fa fa-folder-open-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Sub-Categorías">Sub-Categorías</span></a>
                        </li>
                        @endcan
                        @can('Ver Productos')
                        <li class=" nav-item">
                            <a class="d-flex align-items-center" href="/products"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Productos">Productos</span></a>
                        </li>
                        @endcan
                       
                    </ul>
                </li>
                @endcan
                @can('Ver Empresas')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/empresas"><i class="fa fa-briefcase" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Empresas">Empresas</span></a>
                </li>
                @endcan

                @can('Ver Ordenes')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/ordenes"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Ordenes">Ordenes</span></a>
                </li>
                @endcan
                @can('Ver Cotizaciones')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/quotes"><i class="fa fa-usd" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Cotizaciones">Cotizaciones</span></a>
                </li>
                @endcan
                @can('Ver Solicitudes Personalizadas')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/solicituded-personalizadas"><i class="fa fa-money" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Solicitudes Personalizadas">Solicitudes Personalizadas</span></a>
                </li>
                @endcan
                @can('Ver Proyectos')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="{{ route('projects.index') }}"><i class="fa fa-check-circle" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Proyectos">Proyectos</span></a>
                </li>
                @endcan
                 @can('Ver Proyectos')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="{{ route('easygift.index') }}"><i class="fa fa-check-circle" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="EasyGift">EasyGift</span></a>
                </li>
                @endcan
                @can('Ver Asignación')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/asignar-asesor"><i class="fa fa-share" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Proyectos">Asesores</span></a>
                </li>
                @endcan
                @can('Ver Participantes')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/sorteo"><i class="fa fa-barcode" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Proyectos">Sorteo</span></a>
                </li>
                @endcan
                @can('Ver Novedades')
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="/novedades"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Novedades">Novedades</span></a>
                </li>
                @endcan
                

            </ul>
        </div>
