@extends('layouts.admin')
@section('title','Ordenes')
@section('page_title', 'Listado de Ordenes')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Ordenes</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Ordenes</li>
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
                        <h4 class="card-title">Ordenes</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        
                                        <th class="sorting">#</th>
                                        <th class="sorting">Estado</th>
                                        <th class="sorting">Referencia</th>
                                        <th class="sorting">Productos</th>                                        
                                        <th class="sorting">Fecha de entrega</th>
                                        <th class="sorting">Cliente</th>
                                        <th class="sorting">Tipo de Documento</th>
                                        <th class="sorting">Documento</th>
                                        <th class="sorting">Dirección</th>
                                        <th class="sorting">Ciudad</th>
                                        <th class="sorting">Celular</th>
                                        <th class="sorting">E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $item)
                                    <tr class="odd row{{ $item->id }}">
                                       

                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if($item->state=='1')
                                            <span class="badge bg-info text-dark">Ordenada</span>
                                            @endif
                                            @if($item->state=='2')
                                            <span class="badge bg-warning text-dark">Pendiente Por Pago</span>
                                            @endif
                                            @if($item->state=='3')
                                            <span class="badge bg-primary">En Proceso</span>
                                            @endif
                                            @if($item->state=='4')
                                            <span class="badge bg-secondary">Despachada</span>
                                            @endif
                                            @if($item->state=='5')
                                            <span class="badge bg-success">Entregada</span>
                                            @endif
                                            @if($item->state=='0')
                                            <span class="badge bg-danger">Cancelada</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->reference }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalproduct{{ $item->id }}">
                                            Ver Productos
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalproduct{{ $item->id }}" tabindex="-1" aria-labelledby="modalproduct{{ $item->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalproduct{{ $item->id }}Label">Productos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Producto</th>
                                                                <th scope="col">Cantidad</th>                                                            
                                                                <th scope="col">Adicionales</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($item->items as $product)
                                                            @if($product->producto->user_id==Auth::user()->id)
                                                            <tr>
                                                                <td>{{$product->producto->name}}</td>
                                                                <td>{{$product->quantity}}</td>
                                                                @if(count($product->extras)>0)
                                                                <td>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Extra</th>
                                                                                <th scope="col">Precio</th>
                                                                                <th scope="col">Cantidad</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($product->extras as $extra)
                                                                            <tr>
                                                                                <td>{{$extra->itemextra->name}}</td>
                                                                                <td>{{$extra->itemextra->price}}</td>
                                                                                <td>{{$extra->quantity}}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                                @else
                                                                <td>N/A</td>
                                                                @endif                                                            
                                                            </tr>
                                                            @endif
                                                    @endforeach                                                   
                                                </tbody>
                                            </table> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                            
                                        </td>                                       
                                        <td>{{$item->date_delivery}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->type_document}}</td>
                                        <td>{{$item->document}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->city}}</td>
                                        <td>{{$item->cellphone}}</td>
                                        <td>{{$item->email}}</td>
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
        title: 'Seguro que desea eliminar la orden?',
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
                    'Orden eliminado correctamente',
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


