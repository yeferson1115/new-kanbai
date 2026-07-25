@extends('layouts.appuser')
@section('title', 'Mis proyectos')
@section('content')

@section('content')

<section class="row">
    <div class="col-md-12" style="padding: 0px 30px;">
        <a href="/mi-perfil" class="previos-profile"><i class="bi bi-arrow-left-circle"></i> Volver </a>
        @include('site.business.forms.projectsmobile',['projects'=>$projects])
    </div>
</section>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/app/user/create.js') }}"></script>
@endpush
