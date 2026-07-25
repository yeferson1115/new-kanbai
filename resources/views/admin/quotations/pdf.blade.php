<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Cotización #{{ $quotation->id }}</title>
<style>
/* === Configuración general de página === */
@page {
  margin: 130px 50px 90px 50px;
}
body{
  font-family: 'Tahoma', sans-serif;
  font-size: 13px;
  color:#3a3a3a;
}

/* ---------- CABECERA ---------- */
header{
  position:fixed;
  top:-120px;
  left:0;
  right:0;
  height:120px;
  padding-top:15px;
  padding-bottom:15px;
}
.header-wrap{
  width:100%;
  /* ✅ se quitó la línea inferior */
  padding-bottom:5px;
  padding-top:25px;
  margin-bottom:30px;
}
.header-table{
  width:100%;
  border-collapse:collapse;
}
.header-table td{
  vertical-align:middle;
}
.logo-box{
  width:15%;
}
.logo-box img{
  max-height:30px; /* ✅ logo más pequeño */
  margin-right:8px;
}
.header-info{
  text-align:right;
  font-size:13px;
  color:#3a3a3a;
  width:55%;
}

/* ---------- PIE DE PÁGINA ---------- */
footer{
  position:fixed;
  bottom:-70px;
  left:0;
  right:0;
  height:60px;
  text-align:center;
  font-size:11px;
  color:#666;
}
footer .strip{
  width:100%;
  height:18px;
  background:#f1f1f1;
  position:absolute;
  top:0;
  left:0;
}
.pagenum:before{
  content: counter(page);
}

/* ---------- SECCIONES GENERALES ---------- */
.section{
  margin-bottom:22px;
}
h3.section-title{
  color:#413A84;
  margin-bottom:8px;
  font-size:16px;
}

/* ---------- TABLAS INFORMATIVAS ---------- */
.info-table{
  width:100%;
  border-collapse:collapse;
  margin-bottom:20px;
}
.info-table td{
  width:50%;
  vertical-align:top;
}

/* ✅ Tabla de fecha con fondo gris y borde */
table.fecha-orden{
  width:100%;
  border-collapse:collapse;
  margin-bottom:20px;
}
table.fecha-orden td{
  border:1px solid #dcdcdc;
  background:#f8f8f8;
  padding:8px 10px;
  font-size:13px;
}

/* ---------- TABLA DE PRODUCTOS ---------- */
table.items{
  width:100%;
  border-collapse:collapse;
  margin-bottom:10px;
  border-radius:8px; /* ✅ bordes redondeados */
  overflow:hidden; /* para que el border-radius se vea */
  border:1px solid #cfcfcf;
}
table.items thead{
  background:#413A84;
  color:#fff;
  font-weight:bold;
}
table.items th, table.items td{
  border:1px solid #cfcfcf;
  padding:8px;
  font-size:12px;
}
table.items th{
  text-align:center;
}
table.items td:nth-child(1){ width:40%; }
table.items td:nth-child(2),
table.items td:nth-child(3),
table.items td:nth-child(4){ text-align:center; }
table.items td:nth-child(5){ text-align:right; }

/* ---------- TOTALES ---------- */
.totales{
  width:42%;
  float:right;
  border-collapse:collapse;
  margin-top:20px;
}
.totales td{
  padding:6px;
  font-size:13px;
  border:1px solid #e5e5e5;
}
.totales tr td:first-child{
  text-align:right;
  font-weight:bold;
  color:#444;
  background:#fafafa;
  width:55%;
}
.totales tr:last-child td{
  font-size:14px;
  background:#f1f1f1;
}

/* ---------- IMÁGENES ---------- */
.imagenes{
  margin-top:30px;
  page-break-before: always; 
}
.imagenes h3{
  font-size:15px;
  color:#413A84;
  margin-bottom:10px;
}
.imagenes img{
  height:130px;
  margin:0 8px 10px 0;
  border:1px solid #ddd;
  border-radius:3px;
}

/* ---------- CONDICIONES ---------- */
.condiciones{
  margin-top:30px;
}
.condiciones h3{
  background:#413A84;
  color:#fff;
  padding:10px;
  font-size:15px;
  margin:0 0 10px 0;
}
.condiciones ul{
  margin:0;
  padding-left:20px;
}
.condiciones li{
  margin-bottom:6px;
  font-size:13px;
}
</style>
</head>
<body>
<header style="margin-bottom:30px;">
  <div class="header-wrap">
    <table class="header-table">
      <tr>
        <td class="logo-box">
          <img src="{{ $logo }}" alt="Alma de Colombia">
        </td>
        <td class="header-info">
          <strong>ALMA DE COLOMBIA SAS</strong><br>
          CARRERA 56 46 49 ED POMPANO<br>
          MEDELLIN Antioquia Colombia
        </td>
      </tr>
    </table>
  </div>
</header>

<footer>
  
  ALMA DE COLOMBIA SAS | Calle 56 # 46 - 49 int 908 Medellín / Calle 104 # 14 -86 int 501 Bogotá D.C. | NIT 901450303<br>
  Tel: +57 310 450 8361 | admin@almadelascosas.com<br>
  Página <span class="pagenum"></span> / {PAGE_COUNT}
</footer>

