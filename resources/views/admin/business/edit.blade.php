@extends('layouts.admin')

@section('title', 'Empresas')
@section('page_title', 'Editar Empresa')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar Empresa</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/empresas">Empresas &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar Empresa</li>
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
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Info empresa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Usuarios</button>
                        </li>                       
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                                <input type="hidden" id="_url" value="{{ url('empresas') }}">
                                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $busine->id }}">
                                <div class="row">                                   
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Razón social *</label>
                                            <input type="text" class="form-control input-cotizacion" name="company_name" id="company_name" value="{{ $busine->company_name }}">
                                            <span class="missing_alert text-danger" id="company_name_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Documento de identificación (NIT) *</label>
                                            <input type="text" class="form-control input-cotizacion" name="nit" id="nit" value="{{ $busine->nit }}">
                                            <span class="missing_alert text-danger" id="nit_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Correo de facturación *</label>
                                            <input type="text" class="form-control input-cotizacion" name="billing_email" id="billing_email" value="{{ $busine->billing_email }}">
                                            <span class="missing_alert text-danger" id="billing_email_alert"></span>
                                        </div>
                                        </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Dirección *</label>
                                            <input type="text" class="form-control input-cotizacion" name="address" id="address" value="{{ $busine->address }}">
                                            <span class="missing_alert text-danger" id="address_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Departamento *</label>
                                            <select name="department_id" id="department_id" class="form-control input-cotizacion" >
                                                <option value="">Seleccione un departamento</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}" {{ ($busine->department_id==$department->id) ? "selected" : "" }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="missing_alert text-danger" id="department_id_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="city_id">Ciudad</label>
                                            <select  id="city_id" name="city_id" class="form-control input-cotizacion" >
                                                <option value="{{ $busine->city_id }}">{{ $busine->cities->name }}</option>
                                            </select>
                                            <span class="missing_alert text-danger" id="city_id_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Asesor*</label>
                                            <select name="user_id" id="user_id" class="form-control input-cotizacion" >
                                                <option value="">Seleccione un Asesor</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}" {{ ($busine->user_id==$item->id) ? "selected" : "" }}>{{ $item->name }} {{ $item->lastname }}</option>
                                                @endforeach
                                            </select>
                                            <span class="missing_alert text-danger" id="user_id_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Termino de pago</label>
                                            <select name="term" id="term" class="form-control input-cotizacion" >
                                                <option value="">Seleccione</option>
                                                <option value="8" {{ ($busine->term=='8') ? "selected" : "" }}>8 días de plazo</option>
                                                <option value="15" {{ ($busine->term=='15') ? "selected" : "" }}>15 días de plazo</option>
                                                <option value="30" {{ ($busine->term=='30') ? "selected" : "" }}>30 días de plazo</option>
                                                <option value="45" {{ ($busine->term=='45') ? "selected" : "" }}>45 días de plazo</option>
                                                <option value="60" {{ ($busine->term=='60') ? "selected" : "" }}>60 días de plazo</option>
                                                
                                            </select>
                                            <span class="missing_alert text-danger" id="term_alert"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
                                </div>
                                
                            </form> 
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-3 header-d" >
                                <div class="flex-grow-1 text-center">
                                    <h2 class="mb-0">Usuarios de {{ $busine->company_name }}</h2>
                                </div>
                                <div class="ms-3">
                                    <button type="button" class="btn btn-success waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario
                                    </button>
                                </div>
                            </div>
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th>#</th>
                                        <th>Acciones</th>
                                        <th>Nombre completo</th>
                                        <th>Usuario</th>
                                        <th>Correo electrónico</th>
                                        <th>Teléfono</th>
                                        <th>Acceso</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($usuariosempresa as $user)
                                    <tr class="odd row{{ $user->id }}">
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @can('Editar Usuario')
                                            <button type="button" class="btn btn-warning edit-user-btn mb-2" data-id="{{ $user->id }}">
                                                <i class="fa fa-edit"></i>                                             </button>
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
        </div>
    </section>
</div>



