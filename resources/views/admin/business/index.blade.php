@extends('layouts.admin')
@section('title','Empresas')
@section('page_title', 'Listado de Empresas')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Empresas</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Empresas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @can('Ver Empresas')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <a href="{{ url('empresas/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i class="fa fa-briefcase" aria-hidden="true"></i> Nueva Empresa</a>

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
                        <h4 class="card-title">Empresas</h4>
                    </div>
                    <div class="card-body">   

                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting" >Opciones</th>
                                        <th class="sorting" >#</th>
                                        <th class="sorting" >Nombre</th>
                                        <th class="sorting" >Nit</th>
                                        <th class="sorting" >Dirección</th>
                                        <th class="sorting" >E-mail Facturación</th>
                                        <th class="sorting" >Departamento</th>
                                        <th class="sorting" >Ciudad</th>
                                        <th class="sorting" >Asesor</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($business as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('empresas', [$item->encode_id,'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('empresas',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>
                                        </td>

                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->company_name }}</td>
                                        <td>{{ $item->nit }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->billing_email }}</td>
                                        <td>@if($item->departaments!=null){{ $item->departaments->name }}@endif</td>
                                        <td>@if($item->cities!=null){{ $item->cities->name }}@endif</td>
                                        <td>@if($item->asesor!=null){{ $item->asesor->name }} {{ $item->asesor->lastname }} @endif</td>
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
        title: 'Seguro que desea eliminar la empresa?',
        text: "Se borraran todos los registros asociados a esta empresa",
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
                    'Empresa eliminada correctamente',
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


