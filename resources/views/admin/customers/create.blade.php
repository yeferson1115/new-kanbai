@extends('layouts.admin')

@section('title', 'Clientes')
@section('page_title', 'Clientes')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nuevo Cliente</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/customers">Clientes &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nuevo cliente</li>
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
                        <h4 class="card-title">Crear cliente</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('customers') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first_name">Nombre</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nombre">
                                        <span class="missing_alert text-danger" id="first_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="last_name">Apellido</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Apellido">
                                        <span class="missing_alert text-danger" id="last_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type">Tipo </label>
                                        <select  id="type" name="type" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="PERSONA_JURIDICA">Persona Juridica</option>
                                            <option value="PERSONA_NATURAL">Persona Natural</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="type_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="identification_type">Tipo de documento</label>
                                        <select  id="identification_type" name="identification_type" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="CC">Cédula</option>
                                            <option value="NIT">Nit</option>
                                            <option value="PASAPORTE">Pasaporte</option>
                                            <option value="RC">RC</option>
                                            <option value="TI">TI</option>
                                            <option value="TE">TE</option>
                                            <option value="CE">CE</option>
                                            <option value="IE">IE</option>
                                            <option value="NIT_OTRO_PAIS">Nit otro país</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="identification_type_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="identification">Identificación</label>
                                        <input type="number" id="identification" name="identification" class="form-control" placeholder="Identificación">
                                        <span class="missing_alert text-danger" id="identification_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="regimen">Regimen</label>
                                        <select  id="regimen" name="regimen" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="SIMPLE">Simple</option>
                                            <option value="ORDINARIO">Ordinario</option>
                                            <option value="GRAN_CONTRIBUYENTE">Grean Contribuyente</option>
                                            <option value="AUTORRETENEDOR">Autorretenedor</option>
                                            <option value="AGENTE_RETENCION_IVA">Agente Retención IVA</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="regimen_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="departament_id">Departamento</label>
                                        <select  id="departament_id" name="departament_id" class="form-control">
                                            <option value="">Seleccione</option>
                                            @foreach( $deptos as $key => $value )
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="missing_alert text-danger" id="departament_id_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city_id">Ciudad</label>
                                        <select  id="city_id" name="city_id" class="form-control">
                                            <option value="">Seleccione</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="city_id_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone">Teléfono</label>
                                        <input type="number" id="phone" name="phone" class="form-control" placeholder="Teléfono">
                                        <span class="missing_alert text-danger" id="phone_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">E-mail</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="E-mail">
                                        <span class="missing_alert text-danger" id="email_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="address_line">Dirección</label>
                                        <input type="text" id="address_line" name="address_line" class="form-control" placeholder="Dirección">
                                        <span class="missing_alert text-danger" id="address_line_alert"></span>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="inlineRadio1" value="1" checked="">
                                                <label class="form-check-label" for="inlineRadio1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="inlineRadio2" value="0">
                                                <label class="form-check-label" for="inlineRadio2">Desactivo</label>
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

    <script src="{{ asset('js/admin/customers/create.js') }}"></script>
@endpush