<main style="margin-top-30px">
  <!-- ================= DATOS DE FACTURACIÓN ================= -->
  <div class="section">
    <table class="info-table" style="margin-top:40px;">
      <tr>
        <td>
          <strong>{{ $quotation->name_business ?? ($quotation->name_business ?? '') }}</strong><br>
          <strong>{{ $quotation->name ?? ($quotation->name ?? '') }}</strong><br>
          {{ $quotation->cellphone ?? ($quotation->cellphone ?? '') }}<br>
          {{ $quotation->email ?? ($quotation->email ?? '') }}
        </td>
        <td>
          <h3 class="section-title">Número de orden SO{{$quotation->id}}</h3>
        </td>
      </tr>
    </table>
  </div>

  <!-- ✅ Nueva tabla con borde y fondo gris -->
  <table class="fecha-orden" style="border-radius:8px;">
    <tr>
      <td>Fecha de la orden<br> {{ \Carbon\Carbon::parse($quotation->created_at)->format('d/m/Y') }}</td>
      <td>
        @if($quotation->user!=null)
        Vendedor<br>
        {{$quotation->user->name}} {{$quotation->user->lastname}}
        @endif
      </td>
    </tr>
  </table>
  <!-- ================= LISTA DE ÍTEMS ================= -->
  <table class="items">
    <thead>
      <tr>
        <th>DESCRIPCIÓN</th>
        <th>CANT.</th>
        <th>PRECIO UNIT.</th>
        <th>IMP.</th>
        <th>IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      @php
          $maxDeliveryTime = 0;
          $totalIva = 0;
      @endphp
      @foreach($quotation->items as $item)
      <tr>
        <td>
          <strong>{{ $item->producto->name ?? 'Producto' }}</strong><br>
          {!! $item->producto->description ?? '' !!}
        </td>
        <td>{{ $item->quantity }}</td>
        <td>
          @php
              $iva = $item->producto->iva ?? 0;
              $precioSinIva = $item->price / (1 + ($iva / 100));
              $ivaProducto = ($item->price - $precioSinIva) * $item->quantity;
              $totalIva += $ivaProducto;

               // 🔹 Extraer número(s) del string delivery_time
              $deliveryText = $item->producto->delivery_time ?? '';
              preg_match_all('/\d+/', $deliveryText, $matches);
              $numbers = $matches[0] ?? [];

              if (!empty($numbers)) {
                  $mayorDelProducto = max($numbers);
                  if ($mayorDelProducto > $maxDeliveryTime) {
                      $maxDeliveryTime = $mayorDelProducto;
                  }
              }
          @endphp
        ${{ number_format($precioSinIva,0,',','.') }}
      </td>
        <td>{{ $item->producto->iva ?? '0' }}%</td>
        <td>${{ number_format($item->price * $item->quantity,0,',','.') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
@php
    $subtotal = $quotation->total - $totalIva;
@endphp
  <!-- ================= TOTALES ================= -->
  <table class="totales">
    <tr>
      <td>Subtotal:</td>
      <td>${{ number_format($subtotal,0,',','.') }}</td>
    </tr>
    <tr>
      <td>IVA:</td>
      <td>${{ number_format($totalIva, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td>ENVIO:</td>
      <td>${{ number_format($quotation->price_shiping, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td><strong>Total:</strong></td>
      <td><strong>${{ number_format($quotation->total+$quotation->price_shiping,0,',','.') }}</strong></td>
    </tr>
  </table>

  <div style="clear: both;"></div>

  <!-- ================= GALERÍA ================= -->
  <div class="imagenes">
    <h3 style="margin-bottom: 30px;">IMÁGENES DEL PRODUCTO</h3>
    @foreach($galeria as $img)
    <img src="{{ $img }}" alt="Producto">
    @endforeach
    <p style="font-size:12px; color:#666; margin-top:6px;">
      Observación: Estas son imágenes de referencia; el resultado final puede variar según la personalización solicitada.
    </p>
  </div>

  <!-- ================= CONDICIONES ================= -->
  <div class="condiciones">
    <h3>CONSIDERACIONES Y CONDICIONES DE SERVICIO</h3>
    @if(!empty($quotation->comment))
      {!! $quotation->comment !!}
    @else
    <ul>
      <li>Pago: <br>Modalidad: {{$quotation->plazo}} <br> El proyecto iniciará únicamente después de haber recibido la confirmación de pago total.</li>
      <li>Tiempos de Entrega: El tiempo estimado de entrega es de mínimo {{$maxDeliveryTime}} días hábiles, contados a partir de la aprobación final del arte/diseño por parte del cliente y la confirmación del pago.</li>
      <li>Proceso de Producción: Antes de iniciar la producción, se presentarán al cliente los artes y diseños correspondientes para su revisión y aprobación expresa. No se procederá a fabricar sin esta aprobación previa. La aprobación de estos diseños constituye conformidad con lo solicitado.</li>
      <li>Información para Envío: El envío se realizará a la dirección proporcionada por el cliente.<br>Es responsabilidad exclusiva del cliente asegurar que los datos suministrados para la entrega sean correctos y estén completos. Una vez despachado el pedido, se enviará la guía correspondiente como constancia del cumplimiento de envío.</li>
      <li>Garantía: Se ofrece garantía sobre los productos entregados en caso de: <br>Daños parciales o totales durante el transporte.<br>Pérdida de piezas específicas del pedido.<br>En cualquiera de estos casos, se repondrá el ítem afectado, una vez se verifique la situación. No se contemplan devoluciones por causas imputables al cliente.</li>
      <li>6. Vigencia de la Cotización
La presente cotización tiene una vigencia de cuarenta (30) días calendario a partir de su emisión. Pasado este tiempo, puede estar sujeta a revisión de precios y condiciones.</li>
    </ul>
    <p style="margin-top:10px;">
      SIGUIENTES PASOS<br>
¿Deseas avanzar con tu pedido? Comunícate con tu asesor comercial para recibir la información necesaria e iniciar el proceso formal.<br>

¿Deseas hacer ajustes a la cotización? Contáctanos para revisar tus requerimientos y actualizar la propuesta.
    </p>
    @endif
    <h4 style="margin-top:20px;">Muchas gracias.</h4>
  </div>
</main>
</body>
</html>