<!-- Modal XL -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="create-user-form">
        @csrf
        
        <div class="modal-header">
          <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="mb-3">
                <input type="hidden" name="business_id" id="business_id" value="{{ $busine->id }}">
                <div id="business_id_error" class="invalid-feedback"></div>
            </div>
            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="name" class="form-label">Tu nombre completo</label>
                <input id="name" type="text" class="form-control" name="name" required>
                <div class="invalid-feedback" id="name_error"></div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="document" class="form-label">Documento de identificación (CC) *</label>
                <input id="document" type="text" class="form-control" name="document" required>
                <div class="invalid-feedback" id="document_error"></div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="charge" class="form-label">Cargo *</label>
                <input id="charge" type="text" class="form-control" name="charge" required>
                <div class="invalid-feedback" id="charge_error"></div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="phone" class="form-label">Celular</label>
                <input id="phone" type="text" class="form-control" name="phone" required>
                <div class="invalid-feedback" id="phone_error"></div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" required>
                <div class="invalid-feedback" id="email_error"></div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña *</label>
                <div class="input-group">
                  <input id="password" type="password" class="form-control" name="password" required>
                  <span class="input-group-text togglePassword">
                    <i class="fa fa-eye" style="cursor: pointer"></i>
                  </span>
                </div>
                <div class="invalid-feedback" id="password_error"></div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                <div class="input-group">
                  <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                  <span class="input-group-text togglePassword-confirm">
                    <i class="fa fa-eye" style="cursor: pointer"></i>
                  </span>
                </div>
                <div class="invalid-feedback" id="password_confirmation_error"></div>
              </div>
            </div>

          </div> <!-- .row -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="edit-user-form">
      @csrf
      <input type="hidden" name="user_id" id="edit_user_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Campos -->
            <div class="col-md-6 col-12">
              <label for="edit_name" class="form-label">Tu nombre completo</label>
              <input id="edit_name" type="text" class="form-control" name="name" required>
              <div class="invalid-feedback" id="edit_name_error"></div>
            </div>

            <div class="col-md-6 col-12">
              <label for="edit_document" class="form-label">Documento de identificación (CC) *</label>
              <input id="edit_document" type="text" class="form-control" name="document" required>
              <div class="invalid-feedback" id="edit_document_error"></div>
            </div>

            <div class="col-md-6 col-12">
              <label for="edit_charge" class="form-label">Cargo *</label>
              <input id="edit_charge" type="text" class="form-control" name="charge" required>
              <div class="invalid-feedback" id="edit_charge_error"></div>
            </div>

            <div class="col-md-6 col-12">
              <label for="edit_phone" class="form-label">Celular</label>
              <input id="edit_phone" type="text" class="form-control" name="phone" required>
              <div class="invalid-feedback" id="edit_phone_error"></div>
            </div>

            <div class="col-md-6 col-12">
              <label for="edit_email" class="form-label">Correo electrónico</label>
              <input id="edit_email" type="email" class="form-control" name="email" required>
              <div class="invalid-feedback" id="edit_email_error"></div>
            </div>

            <div class="col-md-6 col-12">
              <label for="edit_password" class="form-label">Contraseña *</label>
              <div class="input-group">
                <input id="edit_password" type="password" class="form-control" name="password">
                <span class="input-group-text togglePassword">
                  <i class="fa fa-eye" style="cursor: pointer"></i>
                </span>
              </div>
              <div class="invalid-feedback" id="edit_password_error"></div>
            </div>

            <div class="col-md-6 col-12">
              <label for="edit_password_confirmation" class="form-label">Confirmar Contraseña *</label>
              <div class="input-group">
                <input id="edit_password_confirmation" type="password" class="form-control" name="password_confirmation">
                <span class="input-group-text togglePassword-confirm">
                  <i class="fa fa-eye" style="cursor: pointer"></i>
                </span>
              </div>
              <div class="invalid-feedback" id="edit_password_confirmation_error"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" style="background: #221B6C !important;border-color: #221B6C !important;border-radius: 20px;" class="btn btn-primary" id="send-password-btn">
            Enviar contraseña
          </button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>




@endsection

@push('scripts')
<script src="{{ asset('js/admin/business/edit.js') }}"></script>
<script>

$('#send-password-btn').click(function () {
  const userId = $('#edit_user_id').val();

  $.ajax({
    url: `/send-password/${userId}`,
    type: 'POST',
    data: {
      _token: $('input[name="_token"]').val(), // CSRF token
    },
    success: function (response) {
      _alertGeneric('success', 'Éxito', response.message);
    },
    error: function (xhr) {
      _alertGeneric('error', 'Error', 'No se pudo enviar la contraseña.');
    }
  });
});



    $('.delete-user').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var data=$(e.target).closest('form').serialize();
