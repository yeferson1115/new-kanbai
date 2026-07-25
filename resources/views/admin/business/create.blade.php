@extends('layouts.admin')

@section('title', 'Empresas')
@section('page_title', 'Agregar Empresa')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nueva Empresa</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/empresas">Empresas &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nueva Empresa</li>
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
                            <button class="nav-link disabled" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Usuarios</button>
                        </li>                       
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                                <input type="hidden" id="_url" value="{{ url('empresas') }}">
                                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                <div class="row">                                   
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Razón social *</label>
                                            <input type="text" class="form-control input-cotizacion" name="company_name" id="company_name" >
                                            <span class="missing_alert text-danger" id="company_name_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Documento de identificación (NIT) *</label>
                                            <input type="text" class="form-control input-cotizacion" name="nit" id="nit" >
                                            <span class="missing_alert text-danger" id="nit_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Correo de facturación *</label>
                                            <input type="text" class="form-control input-cotizacion" name="billing_email" id="billing_email">
                                            <span class="missing_alert text-danger" id="billing_email_alert"></span>
                                        </div>
                                        </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Dirección *</label>
                                            <input type="text" class="form-control input-cotizacion" name="address" id="address">
                                            <span class="missing_alert text-danger" id="address_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Dirección *</label>
                                            <select name="department_id" id="department_id" class="form-control input-cotizacion" >
                                                <option value="">Seleccione un departamento</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="missing_alert text-danger" id="department_id_alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="city_id">Ciudad</label>
                                            <select  id="city_id" name="city_id" class="form-control input-cotizacion" >
                                                <option value="">Seleccione</option>
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
                                                    <option value="{{ $item->id }}" >{{ $item->name }} {{ $item->lastname }}</option>
                                                @endforeach
                                            </select>
                                            <span class="missing_alert text-danger" id="user_id_alert"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Termino de pago</label>
                                            <select name="term" id="term" class="form-control input-cotizacion" >
                                                <option value="">Seleccione</option>
                                                <option value="8">8 días de plazo</option>
                                                <option value="15">15 días de plazo</option>
                                                <option value="30">30 días de plazo</option>
                                                <option value="45">45 días de plazo</option>
                                                <option value="60">60 días de plazo</option>
                                                
                                            </select>
                                            <span class="missing_alert text-danger" id="term_alert"></span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                            </form> 
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                    </div>


                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/business/create.js') }}"></script>
    <script>

$(document).on('click', '#pills-profile-tab.disabled', function (e) {
    e.preventDefault();
    e.stopPropagation();
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




   var input = document.querySelector("#phone");
    window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function(callback) {
        $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "co";
        callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
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
@endpush
