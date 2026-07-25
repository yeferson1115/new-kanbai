@extends('layouts.appregister')
@section('title', 'Login')


@section('content')

<section class="section-agents section-t8 mt-5">
    <div class="container mt-5">
        <div class="row mt-5 ">
            <div class="col-md-5 conten-form">
                <div class="">               
                    
                    <div class="card-body ">
                        <h2 class="mb-5 title-login">Iniciar sesión</h2>
                        <form id="main-form" class="mt-5" autocomplete="off" action="javascript:void(0)">
                            <input type="hidden" id="_url" value="{{ url('login') }}">
                            <input type="hidden" id="_redirect" value="{{ url('/home') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">

                            <div class="mb-3 mt-5">
                                <label for="email" class="form-label">Correo electrónico *</label>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control input-cotizacion" autofocus >
                                <span class="invalid-feedback" id="username_alert" role="alert" style="font-size: 100%;"></span>               
                            </div>

                            <div class=" mb-4">
                                <label for="password" class="form-label" style="display: block;width: 100%;">Contraseña *</label>
                               
                                <input class="form-control password input-login input-cotizacion" id="password"  type="password" name="password" />
                                <!--<span class="input-group-text togglePassword eye-login" id="">
                                    <i class="fa fa-eye" aria-hidden="true" style="cursor: pointer"></i>
                                </span>-->
                                <span class="invalid-feedback" id="password_alert" role="alert" style="font-size: 100%;"></span>

                            </div>

                            <div class="form-group row mb-0 mt-3">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-go-quotation color-purple" id="boton">
                                        Ingresar
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-3">
                                    <a  class="btn btn-link text-gray btn-link-register" href="/password/reset">Olvidé mi contraseña</a>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-2 create-account">
                                <div class="col-md-6 offset-md-3">
                                    <a  class="btn btn-link text-gray btn-link-register" href="/register">¿No tienes una cuenta? <strong>Regístrate</strong></a>
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
    <script src="{{ asset('js/admin/auth/login.js') }}"></script>
    <script>
         feather.replace({ 'aria-hidden': 'true' });

$(".togglePassword").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".password").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".password").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".password").attr("type","password");
      }
  });
    </script>
@endpush

