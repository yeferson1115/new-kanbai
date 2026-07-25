@extends('layouts.app')
@section('title', 'Rastreo de proyecto')
@section('content')

<section class="section-agents section-t8 mt-5">
    <div class="container mt-5">
        <div class="row mt-5 ">
            <div class="col-md-5 conten-form">
                <div class="">               
                    
                    <div class="card-body ">
                        <h2 class="mb-5 title-login">Rastrea tu proyecto</h2>
                        <form id="main-form" class="mt-5" autocomplete="off" action="javascript:void(0)">
                            <input type="hidden" id="_url" value="{{route('rastreo.validar')}}">
                            <input type="hidden" id="_redirect" value="{{ url('/home') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">

                            <div class="mb-3 mt-5">
                                <label for="email_customer" class="form-label">Correo electrónico *</label>
                                <input type="text" id="email_customer" name="email_customer" value="{{ old('email_customer') }}" class="form-control input-cotizacion" autofocus >
                                <span class="invalid-feedback" id="email_customer_alert" role="alert" style="font-size: 100%;"></span>               
                            </div>

                            <div class=" mb-4">
                                <label for="no_project" class="form-label" style="display: block;width: 100%;">Número de la orden *</label>
                               
                                <input class="form-control no_project input-login input-cotizacion" id="no_project"  type="text" name="no_project" />
                                <!--<span class="input-group-text toggleno_project eye-login" id="">
                                    <i class="fa fa-eye" aria-hidden="true" style="cursor: pointer"></i>
                                </span>-->
                                <span class="invalid-feedback" id="no_project_alert" role="alert" style="font-size: 100%;"></span>

                            </div>

                            <div class="form-group row mb-0 mt-3">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-go-quotation color-purple" id="boton">
                                        Ingresar
                                    </button>
                                </div>
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 image-register-desk">
                <img src="{{ asset('images/registro.png') }}" alt="registro" class="img-register">
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')
    <script src="{{ asset('js/app/rastrearproyecto/login.js') }}"></script>
  
@endpush

