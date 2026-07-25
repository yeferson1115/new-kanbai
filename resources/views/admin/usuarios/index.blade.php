@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page_title', 'Usuarios')



@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Usuarios</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                @can('Registrar Usuario')
                        <a href="{{ url('user/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i data-feather='user-plus'></i> Nuevo usuario</a>
                    @endcan
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
                        <h4 class="card-title">Usuarios</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th>#</th>
                                        <th>Acciones</th>
                                        <th>Nombre completo</th>
                                        <th>Usuario</th>
                                        <th>Género</th>
                                        <th>Tipo</th>
                                        <th>Correo electrónico</th>
                                        <th>Teléfono</th>
                                        <th>Acceso</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr class="odd row{{ $user->id }}">

                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @can('Editar Usuario')
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('user', [$user->encode_id,'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                            @endcan
                                            @can('Eliminar Usuario')
                                            <!--<a class="btn btn-danger waves-effect waves-float waves-light" href="{{ url('user', [$user->encode_id,'edit']) }}"><i data-feather='trash-2'></i> </a>-->
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('user',[$user->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>
                                            @endcan
                                            </td>
                                        <td>{{ $user->display_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        @if ($user->genero == 'F')
                                        <td><i class="fa fa-female" aria-hidden="true" style="font-size: 30px;color: #f3adb9;"></i></td>
                                        @else
                                        <td><i class="fa fa-male" aria-hidden="true" style="font-size: 30px;color: #4242ad;"></i></td>
                                         @endif


                                        <td>
                                            @if($user->hasRole('Administrador'))
                                                Administrador
                                            @elseif($user->hasRole('Comercio'))
                                                Comercio
                                            @elseif($user->hasRole('Asesor'))
                                                Asesor
                                            @elseif($user->hasRole('Empresa'))
                                                Empresa
                                            @else
                                                Usuario
                                            @endif
                                        </td>
                                        <td>{{ $user->email  }}</td>
                                        <td>{{ $user->phone  }}</td>
                                        <td><span class="badge  text-white {{ $user->status ? 'bg-success' : 'bg-danger' }}">{{ $user->display_status }}</span></td>


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
        title: 'Seguro que desea eliminar el usuario?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            var data = $('#user_delete').serialize();
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
                    'Usuario Eliminado correctamente',
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

