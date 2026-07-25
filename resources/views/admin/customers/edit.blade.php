@extends('layouts.admin')

@section('title', 'Clientes')
@section('page_title', 'Clientes')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: {{ $customer->name }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/customers">Clientes &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: {{ $customer->name }}</li>
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
                        <h4 class="card-title">Editar Cliente</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('customers',[$customer->encode_id]) }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first_name">Nombre</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nombre" value="{{ $customer->first_name }}">
                                        <span class="missing_alert text-danger" id="first_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="last_name">Apellido</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Apellido" value="{{ $customer->last_name }}">
                                        <span class="missing_alert text-danger" id="last_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type">Tipo </label>
                                        <select  id="type" name="type" class="form-control">
                                            <option value="PERSONA_JURIDICA" {{ ($customer->type=='PERSONA_JURIDICA')? "selected" : "" }}>Persona Juridica</option>
                                            <option value="PERSONA_NATURAL" {{ ($customer->type=='PERSONA_NATURAL')? "selected" : "" }}>Persona Natural</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="type_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="identification_type">Tipo de documento</label>
                                        <select  id="identification_type" name="identification_type" class="form-control">
                                            <option value="CC" {{ ($customer->identification_type=='CC')? "selected" : "" }}>Cédula</option>
                                            <option value="NIT" {{ ($customer->identification_type=='NIT')? "selected" : "" }}>Nit</option>
                                            <option value="PASAPORTE" {{ ($customer->identification_type=='PASAPORTE')? "selected" : "" }}>Pasaporte</option>
                                            <option value="RC" {{ ($customer->identification_type=='RC')? "selected" : "" }}>RC</option>
                                            <option value="TI" {{ ($customer->identification_type=='TI')? "selected" : "" }}>TI</option>
                                            <option value="TE" {{ ($customer->identification_type=='TE')? "selected" : "" }}>TE</option>
                                            <option value="CE" {{ ($customer->identification_type=='CE')? "selected" : "" }}>CE</option>
                                            <option value="IE" {{ ($customer->identification_type=='IE')? "selected" : "" }}>IE</option>
                                            <option value="NIT_OTRO_PAIS" {{ ($customer->identification_type=='NIT_OTRO_PAIS')? "selected" : "" }}>Nit otro país</option>
                                        </select>
                                        <span class="missing_alert text-danger" id="identification_type_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="identification">Identificación</label>
                                        <input type="number" id="identification" name="identification" class="form-control" placeholder="Identificación" value="{{ $customer->identification }}">
                                        <span class="missing_alert text-danger" id="identification_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="regimen">Regimen</label>
                                        <select  id="regimen" name="regimen" class="form-control">
                                            <option value="SIMPLE"  {{ ($customer->regimen=='SIMPLE')? "selected" : "" }}>Simple</option>
                                            <option value="ORDINARIO"  {{ ($customer->regimen=='ORDINARIO')? "selected" : "" }}>Ordinario</option>
                                            <option value="GRAN_CONTRIBUYENTE"  {{ ($customer->regimen=='GRAN_CONTRIBUYENTE')? "selected" : "" }}>Grean Contribuyente</option>
                                            <option value="AUTORRETENEDOR"  {{ ($customer->regimen=='AUTORRETENEDOR')? "selected" : "" }}>Autorretenedor</option>
                                            <option value="AGENTE_RETENCION_IVA"  {{ ($customer->regimen=='AGENTE_RETENCION_IVA')? "selected" : "" }}>Agente Retención IVA</option>
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
                                        <input type="number" id="phone" name="phone" class="form-control" placeholder="Teléfono" value="{{ $customer->phone }}">
                                        <span class="missing_alert text-danger" id="phone_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">E-mail</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" value="{{ $customer->email }}">
                                        <span class="missing_alert text-danger" id="email_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="address_line">Dirección</label>
                                        <input type="text" id="address_line" name="address_line" class="form-control" placeholder="Dirección" value="{{ $customer->address_line }}">
                                        <span class="missing_alert text-danger" id="address_line_alert"></span>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="inlineRadio1" value="1" {{ ($customer->state=="1")? "checked" : "" }}>
                                                <label class="form-check-label" for="inlineRadio1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="inlineRadio2" {{ ($customer->state=="0")? "checked" : "" }}>
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

    <script src="{{ asset('js/admin/customers/edit.js') }}"></script>
@endpush