Swal.fire({
title: 'Seguro que desea el usuario?',
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
            'Usuario eliminado correctamente',
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
    $(document).ready(function () {

// Abrir modal y cargar datos del usuario
$('.edit-user-btn').click(function () {
  const userId = $(this).data('id');

  $.ajax({
    url: `/usuarios/${userId}/edit`, // Ruta que devuelve datos del usuario
    type: 'GET',
    success: function (user) {
      // Rellenar campos
      $('#edit_user_id').val(user.id);
      $('#edit_name').val(user.name);
      $('#edit_document').val(user.document);
      $('#edit_charge').val(user.charge);
      $('#edit_phone').val(user.phone);
      $('#edit_email').val(user.email);
      $('#edit_password').val('');
      $('#edit_password_confirmation').val('');
      $('#send-password-btn').attr('href', `/send-password/${user.id}`);
      // Limpiar errores anteriores
      $('#edit-user-form .form-control').removeClass('is-invalid');
      $('#edit-user-form .invalid-feedback').text('');

      $('#editUserModal').modal('show');
    },
    error: function () {      
      _alertGeneric('error','Error','Error al obtener los datos del usuario.',null);
    }
  });
});

// Enviar formulario AJAX
$('#edit-user-form').submit(function (e) {
  e.preventDefault();

  let userId = $('#edit_user_id').val();
  let formData = new FormData(this);

  // Limpiar errores anteriores
  $('#edit-user-form .form-control').removeClass('is-invalid');
  $('#edit-user-form .invalid-feedback').text('');

  $.ajax({
    url: `/usuarios/${userId}`,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'X-HTTP-Method-Override': 'PUT' // Laravel necesita esto si el formulario usa POST
    },
    success: function () {
      $('#editUserModal').modal('hide');
      _alertGeneric('success','Muy bien! ','Usuario actualizado correctamente.',1);
      location.reload(); // O recarga la tabla si es dinámica
    },
    error: function (xhr) {
      if (xhr.status === 422) {
        let errors = xhr.responseJSON.errors;
        $.each(errors, function (key, messages) {
          $('#edit_' + key).addClass('is-invalid');
          $('#edit_' + key + '_error').text(messages[0]);
        });
      } else {        
        _alertGeneric('error','Error','Error al actualizar el usuario.',null);
      }
    }
  });
});
});

$(document).ready(function () {
    $('#create-user-form').submit(function (e) {
        e.preventDefault();

        // Limpiar errores anteriores
        $('#create-user-form .form-control').removeClass('is-invalid');
        $('#create-user-form .invalid-feedback').text('');

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('usuarios.storeuser') }}",
            method: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Ocultar el modal
                $('#createUserModal').modal('hide');

                // Notificación o mensaje
                _alertGeneric('success','Muy bien! ','Usuario creado correctamente',1);

                // Limpiar formulario
                $('#create-user-form')[0].reset();

                // Aquí podrías actualizar la tabla de usuarios dinámicamente si la tienes
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + '_error').text(value[0]);
                    });
                } else {
                    _alertGeneric('error','Error','Ocurrió un error al guardar el usuario.',null);
                }
            }
        });
    });
});

        
$('#department_id').on('change', function(e){
        var department = e.target.value;
        $.get('/cities/' + department,function(data) {
        $('#city_id').empty();
        $.each(data, function(fetch, city){
            $('#city_id').append('<option value="">Seleccione</option>');
            for(i = 0; i < city.length; i++){
            $('#city_id').append('<option value="'+ city[i].id +'">'+ city[i].name +'</option>');
            }
        })
     })
});
   

 feather.replace({ 'aria-hidden': 'true' });

$(".togglePassword").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".password").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".password").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".password").attr("type","password");
      }
  });

  $(".togglePassword-confirm").click(function (e) {
      e.preventDefault();
      var type = $(this).parent().parent().find(".password-confirm").attr("type");
      if(type == "password"){
          $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
          $(this).parent().parent().find(".password-confirm").attr("type","text");
      }else if(type == "text"){
          $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
          $(this).parent().parent().find(".password-confirm").attr("type","password");
      }
  });

    </script>
<script>
  document.querySelectorAll('.togglePassword').forEach(toggle => {
    toggle.addEventListener('click', () => {
      const input = document.querySelector('#edit_password');
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  });

  document.querySelectorAll('.togglePassword-confirm').forEach(toggle => {
    toggle.addEventListener('click', () => {
      const input = document.querySelector('#edit_password_confirmation');
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  });
</script>

    
@endpush


