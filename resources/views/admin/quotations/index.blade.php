@extends('layouts.admin')
@section('title','Lista de Cotizaciones')
@section('page_title', 'Listado de Cotizaciones')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Cotizaciones</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Cotizaciones</li>
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
                    <div class="card-body">

                    <ul class="nav nav-pills tap-solicitudes mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">Todos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-espera-tab" data-bs-toggle="pill" data-bs-target="#pills-espera" type="button" role="tab" aria-controls="pills-espera" aria-selected="false">Solicitudes en espera: {{count($qespera)}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-canseladas-tab" data-bs-toggle="pill" data-bs-target="#pills-canseladas" type="button" role="tab" aria-controls="pills-canseladas" aria-selected="false">Solicitudes canceladas: {{count($qcanceladas)}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-aprobadas-tab" data-bs-toggle="pill" data-bs-target="#pills-aprobadas" type="button" role="tab" aria-controls="pills-aprobadas" aria-selected="false">Solicitudes aprobadas: {{count($qaprobadas)}}</button>
                        </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">

                            <div class="table-responsive">
                                <table class="table" id="datatables" >
                                    <thead class="table-light">
                                        <tr >
                                            <th class="sorting"  rowspan="1" colspan="1">Opciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">#</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Estado</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Asesor</th>
                                            <th class="sorting"  rowspan="1" colspan="1">E-mail</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cliente</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Celular</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cantidad requerida</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Dirección</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha de entrega</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Observaciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha creación</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($quotations as $item)
                                        <tr class="odd row{{ $item->id }}">
                                            <td>
                                                <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('quotes', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>
                                                <!--<a class="btn btn-info" href="{{ route('quotes.show',$item->encode_id) }}">Ver</a>-->
                                                <!--<form method="POST" action="">

                                                    <div class="form-group">
                                                        <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                    </div>
                                                </form>-->
                                            </td>

                                            <td>{{ $item->id }}</td>
                                            <td>@if($item->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                                            @if($item->state==1) <span class="badge  text-white bg-success">Gestionada</span> @endif
                                            @if($item->state==6) <span class="badge  text-white bg-info">Enviada</span> @endif
                                            @if($item->state==4) <span class="badge  text-white bg-success">Aprobada por el usuario</span> @endif
                                            @if($item->state==2) <span class="badge  text-white bg-danger">Cancelada</span> @endif
                                            @if($item->state==3) <span class="badge  text-white bg-info">Ganada</span> @endif
                                            @if($item->state==5) <span class="badge  text-white bg-danger">Cancelada por el usuario</span> @endif</td>
                                            <td>@if($item->user!=null){{ $item->user->name }} {{ $item->user->lastname }}@endif</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->cellphone }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->date_delivery }}</td>
                                            <td>{{ $item->observations }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        
                                            

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-espera" role="tabpanel" aria-labelledby="pills-espera-tab">

                            <div class="table-responsive">
                                <table  class="table" id="datatables" >
                                    <thead class="table-light">
                                        <tr >
                                            <th class="sorting"  rowspan="1" colspan="1">Opciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">#</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Estado</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Producto</th>
                                            <th class="sorting"  rowspan="1" colspan="1">E-mail</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cliente</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Celular</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cantidad requerida</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Dirección</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha de entrega</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Observaciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha creación</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($qespera as $item)
                                        <tr class="odd row{{ $item->id }}">
                                            <td>
                                                <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('quotes', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>
                                                <!--<form method="POST" action="">

                                                    <div class="form-group">
                                                        <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                    </div>
                                                </form>-->
                                            </td>

                                            <td>{{ $item->id }}</td>
                                            <td>@if($item->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                                            @if($item->state==1) <span class="badge  text-white bg-success">Aprobada</span> @endif
                                            @if($item->state==4) <span class="badge  text-white bg-success">Aprobada por el usuario</span> @endif
                                            @if($item->state==2) <span class="badge  text-white bg-danger">Cancelada</span> @endif
                                            @if($item->state==3) <span class="badge  text-white bg-info">Ganada</span> @endif
                                            @if($item->state==5) <span class="badge  text-white bg-danger">Cancelada por el usuario</span> @endif</td>
                                            <td>@if($item->producto!=null){{ $item->producto->name }}@endif</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->cellphone }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->date_delivery }}</td>
                                            <td>{{ $item->observations }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        
                                            

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>
                        <div class="tab-pane fade" id="pills-canseladas" role="tabpanel" aria-labelledby="pills-canseladas-tab">

                            <div class="table-responsive">
                                <table  class="table " id="datatables">
                                    <thead class="table-light">
                                        <tr >
                                            <th class="sorting"  rowspan="1" colspan="1">Opciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">#</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Estado</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Producto</th>
                                            <th class="sorting"  rowspan="1" colspan="1">E-mail</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cliente</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Celular</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cantidad requerida</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Dirección</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha de entrega</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Observaciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha creación</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($qcanceladas as $item)
                                        <tr class="odd row{{ $item->id }}">
                                            <td>
                                                <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('quotes', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>
                                                <!--<form method="POST" action="">

                                                    <div class="form-group">
                                                        <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                    </div>
                                                </form>-->
                                            </td>

                                            <td>{{ $item->id }}</td>
                                            <td>@if($item->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                                            @if($item->state==1) <span class="badge  text-white bg-success">Aprobada</span> @endif
                                            @if($item->state==4) <span class="badge  text-white bg-success">Aprobada por el usuario</span> @endif
                                            @if($item->state==2) <span class="badge  text-white bg-danger">Cancelada</span> @endif
                                            @if($item->state==3) <span class="badge  text-white bg-info">Ganada</span> @endif
                                            @if($item->state==5) <span class="badge  text-white bg-danger">Cancelada por el usuario</span> @endif</td>
                                            <td>@if($item->producto!=null){{ $item->producto->name }}@endif</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->cellphone }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->date_delivery }}</td>
                                            <td>{{ $item->observations }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        
                                            

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-aprobadas" role="tabpanel" aria-labelledby="pills-aprobadas-tab">

                            <div class="table-responsive">
                                <table  class="table" id="datatables">
                                    <thead class="table-light">
                                        <tr >
                                            <th class="sorting"  rowspan="1" colspan="1">Opciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">#</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Estado</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Producto</th>
                                            <th class="sorting"  rowspan="1" colspan="1">E-mail</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cliente</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Celular</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Cantidad requerida</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Dirección</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha de entrega</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Observaciones</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha creación</th>
                                            <th class="sorting"  rowspan="1" colspan="1">Fecha actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($qaprobadas as $item)
                                        <tr class="odd row{{ $item->id }}">
                                            <td>
                                                <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('quotes', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>
                                                <!--<form method="POST" action="">

                                                    <div class="form-group">
                                                        <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                    </div>
                                                </form>-->
                                            </td>

                                            <td>{{ $item->id }}</td>
                                            <td>@if($item->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                                            @if($item->state==1) <span class="badge  text-white bg-success">Aprobada</span> @endif
                                            @if($item->state==4) <span class="badge  text-white bg-success">Aprobada por el usuario</span> @endif
                                            @if($item->state==2) <span class="badge  text-white bg-danger">Cancelada</span> @endif
                                            @if($item->state==3) <span class="badge  text-white bg-info">Ganada</span> @endif
                                            @if($item->state==5) <span class="badge  text-white bg-danger">Cancelada por el usuario</span> @endif</td>
                                            <td>@if($item->producto!=null){{ $item->producto->name }}@endif</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->cellphone }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->date_delivery }}</td>
                                            <td>{{ $item->observations }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        
                                            

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
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
        title: 'Seguro que desea eliminar la cotización?',
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
                    'Cotización eliminado correctamente',
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


