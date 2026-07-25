@extends('layouts.admin')
@section('title','Lista de Productos')
@section('page_title', 'Listado de Productos')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Productos</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Productos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @can('Crear Productos')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block ">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <a href="{{ url('products/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Producto</a>

            </div>
        </div>
    </div>
    @endcan
</div>

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Productos</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting">Opciones</th>
                                        <th class="sorting">#</th>
                                        <th class="sorting">Comercio</th>
                                        <th class="sorting">Estado</th>
                                        <th class="sorting">Producto</th>
                                        <th class="sorting">Categorias</th>
                                        <th class="sorting">Sub Categorias</th>
                                        <th class="sorting">Precio Mínimo</th>
                                        <th class="sorting">Precio Máximo</th>
                                        <th class="sorting">Cantidad Mínima</th>
                                        <th class="sorting">Tiempo de Entrega</th>
                                        <th class="sorting">Valor Envio</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('products', [$item->encode_id,'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('products',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>
                                        </td>

                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            @if($item->state=='1')
                                                <span class="badge bg-success">Publicado</span>
                                            @endif
                                            @if($item->state=='2')
                                                <span class="badge bg-warning">Pendiente de aprobación</span>
                                            @endif
                                            @if($item->state=='3')
                                                <span class="badge bg-danger">Rechazado</span>
                                            @endif
                                            @if($item->state=='0')
                                                <span class="badge bg-warning">Pendiente de eliminación</span>
                                            @endif
                                            @if($item->state=='10')
                                                <span class="badge bg-danger">Desactivado</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>@foreach ($item->productcategories as $cat)
                                                        {{$cat->category->name}},                                                
                                            @endforeach
                                        </td>
                                        <td>@foreach ($item->productsubcategories as $sub)
                                                        {{$sub->subcategory->name}},                                                
                                            @endforeach</td>
                                        <td>${{number_format($item->price_min, 0, 0, '.')}}</td>
                                        <td>${{number_format($item->price_max, 0, 0, '.')}}</td>
                                        <td>{{ $item->quantity_min }}</td>
                                        <td>{{ $item->delivery_time }}</td>
                                        <td>${{number_format($item->shipping_price, 0, 0, '.')}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
    $('.delete-user').click(function(e){

        e.preventDefault();
        var _target=e.target;
        let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
        let token = $(this).attr('data-token');
        var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea eliminar el producto?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: href,
              headers: {'X-CSRF-TOKEN': token},
              type: 'DELETE',
              cache: false,
    	      data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                console.log(json);
                Swal.fire(
                    'Muy bien!',
                    'Producto eliminado correctamente',
                    'success'
                    ).then((result) => {
                        location.reload();
                    });

              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);

              }
           });

        }
        })

    });
</script>

@endpush


