@extends('layouts.appuser')
@section('title', $isEdit ? 'Actualizar tarjeta' : 'Agregar tarjeta')

@section('content')
<section class="payment-create-page">
    <div class="card payment-create-card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <h2 class="title-section mb-4">{{ $isEdit ? 'Actualiza los datos de tu tarjeta:' : 'Completa los datos de tu tarjeta:' }}</h2>

            <form action="{{ $isEdit ? route('payment-methods.update', $paymentMethod->id) : route('payment-methods.store') }}" method="POST" id="payment-method-form">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Nombre en la tarjeta *</label>
                        <input type="text" name="cardholder_name" class="form-control input-easy" placeholder="Ej: Juan Pérez" value="{{ old('cardholder_name', optional($paymentMethod)->cardholder_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipo de documento *</label>
                        <select name="document_type" class="form-control input-easy" required>
                            <option value="">Selecciona</option>
                            <option value="Cedula de ciudadania" @if(old('document_type', optional($paymentMethod)->document_type)==='Cedula de ciudadania') selected @endif>Cédula de ciudadanía</option>
                            <option value="NIT" @if(old('document_type', optional($paymentMethod)->document_type)==='NIT') selected @endif>NIT</option>
                            <option value="Cedula de extranjeria" @if(old('document_type', optional($paymentMethod)->document_type)==='Cedula de extranjeria') selected @endif>Cédula de extranjería</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Número de tarjeta {{ $isEdit ? '' : '*' }}</label>
                        <div class="position-relative">
                            <input type="text" name="card_number" id="card_number" class="form-control input-easy pe-5" placeholder="{{ $isEdit ? 'Dejar en blanco para conservar la tarjeta actual' : '0000 0000 0000 0000' }}" value="{{ old('card_number') }}" @if(!$isEdit) required @endif>
                            <span class="brand-pill" id="card_brand">{{ old('card_number') ? 'Desconocida' : ($isEdit ? optional($paymentMethod)->brand : 'Desconocida') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Número de documento *</label>
                        <input type="text" name="document_number" class="form-control input-easy" placeholder="Ej:1000000000" value="{{ old('document_number', optional($paymentMethod)->document_number) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Vencimiento *</label>
                        <input type="number" min="1" max="12" name="exp_month" class="form-control input-easy" placeholder="MM" value="{{ old('exp_month', optional($paymentMethod)->exp_month) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Año *</label>
                        <input type="number" min="{{ date('Y') }}" max="{{ date('Y') + 20 }}" name="exp_year" class="form-control input-easy" placeholder="AAAA" value="{{ old('exp_year', optional($paymentMethod)->exp_year) }}" required>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="terms_accepted" name="terms_accepted" required>
                            <label class="form-check-label" for="terms_accepted">
                                Acepto la política de tratamiento de datos personales.
                            </label>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4 text-end">
                    <button class="btn btn-save-card" type="submit">{{ $isEdit ? 'Actualizar tarjeta' : 'Guardar tarjeta' }}</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/app/user/payment-methods.js') }}"></script>
<style>
    .payment-create-card{border-radius:24px}
    .title-section{font-size:18px;color:#231B72;font-weight:700}
    .input-easy{height:52px;border-radius:14px;border:1px solid #d4d9e3}
    .btn-save-card{background:#1FB141;color:#fff;border-radius:1;padding:7px 44px;font-size:18px}
    .brand-pill{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:12px;background:#eef1ff;color:#231B72;padding:5px 10px;border-radius:20px}
</style>
@endpush
