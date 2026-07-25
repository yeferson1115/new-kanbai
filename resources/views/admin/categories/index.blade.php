@extends('layouts.admin')
@section('title','Categorías')
@section('page_title', 'Listado de Categorías')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Categorías</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Categorías</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <a href="{{ url('categories/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i class="fa fa-folder-o" aria-hidden="true"></i> Nueva categoría</a>

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
                        <h4 class="card-title">Categorías</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 104.281px;" aria-label="Experience: activate to sort column ascending">Opciones</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 51.875px;" aria-label="Name: activate to sort column ascending">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 54.7969px;" aria-label="Email: activate to sort column ascending">Nombre</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 48.7812px;" aria-label="Post: activate to sort column ascending">Slug</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 48.7812px;" aria-label="Post: activate to sort column ascending">Estado</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" style="width: 48.7812px;" aria-label="Post: activate to sort column ascending">Imagen</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($categories as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('categories', [$item->encode_id,'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('categories',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>
                                        </td>

                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td><span class="badge  text-white {{ $item->state ? 'bg-success' : 'bg-danger' }}">{{ $item->state ? 'Activada' : 'Desactivada' }}</span></td>
                                        <td><img style="max-height: 70px;" src="{{ asset('images/categories/'.$item->file.'') }}" alt="Imagen"></td>
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
        title: 'Seguro que desea eliminar la categoría?',
        text: "Se borraran todos los registros asociados a esta categoria",
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
                    'Categoría eliminado correctamente',
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


