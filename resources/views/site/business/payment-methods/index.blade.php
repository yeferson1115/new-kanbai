@extends('layouts.appuser')
@section('title', 'Métodos de pago')

@section('content')
<section class="payment-methods-page">
    <div class="card payment-methods-card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <h2 class="title-section m-0">Métodos de pago</h2>
                <a href="{{ route('payment-methods.create') }}" class="btn btn-add-card">+ Agregar tarjeta</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @forelse($paymentMethods as $method)
                <div class="payment-row d-flex justify-content-between align-items-center py-3 border-top">
                    <div class="d-flex align-items-center gap-3">
                        <span class="payment-brand">{{ $method->brand }}</span>
                        <span class="payment-mask">•••• {{ $method->last_four }}</span>
                    </div>
                    <a class="payment-link text-decoration-none" href="{{ route('payment-methods.edit', $method->id) }}">Actualizar</a>
                </div>
            @empty
                <div class="border-top pt-4 text-muted">No tienes métodos de pago guardados.</div>
            @endforelse

            <div class="payment-row d-flex align-items-center gap-3 py-3 border-top">
                @if(!empty($business->term))
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <span class="payment-credit">Crédito aprobado {{ $business->term }} días</span>
                @else
                    <i class="fa-regular fa-circle text-muted"></i>
                    <span class="payment-credit text-muted">Sin crédito aprobado</span>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
    .payment-methods-card{border-radius:24px}
    .title-section{font-size:18px;color:#231B72;font-weight:700}
    .btn-add-card{background:#1FB141;color:#fff;border-radius:12px;padding:7px 24px}
    .payment-brand{font-weight:700;color:#363636;min-width:130px}
    .payment-mask,.payment-credit{font-size:16px;font-weight:600;color:#555}
    .payment-link{color:#6b63ff;font-weight:600}
    @media (max-width:768px){
        .title-section{font-size:28px}
        .payment-mask,.payment-credit{font-size:18px}
    }
</style>
@endpush
