@extends('layouts.admin')
@section('title','Banners')
@section('page_title', 'Listado de Banners')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Banners</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Banners</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @can('Crear Banners')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <a href="{{ url('banners/create') }}" class="btn btn-success waves-effect waves-float waves-light"><i class="fa fa-folder-o" aria-hidden="true"></i> Crear banner</a>

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
                        <h4 class="card-title">Banners</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting" >Opciones</th>
                                        <th class="sorting" >#</th>
                                        <th class="sorting" >Imagen Desktop</th>
                                        <th class="sorting" >URL Desktop</th>
                                        <th class="sorting" >Imagen Mobile</th>
                                        <th class="sorting" >URL Mobile</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($banners as $item)
                                    <tr class="odd row{{ $item->id }}">                                        
                                        <td>
                                        <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ url('banners', [$item->encode_id,'edit']) }}" title="Editar"><i data-feather='edit-3'></i> </a>
                                            <form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('banners',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>
                                        </td>

                                        <td>{{ $item->id }}</td>
                                        <td><img class="image-container" style="border: 1px solid #AAA;padding: 5px;border-radius: 5px;max-width: 140px;float: left;margin-right: 10px;" src="{{ asset('images/banners/desktop/'.$item->imagedesk) }}" alt=""></td>
                                        <td>{{ $item->url_desk }}</td>
                                        <td><img class="image-container" style="border: 1px solid #AAA;padding: 5px;border-radius: 5px;max-width: 140px;float: left;margin-right: 10px;" src="{{ asset('images/banners/mobile/'.$item->imagemobile) }}" alt=""></td>
                                        <td>{{ $item->url_mobile }}</td>
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
        title: 'Seguro que desea eliminar el Banner?',        
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
                    'Banner eliminado correctamente',
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


