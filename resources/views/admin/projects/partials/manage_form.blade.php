@extends('layouts.admin')

@section('title', 'Proyectos')
@section('page_title', 'Agregar Proyecto')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nueva Proyecto</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/projects">Proyectos &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nueva Proyecto</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Crear Proyecto</h4>
                    </div>
                    <div class="card-body mt-4">
<form id="manage-form" class="p-2" enctype="multipart/form-data" data-action="{{ route('updateproyect') }}">
  @csrf
  <input type="hidden" name="id" value="{{ $project->encode_id }}">

  <div class="row">
    <div class="col-md-6">
      <label>Número Proyecto</label>
      <input type="text" name="no_project" class="form-control" value="{{ old('no_project', $project->no_project) }}">
    </div>

    <div class="col-md-6">
      <label>Cliente</label>
      <input type="text" name="customer" class="form-control" value="{{ old('customer', $project->customer) }}">
    </div>

    <div class="col-md-4">
      <label>Fecha Entrega</label>
      <input type="date" name="date_shopping" class="form-control" value="{{ old('date_shopping', $project->date_shopping) }}">
    </div>

    <div class="col-md-4">
      <label>Comercio</label>
      <select name="bussine_id" class="form-control">
        <option value="">Seleccione Comercio</option>
        @foreach($comercios as $c)
          <option value="{{ $c->id }}" {{ ($project->bussine_id == $c->id) ? 'selected' : '' }}>{{ $c->company_name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-4">
      <label>Vendedor</label>
      <select name="seller_id" class="form-control">
        <option value="">Seleccione Vendedor</option>
        @foreach($vendedores as $v)
          <option value="{{ $v->id }}" {{ ($project->seller_id == $v->id) ? 'selected' : '' }}>{{ $v->name }} {{ $v->lastname }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 mt-3">
      <label>Información de envío</label>
      <textarea name="information_shopping" class="form-control">{{ $project->information_shopping }}</textarea>
    </div>

    <hr class="my-3">

    {{-- Productos existentes (indexados) --}}
    <div id="products-edit-container">
      @php $idx = 0; @endphp
      @foreach($project->productos as $p)
        <div class="row mb-2 product-row" id="prodRow_{{ $idx }}">
          <input type="hidden" name="producto_id[{{ $idx }}]" value="{{ $p->id }}">
          <div class="col-md-4">
            <label>Producto</label>
            <input type="text" name="producto[{{ $idx }}]" class="form-control" value="{{ $p->producto }}">
          </div>
          <div class="col-md-2">
            <label>Precio</label>
            <input type="number" name="price[{{ $idx }}]" class="form-control" value="{{ $p->price }}">
          </div>
          <div class="col-md-2">
            <label>Cantidad</label>
            <input type="number" name="quantity[{{ $idx }}]" class="form-control" value="{{ $p->quantity }}">
          </div>
          <div class="col-md-3">
            <label>Imagen (subir para reemplazar)</label>
            <input type="file" name="imagen[{{ $idx }}]" class="form-control">
            @if($p->imagen)
              <img src="{{ asset('images/custom_request/'.$p->imagen) }}" style="max-width:80px;margin-top:6px;">
            @endif
          </div>
          <div class="col-md-1 d-flex align-items-center">
            <button type="button" class="btn btn-danger remove-existing-product" data-prod-id="{{ $p->id }}" data-row="prodRow_{{ $idx }}">X</button>
          </div>
        </div>
        @php $idx++; @endphp
      @endforeach
    </div>

    {{-- contenedor para inputs hidden de productos eliminados --}}
    <div id="removed-products-container"></div>

      <!-- Botón para agregar productos nuevos -->
    <div class="col-12 mt-3">
      <button type="button" class="btn btn-success" id="addProductBtn">+ Agregar Producto</button>
    </div>

    {{-- Botones --}}
    <div class="col-12 mt-3 d-flex justify-content-end">
      <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-primary" id="manageSaveBtn">Guardar</button>
    </div>
  </div>
</form>
</div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection



@push('scripts')
<script src="{{ asset('js/admin/project/manage.js') }}"></script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    // Toma el valor que generó blade como número
    let productIndex = {{ $idx }}; 

    const container = document.getElementById('products-edit-container');
    const removedContainer = document.getElementById('removed-products-container');
    const addBtn = document.getElementById('addProductBtn');

    // Verificar que los elementos existen
    if (!container) {
      console.error('Container de productos no encontrado');
      return;
    }
    if (!addBtn) {
      console.error('Botón Agregar Producto no encontrado');
      return;
    }
    if (!removedContainer) {
      console.error('Container de productos removidos no encontrado');
    }

    // Función para agregar nuevo producto
    addBtn.addEventListener('click', function () {
      const rowId = `prodRow_${productIndex}`;
      const newRow = document.createElement('div');
      newRow.classList.add('row', 'mb-2', 'product-row');
      newRow.id = rowId;

      newRow.innerHTML = `
        <input type="hidden" name="producto_id[${productIndex}]" value="">
        <div class="col-md-4">
          <label>Producto</label>
          <input type="text" name="producto[${productIndex}]" class="form-control">
        </div>
        <div class="col-md-2">
          <label>Precio</label>
          <input type="number" name="price[${productIndex}]" class="form-control">
        </div>
        <div class="col-md-2">
          <label>Cantidad</label>
          <input type="number" name="quantity[${productIndex}]" class="form-control">
        </div>
        <div class="col-md-3">
          <label>Imagen</label>
          <input type="file" name="imagen[${productIndex}]" class="form-control">
        </div>
        <div class="col-md-1 d-flex align-items-center">
          <button type="button" class="btn btn-danger remove-product" data-row="${rowId}">X</button>
        </div>
      `;

      container.appendChild(newRow);
      productIndex++;
    });

    // Delegar eliminación de filas
    document.addEventListener('click', function (e) {
      // eliminar producto nuevo
      if (e.target && e.target.matches('button.remove-product')) {
        const rowId = e.target.getAttribute('data-row');
        const row = document.getElementById(rowId);
        if (row) {
          row.remove();
        }
      }
      // eliminar producto existente
      if (e.target && e.target.matches('button.remove-existing-product')) {
        const rowId = e.target.getAttribute('data-row');
        const prodId = e.target.getAttribute('data-prod-id');
        const row = document.getElementById(rowId);

        if (removedContainer) {
          const inputHidden = document.createElement('input');
          inputHidden.type = 'hidden';
          inputHidden.name = 'removed_product_ids[]';
          inputHidden.value = prodId;
          removedContainer.appendChild(inputHidden);
        }

        if (row) {
          row.remove();
        }
      }
    });
  });
</script>
@endpush


