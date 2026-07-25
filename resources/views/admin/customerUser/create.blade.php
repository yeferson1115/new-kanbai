@extends('layouts.admin')

@section('title', 'Asesores')
@section('page_title', 'Crear Asesor')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Crear Asesor</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/asignar-asesor">Asesores&nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Crear Asesor</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Crear Asesor</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('user') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombres</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombres">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="lastname">Apellidos</label>
                                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellidos">
                                        <span class="missing_alert text-danger" id="lastname_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Género</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="genero" id="inlineRadio1" value="M" checked="">
                                                <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="genero" id="inlineRadio2" value="F">
                                                <label class="form-check-label" for="inlineRadio2">Femenino</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="whatsapp">Whatsapp</label>
                                        <input type="text" id="whatsapp" name="whatsapp" class="form-control" placeholder="3111111111">
                                        <span class="missing_alert text-danger" id="whatsapp_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="cellphone">Celular</label>
                                        <input type="text" id="cellphone" name="cellphone" class="form-control" placeholder="3111111111">
                                        <span class="missing_alert text-danger" id="cellphone_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="description">Breve Presentación</label>
                                        <textarea id="description" name="description" class="form-control"></textarea>
                                        <span class="missing_alert text-danger" id="description_alert"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico">
                                        <span class="missing_alert text-danger" id="email_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="username">Nombre de Usuario</label>
                                        <input type="text"id="username" name="username" class="form-control"  placeholder="Usuario">
                                        <span class="missing_alert text-danger" id="username_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Tipo de usuario</label>
                                        <div class="demo-inline-spacing">                                           
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="role" id="role5" value="5" checked>
                                                <label class="form-check-label" for="role5">Asesor</label>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email-id-column">Contraseña</label>
                                        <input type="password"  class="form-control" id="password" name="password" placeholder="Contraseña">
                                        <span class="missing_alert text-danger" id="password_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email-id-column">Confirmar Contraseña</label>
                                        <input type="password"  class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Contraseña">
                                        <span class="missing_alert text-danger" id="password_confirmation_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Acceso al sistema</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                                <label class="form-check-label" for="status1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status2" value="0">
                                                <label class="form-check-label" for="status2">Deshabilitado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')

    <script src="{{ asset('js/admin/customeruser/create.js') }}"></script>
    
@endpush
