@extends('layouts.appregister')

@section('content')
<section class="section-agents section-t8 mt-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-reset" >
                @if (session('status'))
                    <div class="mb-3" style="text-align: center;"><i class="fa fa-check check-reset" aria-hidden="true"></i></div>
                    <h2 class="title-restart" style="font-size: 16px;text-align: center;">Listo! Tu contraseña se ha restablecido con éxito</h2>
                @else
                <h2 class="title-restart">Restablecer contraseña</h2>
                @endif
                <div class="card-body">
                    @if (session('status'))
                    
                    <p style="text-align: center;">{{ session('status') }}</p>
                    <div class="form-group row mt-5">
                            <div class="col-md-6 offset-md-4">
                                <a href="/login" class="btn btn-primary btn-reset">
                                    Ingresar
                                </a>
                            </div>
                    </div>

                    @else

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="col-form-label text-md-right">Escribe el correo electrónico de tu cuenta *</label>

                            <div class="col-md-12 mb-5">
                                <input id="email" type="email" style="border-radius: 30px;" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-reset">
                                    Recuperar Contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
