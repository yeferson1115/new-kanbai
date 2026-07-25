@extends('layouts.appregister')
@section('title', 'Registro')

@section('content')

<section class="section-agents section-t8 mt-5">
    <div class="container mt-5">
        <div class="row mt-5 ">
            <div class="col-md-5 conten-form">

            <div class="card-body ">

                <form method="POST" id="multiStepForm" action="{{ route('register') }}">
                @csrf
                <!-- Step 1 -->
                    <div id="step1">
                        <h2 class="mb-5 title-register">Crea una cuenta</h2>
                        <div class="mb-3">
                            <label class="form-label">Razón social *</label>
                            <input type="text" class="form-control input-cotizacion" name="company_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Documento de identificación (NIT) *</label>
                            <input type="text" class="form-control input-cotizacion" name="nit" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo de facturación *</label>
                            <input type="text" class="form-control input-cotizacion" name="billing_email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección *</label>
                            <input type="text" class="form-control input-cotizacion" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección *</label>
                            <select name="department_id" id="department_id" class="form-control input-cotizacion" required>
                                <option value="">Seleccione un departamento</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="city_id">Ciudad</label>
                            <select  id="city_id" name="city_id" class="form-control input-cotizacion" required>
                                <option value="">Seleccione</option>
                            </select>
                            <span class="missing_alert text-danger" id="city_id_alert"></span>
                        </div>
                        <button type="button" id="nextBtn" class="btn btn-primary btn-go-quotation color-purple waves-effect waves-float waves-light">Continuar</button>
                    </div>

                    <!-- Step 2 -->
                    <div id="step2" class="d-none">
                        <h2 class="mb-5 title-register">Agregar usuarios</h2>
                        <div id="information-container">
                            <div class="information">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tu nombre completo</label>                            
                                    <input id="name" type="text" class="form-control input-cotizacion @error('name.*') is-invalid @enderror" name="name[]" value="{{ old('name.*') }}" required autocomplete="name" autofocus>
                                    @error('name.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>
                                <div class="mb-3">
                                    <label for="document" class="form-label">Documento de identificación (CC) *</label>                            
                                    <input id="document" type="text" class="form-control input-cotizacion @error('document.*') is-invalid @enderror" name="document[]" value="{{ old('document.*') }}" required autocomplete="document" autofocus>
                                    @error('document.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>
                                <div class="mb-3">
                                    <label for="charge" class="form-label">Cargo *</label>                            
                                    <input id="charge" type="text" class="form-control input-cotizacion @error('charge.*') is-invalid @enderror" name="charge[]" value="{{ old('charge.*') }}" required autocomplete="charge" autofocus>
                                    @error('charge.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>
                                <div class="mb-3">
                                    <label for="phone"  class="form-label label-display-block">Celular</label>                            
                                    <input  type="text" id="phone" class="form-control input-cotizacion @error('phone.*') is-invalid @enderror" name="phone[]" value="{{ old('phone.*') }}" required autocomplete="phone" autofocus>
                                    @error('phone.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control input-cotizacion @error('email.*') is-invalid @enderror" name="email[]" value="{{ old('email.*') }}" required autocomplete="email">
                                    @error('email.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}  <a  class="btn btn-link text-gray btn-link-register" href="/home">¿Ya tienes una cuenta? <strong>Ingresa</strong></a></strong>
                                        </span>
                                        <script>
                                                $( document ).ready(function() {
                                                    _alertLogin('info','Informacón', {{ $message }}, '/login')
                                                });
                                        </script>
                                    @enderror                            
                                </div>
                                <div class="input-group mb-3"> 
                                    <label for="password" class="form-label" style="display: block;width: 100%;">Contraseña *</label>                              
                                    <input class="form-control password input-login @error('password.*') is-invalid @enderror" id="password"  type="password" name="password[]" />
                                    <span class="input-group-text togglePassword eye-login" id="">
                                        <i class="fa fa-eye" aria-hidden="true" style="cursor: pointer"></i>
                                    </span>
                                    @error('password.*')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                            
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="password-confirm" class="form-label" style="display: block;width: 100%;">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control password-confirm input-login  @error('password_confirmation.*') is-invalid @enderror"  name="password_confirmation[]" required autocomplete="new-password"> 
                                        <span class="input-group-text togglePassword-confirm eye-login" id="">
                                            <i class="fa fa-eye" aria-hidden="true" style="cursor: pointer"></i>
                                        </span>   
                                        @error('password_confirmation.*')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror                        
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <button type="button" id="agregar" class="btn btn-green waves-effect waves-float waves-light"><i class="fa fa-plus" aria-hidden="true"></i> Agregar otro usuario</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-go-quotation color-purple waves-effect waves-float waves-light">Finalizar</button>
                                </div>
                            </div>
                            <button type="button" id="prevBtn" class="btn btn-secondary">Atrás</button>
                            
                        </div>
                    </form>
                </div>


            </div>
            <div class="col-md-7 image-register-desk info-register">
                <h2 class="title-info-register">Te damos la bienvenida al futuro de las compras empresariales</h2>
                <p>Con tu cuenta Kanbai ahora tendrás acceso a un universo de facilidades.</p>
                <ul class="ul-info mt-5 mb-5">
                    <li>Encuentra una gran variedad de productos a los mejores pecios del mercado, tenemos un Portafolio completo de categorías</li>
                    <li>Accede a facilidades de pago y financiamiento en compras</li>
                    <li>Gestiona tus compras y proyectos de forma fácil con nuestras herramientas y asesores dedicados</li>
                </ul>
                <h4 class="title-info-register mb-4">Empresas líderes de todos los sectores eligen a Kanbai para realizar sus compras</h4>
                <ul class="icons-business mt-5">
                    <li>
                        <img src="{{ asset('images/empresas/libertyseguros.png') }}" alt="Liberty Seguros" class="img-register">
                    </li>
                    <li>
                        <img src="{{ asset('images/empresas/laika.png') }}"  style="height: 90px;" alt="Laika" class="img-register">
                    </li>
                    <li>
                        <img src="{{ asset('images/empresas/sophos.png') }}" alt="Sophos" class="img-register">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')


<script>

$('#department_id').on('change', function(e){
        var department = e.target.value;
        $.get('/cities/' + department,function(data) {
        $('#city_id').empty();
        $.each(data, function(fetch, city){
            $('#city_id').append('<option value="">Seleccione</option>');
            for(i = 0; i < city.length; i++){
            $('#city_id').append('<option value="'+ city[i].id +'">'+ city[i].name +'</option>');
            }
        })
     })
    });
   document.addEventListener("DOMContentLoaded", function () {
            let step = 1;
            const step1 = document.getElementById("step1");
            const step2 = document.getElementById("step2");
            const nextBtn = document.getElementById("nextBtn");
            const prevBtn = document.getElementById("prevBtn");
            const submitBtn = document.getElementById("submitBtn");
            const agregarBtn = document.getElementById("agregar");
            const informationContainer = document.getElementById("information-container");
            const form = document.getElementById("multiStepForm"); 



            function validateStep1() {
                let valid = true;
                document.querySelectorAll("#step1 input").forEach(input => {
                    if (!input.value) {
                        input.classList.add("is-invalid");
                        valid = false;
                    } else {
                        input.classList.remove("is-invalid");
                    }
                });
                document.querySelectorAll("#step1 select").forEach(select => {
                    if (!select.value) {
                        select.classList.add("is-invalid");
                        valid = false;
                    } else {
                        select.classList.remove("is-invalid");
                    }
                });
                return valid;
            }

            function validateStep2() {
                let valid = true;
                document.querySelectorAll("#step2 input").forEach(input => {
                    if (!input.value) {
                        input.classList.add("is-invalid");
                        valid = false;
                    } else {
                        input.classList.remove("is-invalid");
                    }
                });
                return valid;
            }
            
            nextBtn.addEventListener("click", function () {
                if (validateStep1()) {
                    step1.classList.add("d-none");
                    step2.classList.remove("d-none");
                }
            });

            prevBtn.addEventListener("click", function () {
                step2.classList.add("d-none");
                step1.classList.remove("d-none");
            });

            submitBtn.addEventListener("click", function (e) {
                e.preventDefault(); // Prevent form submission

                if (validateStep2()) {
                    // Collect form data
                    let formData = new FormData(form);

                    // Use AJAX to submit the form
                    $.ajax({
                        url: '/register-ajax',  // Your AJAX registration route
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                alert(response.message);  // Show success message
                                window.location.href = response.redirect_url;  // Redirect after successful registration
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                                // Handle validation errors
                                var errors = xhr.responseJSON.errors;
                                for (var field in errors) {
                                    if (errors.hasOwnProperty(field)) {
                                        $("#" + field).addClass("is-invalid");
                                        $("#" + field).next(".invalid-feedback").text(errors[field][0]);
                                    }
                                }
                            } else {
                                alert("There was an error with the registration.");
                            }
                        }
                    });
                }
            });

            agregarBtn.addEventListener("click", function () {
                

                var container = $('#information-container'); // Contenedor que tiene los campos del usuario
                var original = container.find('.information:first'); // Primer div de información

                var clone = original.clone();
                container.append(clone);
                clone.find('input').val(''); // Limpiar los campos en el nuevo clon

            });
        });



   var input = document.querySelector("#phone");
    window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function(callback) {
        $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "co";
        callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
    });

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

  $(".togglePassword-confirm").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".password-confirm").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".password-confirm").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".password-confirm").attr("type","password");
      }
  });
    </script>


@endpush
