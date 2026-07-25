@extends('layouts.appuser')
@section('title', 'Mi perfil')
@section('content')

@section('content')

<section class="row">
    <div class="col-md-12" style="padding: 0px 30px;">
        <a href="javascript:history.back()" class="previos-profile">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
        @include('site.business.forms.createuser')
    </div>
</section>
@endsection


