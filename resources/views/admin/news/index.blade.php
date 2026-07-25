@extends('layouts.admin')
@section('title','Novedades')
@section('page_title', 'Listado de Novedades')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Novedades</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Novedades</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @can('Crear Novedades')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <a href="{{ url('novedades/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i class="fa fa-folder-o" aria-hidden="true"></i> Nueva Novedad</a>

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
                        <h4 class="card-title">Novedades</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th>Opciones</th>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Drescipción</th>
                                        <th>Link</th>
                                        <th>Imagen</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($news as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('novedades', [$item->encode_id,'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('novedades',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>
                                        </td>

                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->link }}</td>
                                        <td><img style="max-height: 70px;" src="{{ asset('images/news/'.$item->image.'') }}" alt="Imagen"></td>
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
        title: 'Seguro que desea eliminar la novedad?',
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
                    'Novedad eliminada correctamente',
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


