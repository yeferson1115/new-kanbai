<div class="row mt-2 content-menu-profile">
    <div class="d-flex align-items-start">
        <ul class="menu-profile-mobile">
            <li>
                <div class="row">
                    <div class="col-4 icon-profile">
                        <label class="content-icon-profile">{{ substr(Auth::user()->business->company_name, 0, 1) }}</label>
                    </div>
                    <div class="col-8">
                        <h4 class="mb-0 mt-2"><span class="hola">Hola,</span> <p class="name-bussine">{{ Auth::user()->business->company_name }}</p> </h4>
                    </div>                
                </div>
                <hr>
            </li>
            <li class="indicator-menu-cont">
                @php
                    $users = App\Models\User::with('roles', 'permissions', 'business')
                                            ->where('business_id', auth()->user()->business_id)
                                            ->get();
                    $projects = App\Models\Projects::with(['timeline', 'productos', 'comercio', 'updates'])
            ->where('bussine_id', auth()->user()->business->id)
            ->get()
            ->map(function ($project) {
                $total = $project->productos->sum(function ($product) {
                    return $product->price * $product->quantity;
                });

                $project->total = $total;
                return $project;
            });
                @endphp
                <div class="row indicator-menu">
                    <div class="col-4">
                        <div class="row"  onclick="location.href='{{ URL::to('/') }}/pedidos-empresa'">                    
                        <div class="col-12" style="text-align: center;cursor: pointer;">
                            <label class="icon-indicator-user icon-indicator-user-blue" >
                               <i class="fa-solid fa-list-check"></i> <span style="color: #636363;">Total pedidos: {{count($projects)}}</span>
                            </label>
                        </div>
                        <div class="col-12 mt-2">                            
                            <label class="label-indicator-info">Pedidos</label>
                        </div>
                    </div>
                    </div>
                    <div class="col-4">
                        <div class="row"  onclick="location.href='{{ URL::to('/') }}/usuarios-empresa'">
                        <div class="col-12" style="text-align: center;cursor: pointer;">
                            <label class="icon-indicator-user icon-indicator-user-aguamarina">
                                <i class="fa-solid fa-user"></i> <span>{{count($users)}}</span>
                            </label>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="label-indicator"></label>
                            <label class="label-indicator-info">Usuarios</label>
                        </div>
                    </div>
                    </div>
                    <div class="col-4">
                        <div class="row" onclick="location.href='{{ route('payment-methods.index') }}'">
                            <div class="col-12" style="text-align: center;cursor: pointer;">
                                <label class="icon-indicator-user icon-indicator-user-blue">
                                    <i class="fa-regular fa-credit-card"></i>
                                </label>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="label-indicator-info">Pagos</label>
                            </div>
                        </div>
                    </div>
                </div>

            </li>
            <li>                
                <a href="/mi-perfil" class="link-menu-user">
                    <i class="fa-solid fa-house menu-p-mobil"></i> Inicio 
                    <i class="fa fa-chevron-right float-right mt-menu-user" aria-hidden="true"></i>
                </a>
                
            </li>
            <!--<li>                
                <a class="link-menu-user" href="/mi-informacion">
                    <i class="bi bi-person menu-p-mobil"></i> Mi información
                    <i class="fa fa-chevron-right float-right mt-2" aria-hidden="true"></i>
                </a>                
            </li>--> 
            <li>                
                <a class="link-menu-user" href="/usuarios-empresa">
                    <i class="fa-regular fa-user menu-p-mobil"></i> usuarios
                    <i class="fa fa-chevron-right float-right mt-menu-user" aria-hidden="true"></i>
                    
                </a>                
            </li>  
            <li>                
                <a class="link-menu-user" href="/pedidos-empresa">
                    <i class="fa-solid fa-list menu-p-mobil"></i> Pedidos
                    <i class="fa fa-chevron-right float-right mt-menu-user" aria-hidden="true"></i>
                </a>                
            </li>
            <li>                
                <a class="link-menu-user" href="{{ route('payment-methods.index') }}">
                    <i class="fa-regular fa-credit-card menu-p-mobil"></i> Métodos de pago
                    <i class="fa fa-chevron-right float-right mt-menu-user" aria-hidden="true"></i>
                </a>                
            </li>
            <li>
                <button  onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link menu-user logout-user link-menu-user" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                    <i class="bi bi-box-arrow-right menu-p-mobil"></i> Cerrar Sesión 
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </button>
            </li>                 
        <ul>
    </div>
</div>
