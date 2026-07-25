<form class="form" role="form" id="main-form" autocomplete="off">
    <input type="hidden" id="_url" value="{{ url('user',[$user->encode_id]) }}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <div class="row conten-info-user">
        <div class="col-md-6 border-right-user">
            <h4 class="title-infouser mb-5 mt-3">Completa si deseas editar tu información</h4>
            <div class="mb-4">
                <label class="form-label" for="name">Tu Nombre</label>
                <input type="text" class="form-control input-cotizacion @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" autocomplete="name" autofocus placeholder="Nombres">
                @error('name')
                    <span class="invalid-feedback text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="name_business">Nombre de la Empresa</label>
                <input type="text" class="form-control input-cotizacion @error('name_business') is-invalid @enderror" id="name_business" name="name_business" value="{{ $user->name_business }}" autocomplete="name_business" autofocus placeholder="Nombre de tu empresa">
                @error('name_business')
                    <span class="invalid-feedback text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="email">Tu Correo Electrónico</label>
                <input type="email" class="form-control input-cotizacion @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}"  autocomplete="email" autofocus placeholder="Correo Electrónico">
                @error('email')
                    <span class="invalid-feedback text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="phone">Número de Celular</label>
                <input type="text" class="form-control input-cotizacion @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $user->phone }}"  autocomplete="phone" autofocus >
                @error('phone')
                    <span class="invalid-feedback text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


        </div>
        <div class="col-md-6">
            <h4 class="title-infouser mb-5 mt-3">Cambiar contraseña</h4>

            <div class="mb-4">
                <label class="form-label" for="email-id-column">Contraseña actual</label>
                <input type="password"  class="form-control input-cotizacion @error('current_password') is-invalid @enderror" id="current_password" name="current_password_alert" value="{{ old('current_password') }}"  autocomplete="current_password" autofocus placeholder="Contraseña">
                <span class="missing_alert text-danger" id="current_password_alert"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="email-id-column">Nueva Contraseña</label>
                <input type="password"  class="form-control input-cotizacion @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}"  autocomplete="password" autofocus placeholder="Contraseña">
                @error('password')
                    <span class="invalid-feedback text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="form-label" for="email-id-column">Confirmar Nueva Contraseña</label>
                <input type="password"  class="form-control input-cotizacion @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}"  autocomplete="password_confirmation" placeholder="Contraseña">
                @error('password_confirmation')
                    <span class="invalid-feedback text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="col-12 mt-5">
            <button type="submit" class="btn btn-go-quotation ajax" id="submit"> Guardar Cambios</button>
        </div>                   
    </div>
</form>
       

@push('scripts')   
<script src="{{ asset('js/app/user/edit.js') }}"></script>  
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
