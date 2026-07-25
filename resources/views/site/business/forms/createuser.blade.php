<form class="form" role="form" id="main-form" autocomplete="off">

    <input type="hidden" id="_url" value="{{ url('usuarioempresaadd') }}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <div class="row conten-info-user">
        <div class="col-md-6 border-right-user">
            <h4 class="title-infouser mb-5 mt-3">Completa si deseas editar tu información</h4>
            <div class="mb-4">
                <label class="form-label" for="name">Tu Nombre</label>
                <input type="text" class="form-control input-cotizacion " id="name" name="name" autocomplete="name" autofocus placeholder="Nombres">                
                <span class="missing_alert text-danger" id="name_alert"></span>
            </div>


            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="city-column">Género</label>
                    <div class="demo-inline-spacing">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genero" id="inlineRadio1" value="M" >
                            <label class="form-check-label" for="inlineRadio1">Masculino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genero" id="inlineRadio2" value="F">
                            <label class="form-check-label" for="inlineRadio2">Femenino</label>
                        </div>
                    </div>
                </div>
                <span class="missing_alert text-danger" id="gender_alert"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="email">Tu Correo Electrónico</label>
                <input type="email" class="form-control input-cotizacion " id="email" name="email"  autocomplete="email" autofocus placeholder="Correo Electrónico">
                <span class="missing_alert text-danger" id="email_alert"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="phone">Número de Celular</label>
                <input type="text" class="form-control input-cotizacion " id="phone" name="phone"  autocomplete="phone" autofocus >
                <span class="missing_alert text-danger" id="phone_alert"></span>
            </div>
            <div class="mb-4">
                <label class="form-label" for="charge">Cargo</label>
                <input type="text" class="form-control input-cotizacion " id="charge" name="charge"   autocomplete="charge" autofocus >
                <span class="missing_alert text-danger" id="charge_alert"></span>
            </div>


        </div>
        <div class="col-md-6">
            <h4 class="title-infouser mb-5 mt-3">Contraseña</h4>            

            <div class="mb-4">
                <label class="form-label" for="email-id-column">Contraseña</label>
                <input type="password"  class="form-control input-cotizacion" id="password" name="password"  autocomplete="password" autofocus placeholder="Contraseña">
                <span class="missing_alert text-danger" id="password_alert"></span>
            </div>
            <div class="mb-4">
                <label class="form-label" for="email-id-column">Confirmar Contraseña</label>
                <input type="password"  class="form-control input-cotizacion " id="password_confirmation" name="password_confirmation"  autocomplete="password_confirmation" placeholder="Contraseña">
                <span class="missing_alert text-danger" id="password_confirmation_alert"></span>
            </div>

        </div>
        <div class="col-12 mt-5">
            <button type="submit" class="btn btn-go-quotation ajax" id="submit"> Guardar Cambios</button>
        </div>                   
    </div>
</form>
       

@push('scripts')   
<script src="{{ asset('js/app/user/createuserempresa.js') }}"></script>  
<script>
   
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
 </script>
@endpush
