@extends('layouts.admin')
@section('title','Lista de Productos')
@section('page_title', 'Listado de Productos para aprobar')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Productos para aprobar</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Productos para aprobar</li>
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
                        <h4 class="card-title">Productos para aprobar</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting"  rowspan="1" colspan="1">Opciones</th>
                                        <th class="sorting"  rowspan="1" colspan="1">#</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Comercio</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Producto</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Categorias</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Sub Categorias</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Precio Mínimo</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Precio Máximo</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Cantidad Mínima</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Tiempo de Entrega</th>
                                        <th class="sorting"  rowspan="1" colspan="1">Valor Envio</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="product_id" value="{{ $item->encode_id }}">
                                                <input type="hidden" name="state" value="1">
                                                <div class="form-group mb-1">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ route('aprobar-producto') }}" class="btn btn-success waves-effect waves-float waves-light delete-user" value="Aprobar"><i class="fa fa-check-circle-o" aria-hidden="true"></i></button>
                                                </div>
                                            </form>
                                            <form method="POST" action="">
                                                <input type="hidden" name="product_id" value="{{ $item->encode_id }}">
                                                <input type="hidden" name="state" value="3">
                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ route('aprobar-producto') }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Rechazar"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                </div>
                                            </form>
                                        </td>

                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        
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
        title: 'Seguro que '+$(this).val()+' aprobar la publicación del producto?',
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
              type: 'POST',
              cache: false,
    	      data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                Swal.fire(
                    'Muy bien!',
                    'Producto '+json.message+' correctamente',
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


