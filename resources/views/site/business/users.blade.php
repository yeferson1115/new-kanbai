@extends('layouts.appuser')
@section('title', 'Usuarios')
@section('content')

@section('content')

<section class="row">
    <div class="col-md-12" style="padding: 0px 30px;">
    <a href="javascript:history.back()" class="previos-profile">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
        
        <div class="card content-user">
        <div class="header-content-user">
            <h4 class="card-title title-user">Usuarios</h4>
            <a class="mb-1 btn btn-warning waves-effect waves-float waves-light btn-add-user" href="usuariosempresa/create" title="Editar">
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar usuario
            </a>
        </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="datatables" >
                        <thead class="table-light">
                                    <tr >                                       
                                        
                                        <th class="sorting" >Nombre</th>
                                        <th class="sorting" >Cargo</th>
                                        <th class="sorting" >Celular</th>
                                        <th class="sorting" >Correo</th>
                                        <th class="sorting" >Gestionar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->charge }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light btn-edit-user" href="{{ route('usuariosempresa.edit', ['id' => $item->encode_id]) }}" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

        
    </div>
</section>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/app/user/create.js') }}"></script>
@endpush
