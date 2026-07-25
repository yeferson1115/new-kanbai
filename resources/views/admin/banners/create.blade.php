@extends('layouts.admin')

@section('title', 'Banners')
@section('page_title', 'Agregar Banners')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nuevo Banner</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/banners">Banners &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nuevo Banner</li>
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
                        <h4 class="card-title">Crear Banner</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('banners') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="url">Url</label>
                                        <input type="text" class="form-control" id="url" name="url" >
                                        <span class="missing_alert text-danger" id="url_alert"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="imagedesk">Banner Desktop</label>
                                        <input type="file" class="form-control" id="imagedesk" name="imagedesk" >
                                        <span class="missing_alert text-danger" id="imagedesk_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="imagemobile">Banner Mobile</label>
                                        <input type="file" class="form-control" id="imagemobile" name="imagemobile" >
                                        <span class="missing_alert text-danger" id="imagemobile_alert"></span>
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

    <script src="{{ asset('js/admin/banners/create.js') }}"></script>
@endpush
