@extends('layouts.admin')
@section('title', 'Inicio')
@section('content')
<section class="multiple-column-form">
    @if ( Auth::user()->hasRole('Administrador'))
      
  <div class="row match-height">
    <div class="col-md-3 col-xl-3">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <h5>Solicitud de creación de productos.</h5>
          <h3 class="mb-75 mt-2 pt-50"><a href="#" target="_self" class="">{{ App\Models\Products::where('state',2)->count() }} Solicitudes</a></h3>
          <a href="/solicitudes-crear-productos" class="btn btn-primary"> Ver </a>        
        </div>
      </div>
    </div>
    <div class="col-md-3 col-xl-3">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <h5>Solicitud de eliminación de productos.</h5>
          <h3 class="mb-75 mt-2 pt-50"><a href="#" target="_self" class="">{{ App\Models\Products::where('state',0)->count() }} Solicitudes</a></h3>
          <a href="/solicitudes-eliminar-productos" class="btn btn-primary"> Ver </a>        
        </div>
      </div>
    </div>
    <div class="col-md-3 col-xl-3">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <h5>Usuarios registrados.</h5>
          <h3 class="mb-75 mt-2 pt-50"><a href="#" target="_self" class="">{{ App\Models\User::count() }} Usuarios</a></h3>
          <a href="/user" class="btn btn-primary"> Ver </a>        
        </div>
      </div>
    </div>
    
    <div class="col-md-3 col-xl-3">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <h5>Clientes registrados</h5>
          <h3 class="mb-75 mt-2 pt-50"><a href="#" target="_self" class="">{{ App\Models\Customers::count() }} Clientes</a></h3>
          <a href="/customers" class="btn btn-primary"> Ver </a>        
        </div>
      </div>
    </div>
   
  </div>





@elseif(Auth::user()->hasRole('Comercio'))
<h2 class="title-comercios"><img src="{{ asset('images/comercio.png') }}"  style="margin-right: 20px;width: 90px;" />Hola, {{ Auth::user()->name}}  Te damos la bienvenida a Kanbai</h2>
<div class="row mt-5">
    <div class="col-sm-7 p-20">
      <div class="card b-radio-30">
        <div class="card-header">
          <h4 class="title-resume">Resumen</h4>
        </div>
        <div class="card-body mt-2">
          <div class="row">
            <div class="col-6 text-center mb-2">
              <label class="resume-v-products">
                <i class="fa fa-usd" aria-hidden="true"></i>  {{number_format($totalSum, 0, 0, '.')}}
              </label><br>
              <span class="resume-v-label">Vendidos</span>
            </div>
             <div class="col-3 text-center mb-2">
              <label class="resume-p-products">
                <i class="fa fa-list" aria-hidden="true"></i> {{$projects}}
              </label><br>
              <span class="resume-p-label">Proyectos</span>
            </div>
            <div class="col-3 text-center mb-2">
              <label class="resume-products">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i> {{$products}}
              </label><br>
              <span class="resume-label">Productos</span>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-5 p-20">
       <div class="card b-radio-30">
        <div class="card-header">
          <h4 class="title-resume">Contacta a soporte</h4>
        </div>
        <div class="card-body mt-2 ">
          <a href="https://wa.me/573502045177" class="btn btn-what mb-2">WhatsApp <i class="fa fa-whatsapp" aria-hidden="true"></i></a>
          <a href="mailto:ventas@kanbai.co" class="btn btn-email mb-2">Correo <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
</div>  
@endif



</section>
@endsection

