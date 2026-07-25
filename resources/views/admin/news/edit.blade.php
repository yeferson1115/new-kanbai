@extends('layouts.admin')

@section('title', 'Categorías')
@section('page_title', 'Editar Categoría')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: {{ $new->name }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/categories">Categorías &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: {{ $new->name }}</li>
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
                        <h4 class="card-title">Editar Categoría</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <!--<input type="hidden" id="_url" value="{{ url('categories',[$new->encode_id]) }}">-->
                            <input type="hidden" id="_url" value="{{ route('updatenew') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $new->encode_id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="title">Titulo</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Titulo" value="{{ $new->title }}">
                                        <span class="missing_alert text-danger" id="title_alert"></span>
                                    </div>
                                </div>

                                 <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="description">Descripción</label>
                                        <textarea class="form-control" id="description" name="description" >{{ $new->description }}</textarea>
                                        <span class="missing_alert text-danger" id="description_alert"></span>
                                    </div>
                                </div>                             

                                
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="file">Foto</label>
                                        <input type="file" class="form-control" id="file" name="file" >
                                        <img style="max-height: 70px;" src="{{ asset('images/news/'.$new->image.'') }}" alt="Imagen">
                                        <span class="missing_alert text-danger" id="file_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="link">Link</label>
                                        <input type="link" class="form-control" id="link" name="link" placeholder="LINK" value="{{ $new->link }}">
                                        <span class="missing_alert text-danger" id="link_alert"></span>
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

    <script src="{{ asset('js/admin/news/edit.js') }}"></script>
    
@endpush
