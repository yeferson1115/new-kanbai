@extends('layouts.admin')
@section('title','Roles')
@section('page_title', 'Listado de Roles')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Roles</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                @can('Registrar Role')
                        <a href="{{ url('roles/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i data-feather='user-plus'></i> Nuevo rol</a>
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
                        <h4 class="card-title">Roles</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 51.875px;" aria-label="Name: activate to sort column ascending">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 54.7969px;" aria-label="Email: activate to sort column ascending">Nombre completo</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 48.7812px;" aria-label="Post: activate to sort column ascending">Usuario</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 104.281px;" aria-label="Experience: activate to sort column ascending">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($roles as $role)
                                    <tr class="odd row{{ $role->id }}">

                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                        @can('EditarRole')
                                        <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('roles', [Hashids::encode($role->id),'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                        @endcan
                                        </td>

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
