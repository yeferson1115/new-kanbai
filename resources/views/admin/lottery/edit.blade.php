@extends('layouts.admin')

@section('title', 'Sorteo')
@section('page_title', 'Editar Inscripción')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: {{ $lottery->name }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/sorteo">Sorteo &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: {{ $lottery->name }}</li>
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
                        <h4 class="card-title">Gestionar Inscripción</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <!--<input type="hidden" id="_url" value="{{ url('categories',[$lottery->encode_id]) }}">-->
                            <input type="hidden" id="_url" value="{{ route('updatesorteo') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $lottery->encode_id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombres" value="{{ $lottery->name }}" readonly>
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email"  value="{{ $lottery->email }}" readonly>
                                        <span class="missing_alert text-danger" id="email_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="document">Documento</label>
                                        <input type="text" class="form-control" id="document" name="document"  value="{{ $lottery->document }}" readonly>
                                        <span class="missing_alert text-danger" id="document_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone">Teléfono</label>
                                        <input type="text" class="form-control" id="phone" name="phone"  value="{{ $lottery->phone }}" readonly>
                                        <span class="missing_alert text-danger" id="phone_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="organization">Organización</label>
                                        <input type="text" class="form-control" id="organization" name="organization" value="{{ $lottery->organization }}" readonly>
                                        <span class="missing_alert text-danger" id="organization_alert"></span>
                                    </div>
                                </div>
                               
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="file">Imagen</label>
                                        <img style="display: block; width: 100%;" src="{{ asset('images/lottery/'.$lottery->file.'') }}" alt="Imagen">
                                        <span class="missing_alert text-danger" id="file_alert"></span>
                                    </div>
                                </div>

                                
                               
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status1" value="1" {{ ($lottery->state=="1")? "checked" : "" }} >
                                                <label class="form-check-label" for="status1">Valido</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status2" value="0" {{ ($lottery->state=="0")? "checked" : "" }} >
                                                <label class="form-check-label" for="status2">Descalificado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Actualizar</button>
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

    <script src="{{ asset('js/admin/lottery/edit.js') }}"></script>
  
@endpush
