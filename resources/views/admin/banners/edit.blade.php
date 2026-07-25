@extends('layouts.admin')

@section('title', 'Banners')
@section('page_title', 'Editar Banner')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: {{ $banner->id }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/banners">Banners &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: {{ $banner->id }}</li>
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
                        <h4 class="card-title">Editar Banner</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">                           
                            <input type="hidden" id="_url" value="{{ route('updatebanner') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $banner->encode_id }}">
                            <div class="row">
                                
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="imagedesk">Banner Desktop</label>
                                        <input type="file" class="form-control" id="imagedesk" name="imagedesk" >
                                        <img class="mt-2" style="max-height: 70px;" src="{{ asset('images/banners/desktop/'.$banner->imagedesk) }}" alt="Imagen">
                                        <span class="missing_alert text-danger" id="imagedesk_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="url_desk">Url Desktop</label>
                                        <input type="text" class="form-control" id="url_desk" name="url_desk"  value="{{$banner->url_desk}}">
                                        <span class="missing_alert text-danger" id="url_desk_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="imagemobile">Banner Mobile</label>
                                        <input type="file" class="form-control" id="imagemobile" name="imagemobile" >
                                        <img class="mt-2" style="max-height: 70px;" src="{{ asset('images/banners/mobile/'.$banner->imagemobile) }}" alt="Imagen">
                                        <span class="missing_alert text-danger" id="imagemobile_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="url_mobile">Url Mobile</label>
                                        <input type="text" class="form-control" id="url_mobile" name="url_mobile" value="{{$banner->url_mobile}}">
                                        <span class="missing_alert text-danger" id="url_mobile_alert"></span>
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

<script src="{{ asset('js/admin/banners/edit.js') }}"></script>
  
@endpush
