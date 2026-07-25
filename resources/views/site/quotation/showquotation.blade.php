@extends('layouts.app')
@section('title', 'Cotización #' . $quotation->id)

@section('content')
<section class="py-4" style="background-color: #f7f8fa;">
  <div class="container " style="margin-top: 130px !important;">
    <div class="row justify-content-center">

      
      <!-- =========================== -->
      <!-- 🧾 COTIZACIÓN PRINCIPAL -->
      <!-- =========================== -->
      <div class="col-lg-8 bg-white p-4 rounded-5 shadow-sm" style="border-radius: 15px !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <img src="https://kanbai.co/images/logo/logo-kanbai-color.png" alt="Logo" height="40">
          <div class="text-end">
            <h5 class="fw-bold mb-0">Cotización #{{ $quotation->id ?? $quotation->id }}</h5>
            <small class="text-muted">Fecha de solicitud: <strong>{{ \Carbon\Carbon::parse($quotation->created_at)->format('d/m/Y') }}</strong></small>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <h6 class="fw-bold">De:</h6>
            <p class="mb-1">{{ $quotation->company->name ?? 'Alma de Colombia SAS' }}</p>
            <p class="mb-1">NIT {{ $quotation->company->nit ?? '901450303' }}</p>
            <p class="mb-1">{{ $quotation->company->address ?? 'Calle 35 sur #45 b 72' }}</p>
            <p class="mb-0">{{ $quotation->company->phone ?? '+57 3104508361' }}</p>
          </div>
          <div class="col-md-6">
            <h6 class="fw-bold">Para:</h6>
            <p class="mb-1">{{ $quotation->name ?? 'Yeferson Sosa' }}</p>
            <p class="mb-1">{{ $quotation->cellphone ?? '30262145012' }}</p>
            <p class="mb-0">{{ $quotation->email ?? 'correo@gmail.com' }}</p>
          </div>
        </div>

        <!-- Tabla de ítems -->
         <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="text-white" style="background-color:#3e2b7b;">
            <tr>
              <th>ITEM</th>
              <th>DESCRIPCIÓN</th>
              <th class="text-center">QTY</th>
              <th class="text-end">PRECIO</th>
            </tr>
          </thead>
          <tbody style="border-top: none !important;">
            @foreach($quotation->items as $item)
              <tr>
                <td class="fw-semibold">{{ $item->producto->name }}</td>
                <td style="font-size: 0.9rem;">{!! Str::limit(strip_tags($item->producto->description), 250) !!}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">${{ number_format($item->price, 0, ',', '.') }}</td>
              </tr>
            @endforeach

            <tr>
              <td>Envío</td>
              <td>Embalaje, preparación y envío</td>
              <td class="text-center">1</td>
              <td class="text-end">${{ number_format($quotation->price_shiping, 0, ',', '.') }}</td>
            </tr>

            <tr>
              <td colspan="3" class="text-end fw-bold">Total:</td>
              <td class="text-end fw-bold text-primary" style="color: #707070 !important;">
                ${{ number_format($quotation->total+$quotation->price_shiping, 0, ',', '.') }}
              </td>
            </tr>
          </tbody>
        </table>
</div>
      </div>

      <!-- =========================== -->
      <!-- 🧍 PANEL DERECHO -->
      <!-- =========================== -->
      <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="bg-white rounded-3 shadow-sm p-3 mb-3" style="border-radius: 15px !important;">
          <div class="d-flex align-items-center">
            <img src="{{ asset('images/avatar.svg') }}" class="rounded-circle me-3" width="55">
            <div>
              <h6 class="fw-bold mb-0">{{ $quotation->user->name ?? 'Felipe Roldán Zuluaga' }}</h6>
              <small class="text-muted">Asesor encargado</small>
            </div>
          </div>
          <div class="mt-3 d-flex gap-2">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quotation->user->whatsapp ?? '573104508361') }}" class="btn btn-success btn-sm w-50" style="    background: #95FFBD67;
    color: #0F6227;
    border: none;
    padding: 7px;
    border-radius: 7px;
    font-weight: 600;">
              <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </a>
            <a href="mailto:{{ $quotation->user->email ?? 'ventas@kanbai.co' }}" class="btn btn-primary btn-sm w-50" style="background: #98CBE667;
    color: #1319B1;
    border: none;
    padding: 7px;
    border-radius: 7px;
    font-weight: 600;">
              <i class="fa fa-envelope"></i> Correo
            </a>
          </div>
        </div>

        <div class="bg-white rounded-3 shadow-sm p-3 mb-3" style="border-radius: 15px !important;">
          <p class="mb-1"><i class="fa fa-truck me-2"></i> Tiempo de entrega: <strong>{{ $quotation->date_delivery ?? '5 - 8 días hábiles' }}</strong></p>
          <p class="mb-0"><i class="fa fa-credit-card me-2"></i> Término de pago: <strong>{{ ucfirst($quotation->plazo ?? 'Contado') }}</strong></p>
        </div>

        <div class="bg-white rounded-3 shadow-sm p-3 mb-3" style="border-radius: 15px !important;">
          <p class="mb-1">Subtotal: <strong>${{ number_format($quotation->total, 0, ',', '.') }}</strong></p>
          <p class="mb-1">Valor envío: <strong>${{ number_format($quotation->price_shiping, 0, ',', '.') }}</strong></p>
          <hr>
          <p class="mb-0">Valor total con IVA: <strong>${{ number_format($quotation->total+$quotation->price_shiping, 0, ',', '.') }}</strong></p>
        
          <div class="d-grid gap-2 mt-5">
            <a href="https://checkout.wompi.co/l/VPOS_LIzhDs" class="btn fw-bold text-white" 
                style="background: #1ED161; border: none; border-radius: 7px;">
                Pagar por Wompi
            </a>

            <div class="d-flex gap-2 mb-5">                
                <a href="{{ asset('cotizaciones/'.$quotation->file.'') }}" target="_blank"  style="background: #F0EFFF;
                color: #413A84;
                border: none;
                padding: 7px;
                border-radius: 7px;
                font-weight: 600;"
                class="btn btn-outline-primary w-50">Descargar/Imprimir</a>
            </div>
        </div>
        </div>

        

      </div>

    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
function imprimirCotizacion() {
  // Oculta los botones antes de imprimir
  const botones = document.querySelectorAll('a, button');
  botones.forEach(btn => btn.style.display = 'none');

  // Ejecuta la impresión
  window.print();

  // Restaura los botones después de imprimir
  setTimeout(() => {
    botones.forEach(btn => btn.style.display = '');
  }, 500);
}
</script>
@endpush