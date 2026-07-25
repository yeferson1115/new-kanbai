@extends('layouts.admin')
@section('title','Listado de Proyectos')
@section('page_title', 'Listado Proyectos')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">@if($easygift==1) EasyGift @else Proyectos @endif</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">@if($easygift==1) EasyGift @else Proyectos @endif</li>
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
                        <li class="nav-item mb-1" role="presentation">
                            <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">Todos</button>
                        </li>                       
                        <li class="nav-item mb-1" role="presentation">
                            <button class="nav-link" id="pills-canseladas-tab" data-bs-toggle="pill" data-bs-target="#pills-canseladas" type="button" role="tab" aria-controls="pills-canseladas" aria-selected="false">@if($easygift==1) EasyGift @else Proyectos @endif en ejecucion: {{count($ejecucion)}}</button>
                        </li>
                        <li class="nav-item mb-1" role="presentation">
                            <button class="nav-link" id="pills-aprobadas-tab" data-bs-toggle="pill" data-bs-target="#pills-aprobadas" type="button" role="tab" aria-controls="pills-aprobadas" aria-selected="false">@if($easygift==1) EasyGift @else Proyectos @endif finalizados: {{count($finalizadas)}}</button>
                        </li>
                        <li class="nav-item mb-1" role="presentation">
                            <button class="nav-link" id="pills-ejecucion-tab" data-bs-toggle="pill" data-bs-target="#pills-ejecucion" type="button" role="tab" aria-controls="pills-ejecucion" aria-selected="false">@if($easygift==1) EasyGift @else Proyectos @endif cancelados: {{count($cancelados)}}</button>
                        </li>
                        <li class="nav-item mb-1" role="presentation">
                            <button class="nav-link" id="pills-por-completar-tab" data-bs-toggle="pill" data-bs-target="#pills-por-completar" type="button" role="tab" aria-controls="pills-por-completar" aria-selected="false">@if($easygift==1) EasyGift @else Proyectos @endif por completar: {{count($porCompletar)}}</button>
                        </li>
                         <li class="nav-item mb-1 ms-auto" role="presentation">
                            <div class="d-flex gap-2">
                                <!-- Botón de Exportación a Excel -->
                                 @if($easygift==1)
                                <a href="{{ route('projects.export', ['easygift' => $easygift]) }}" 
                                class="btn btn-success waves-effect waves-float waves-light">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel
                                </a>
                                @endif
                            </div>
                        </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">

                        @include('admin.projects.table.table',['data'=>$todos, 'asesores' => $asesores])

                        </div>
                        
                        <div class="tab-pane fade" id="pills-canseladas" role="tabpanel" aria-labelledby="pills-canseladas-tab">

                        @include('admin.projects.table.table',['data'=>$ejecucion, 'asesores' => $asesores])

                        </div>
                        <div class="tab-pane fade" id="pills-aprobadas" role="tabpanel" aria-labelledby="pills-aprobadas-tab">
                       
                            @include('admin.projects.table.table',['data'=>$finalizadas, 'asesores' => $asesores])

                        </div>
                        <div class="tab-pane fade" id="pills-ejecucion" role="tabpanel" aria-labelledby="pills-ejecucion-tab">
                       
                            @include('admin.projects.table.table',['data'=>$cancelados, 'asesores' => $asesores])
                            
                        </div>

                        <div class="tab-pane fade" id="pills-por-completar" role="tabpanel" aria-labelledby="pills-por-completar-tab">
                       
                            @include('admin.projects.table.table',['data'=>$porCompletar, 'asesores' => $asesores])
                            
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

<!-- Modal para editar/gestionar -->
<div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gestionar Proyecto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- aquí se cargará el partial HTML con el formulario -->
        <div id="manageModalBody" class="p-0">Cargando...</div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script src="{{ asset('js/admin/project/manage.js') }}"></script>
<script>

$(document).ready(function () {
    $('.projects-table-wrapper').each(function () {
        var $wrapper = $(this);
        var table = $wrapper.find('.datatables').DataTable();


        $wrapper.find('.filterAsesor').on('change', function () {
            table.column(10).search($(this).val()).draw();
        });
    });
});


    $('.delete-user').click(function(e){

        e.preventDefault();
        var _target=e.target;
        let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
        let token = $(this).attr('data-token');
        var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea eliminar el proyecto?',
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
                    'Proyecto Eliminado Correctamente',
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


