@extends('layouts.admin')
@section('title','Listado de Solicitudes personalizadas')
@section('page_title', 'Listado de Solicitudes personalizadas')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Solicitudes Personalizadas</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Solicitudes Personalizadas</li>
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
                            <button class="nav-link" id="pills-espera-tab" data-bs-toggle="pill" data-bs-target="#pills-espera" type="button" role="tab" aria-controls="pills-espera" aria-selected="false">Solicitudes en espera: {{count($cespera)}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-canseladas-tab" data-bs-toggle="pill" data-bs-target="#pills-canseladas" type="button" role="tab" aria-controls="pills-canseladas" aria-selected="false">Solicitudes en ejecucion: {{count($cejecucion)}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-aprobadas-tab" data-bs-toggle="pill" data-bs-target="#pills-aprobadas" type="button" role="tab" aria-controls="pills-aprobadas" aria-selected="false">Solicitudes finalizados: {{count($cfinalizadas)}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-ejecucion-tab" data-bs-toggle="pill" data-bs-target="#pills-ejecucion" type="button" role="tab" aria-controls="pills-ejecucion" aria-selected="false">Solicitudes canceladas: {{count($ccancelados)}}</button>
                        </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">

                        @include('admin.customrequest.table.table',['data'=>$customrequest])

                        </div>
                        <div class="tab-pane fade" id="pills-espera" role="tabpanel" aria-labelledby="pills-espera-tab">

                        @include('admin.customrequest.table.table',['data'=>$cespera])

                        </div>
                        <div class="tab-pane fade" id="pills-canseladas" role="tabpanel" aria-labelledby="pills-canseladas-tab">

                        @include('admin.customrequest.table.table',['data'=>$cejecucion])

                        </div>
                        <div class="tab-pane fade" id="pills-aprobadas" role="tabpanel" aria-labelledby="pills-aprobadas-tab">
                       
                            @include('admin.customrequest.table.table',['data'=>$cfinalizadas])

                        </div>
                        <div class="tab-pane fade" id="pills-ejecucion" role="tabpanel" aria-labelledby="pills-ejecucion-tab">
                       
                            @include('admin.customrequest.table.table',['data'=>$ccancelados])
                            
                        </div>

                        </div>
                    </div>

                    
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Solicitudes Personalizadas</h4>
                    </div>
                    <div class="card-body">
                   
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
        title: 'Seguro Que Desea Eliminar La Solicitud Personalizada?',
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
                    'Solicitud personalizada eliminada correctamente',
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


