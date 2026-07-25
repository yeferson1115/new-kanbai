<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 col-logo">
                    <a class="navbar-brand text-brand c-two logo-desck" href="/">
                        <img class="logo" src="{{ asset('images/logo/logo-kanbai-color.png').'?'.rand() }}" />
                        <!--Marce<span class="color-b">Pets</span>-->
                    </a>
                    <a class="nav-link account push" href="/home"><i class="bi bi-person"></i></a>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menu_mov" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <div class="col-md-7">                   

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu-register">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="/">Volver al inicio</a>
                            </li>                            
                            <li class="nav-item separador-menu-register">
                                <a class="nav-link" style="margin-left: 20px;" href="#">Sobre nosotros</a>
                            </li>
                        </ul>
                    
                    </div>

                </div>
                <div class="col-md-3">
                    @if(Route::is('register'))
                    <a class="account-desck-register" href="/home">Ingresa</a>
                    @endif
                    
                    @if(Route::is('login'))
                    <a class="account-desck-register" href="/register">Registrarse</a>
                    @endif
                </div>
            </div>
           
        </div>
    </div>
</div>    

