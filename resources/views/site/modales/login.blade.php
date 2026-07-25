


        <div class="row mt-5 ">
            <div class="col-md-6 conten-form">
                <div class="">               

                    <div class="card-body ">
                        <form id="main-form-login" autocomplete="off" >
                            <input type="hidden" id="_url_login" value="{{ url('login') }}">
                            <input type="hidden" id="_redirect" value="{{ url('/home') }}">
                            <input type="hidden" id="_token_login" value="{{ csrf_token() }}">

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico o usuario*</label>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control input-cotizacion" autofocus >
                                <span class="invalid-feedback" id="username_alert" role="alert" style="font-size: 100%;"></span>               
                            </div>

                            <div class="input-group mb-4">
                                <label for="password" class="form-label" style="display: block;width: 100%;">Contraseña *</label>
                               
                                <input class="form-control passwordlogin input-login" id="passwordlogin"  type="password" name="password" />
                                <span class="input-group-text verpasswored eye-login" id="">
                                    <i class="fa fa-eye" aria-hidden="true" style="cursor: pointer"></i>
                                </span>
                                <span class="invalid-feedback" id="password_alert" role="alert" style="font-size: 100%;"></span>

                            </div>

                            <div class="form-group row mb-0 mt-3">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-go-quotation color-purple" >
                                        Ingresar
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-3">
                                    <a  class="btn btn-link text-gray btn-link-register" href="#">Olvidé mi contraseña</a>
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
  


@push('scripts')
    <script src="{{ asset('js/admin/auth/loginmodal.js') }}"></script>
    <script>
         feather.replace({ 'aria-hidden': 'true' });

$(".verpasswored").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".passwordlogin").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".passwordlogin").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".passwordlogin").attr("type","passwordlogin");
      }
  });
    </script>
@endpush

