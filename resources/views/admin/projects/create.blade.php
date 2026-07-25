@extends('layouts.admin')

@section('title', 'Proyectos')
@section('page_title', 'Agregar Proyecto')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nueva Proyecto</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/projects">Proyectos &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nueva Proyecto</li>
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
                    <div class="card-header">
                        <h4 class="card-title">Crear Proyecto</h4>
                    </div>
                    <div class="card-body mt-4">
                        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('project') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="no_project">Número Proyecto</label>
                                        <input type="text" class="form-control" id="no_project" name="no_project" >
                                        <span class="missing_alert text-danger" id="no_project_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="customer">Cliente</label>
                                        <input type="text" class="form-control" id="customer" name="customer" >
                                        <span class="missing_alert text-danger" id="customer_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="date_shopping">Fecha Entrega</label>
                                        <input type="date" class="form-control" id="date_shopping" name="date_shopping" >
                                        <span class="missing_alert text-danger" id="date_shopping_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="bussine_id">Comercio</label>
                                        <select  id="bussine_id" name="bussine_id" class="form-control">
                                            <option value="">Seleccione Comercio</option>
                                            @foreach( $comercios as $key => $value )
                                            <option value="{{ $value->id }}" >{{ $value->company_name }}</option>
                                            @endforeach
                                        </select>                                        
                                        <span class="missing_alert text-danger" id="bussine_id_alert"></span>
                                    </div>
                                </div>                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email_customer">Correo Cliente</label>
                                        <input type="email" class="form-control" id="email_customer" name="email_customer" >
                                        <span class="missing_alert text-danger" id="email_customer_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email_customer2">Correo Cliente 2</label>
                                        <input type="email" class="form-control" id="email_customer2" name="email_customer2" >
                                        <span class="missing_alert text-danger" id="email_customer2_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="seller_id">Vendedor</label>
                                        <select  id="seller_id" name="seller_id" class="form-control">
                                            <option value="">Seleccione Vendedor</option>
                                            @foreach( $vendedores as $key => $value )
                                            <option value="{{ $value->id }}" >{{ $value->name }} {{ $value->lastname }}</option>
                                            @endforeach
                                        </select>                                        
                                        <span class="missing_alert text-danger" id="seller_id_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="asesor">Asesor Encargado</label>
                                        <select class="form-select" id="asesor" name="asesor">
                                            <option value="">Seleccione</option>
                                            @foreach ($asesores as $asesor)
                                                <option value="{{ $asesor->name }} {{ $asesor->lastname }}">{{ $asesor->name }} {{ $asesor->lastname }}</option>
                                            @endforeach
                                        </select>                                        
                                        <span class="missing_alert text-danger" id="asesor_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone_asesor">Teléfono Asesor</label>
                                        <input type="text" class="form-control" id="phone_asesor" name="phone_asesor" >
                                        <span class="missing_alert text-danger" id="phone_asesor_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="email_asesor">Email Asesor</label>
                                        <input type="text" class="form-control" id="email_asesor" name="email_asesor" >
                                        <span class="missing_alert text-danger" id="email_asesor_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12 mb-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="information_shopping">Información de envío</label>
                                        <textarea  class="form-control" id="information_shopping" name="information_shopping" ></textarea>
                                        <span class="missing_alert text-danger" id="information_shopping_alert"></span>
                                    </div>
                                </div>

                                
                                <hr>
                                <div id="main-escala" class="row mb-3 mt-3">
                                    <div class="col-6">
                                        <input type="button" id="btnaddescala" value="Nuevo Producto" class="bt btn-primary btn" />
                                    </div>
                                    <div class="col-6">
                                        <input type="button" id="btnremoveescala" value="Eliminar Producto" class="bt btn-warning btn" />
                                    </div>
                                </div>
                                <div class="row" id="escalas-precios"> </div>


                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')

    <script src="{{ asset('js/admin/project/create.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('seller_id');
        const input = document.getElementById('asesor');

        select.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            input.value = selectedOption.text !== 'Seleccione Vendedor' ? selectedOption.text : '';
        });
    });
</script>



    <script>
      
      $(document).ready(function(){

        $(".addatributo").click(function(){
        // Finding total number of elements added
        var total_element = $(".elementa").length;
        // last <div> with element class id
        var lastid = $(".elementa:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 10;
        // Check total number elements
        if(total_element < max ){
        // Adding new div container after last occurance of element class
        $(".elementa:last").after("<div class='elementa row' id='divatributo_"+ nextindex +"'></div>");
        // Adding element to <div>
        $("#divatributo_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="imagen">Imagen</label><input type="file" name="atributo[]"  class="form-control" placeholder="xxxx" id="txt_1" ><label class="form-label" for="title">Titulo</label><input type="text" class="form-control" id="title" name="title[]" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="removep_'+nextindex+'" class="btn btn-danger removea" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

        }

    });
    // Remove element
    $('.container').on('click','.removea',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        // Remove <div> with id
        $("#divatributo_" + deleteindex).remove();
    });
        
    $(".addpublicidad").click(function(){
        // Finding total number of elements added
        var total_element = $(".elementp").length;
        // last <div> with element class id
        var lastid = $(".elementp:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 10;
        // Check total number elements
        if(total_element < max ){
        // Adding new div container after last occurance of element class
        $(".elementp:last").after("<div class='elementp row' id='divpublicidad_"+ nextindex +"'></div>");
        // Adding element to <div>
        $("#divpublicidad_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="banners">Banner</label><input type="file" name="bannersp[]"  class="form-control" placeholder="xxxx" id="txt_1" ><label class="form-label" for="banners">Link Banner</label><input type="text" class="form-control" id="links" name="linksp[]" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="removep_'+nextindex+'" class="btn btn-danger removep" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

        }

    });
    // Remove element
    $('.container').on('click','.removep',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        // Remove <div> with id
        $("#divpublicidad_" + deleteindex).remove();
    });

    $(".addmobilep").click(function(){
        // Finding total number of elements added
        var total_element = $(".elementmobilep").length;
        // last <div> with element class id
        var lastid = $(".elementmobilep:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 10;
        // Check total number elements
        if(total_element < max ){
        // Adding new div container after last occurance of element class
        $(".elementmobilep:last").after("<div class='elementmobilep row' id='divmobilep_"+ nextindex +"'></div>");
        // Adding element to <div>
        $("#divmobilep_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="banners">Banner Mobile</label><input type="file" name="bannersmobilep[]"  class="form-control" placeholder="xxxx" id="txt_1" ><label class="form-label" for="linksmobile">Link Banner Mobile</label><input type="text" class="form-control" id="linksmobile" name="linksmobilep[]" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="removemobilep_'+nextindex+'" class="btn btn-danger removemobilep" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

        }

    });

    $('.container').on('click','.removemobilep',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        // Remove <div> with id
        $("#divmobilep_" + deleteindex).remove();
    });

// Add new element
    $(".add").click(function(){
        // Finding total number of elements added
        var total_element = $(".element").length;
        // last <div> with element class id
        var lastid = $(".element:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 10;
        // Check total number elements
        if(total_element < max ){
        // Adding new div container after last occurance of element class
        $(".element:last").after("<div class='element row' id='div_"+ nextindex +"'></div>");
        // Adding element to <div>
        $("#div_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="banners">Banner</label><input type="file" name="banners[]"  class="form-control" placeholder="xxxx" id="txt_1" ><label class="form-label" for="banners">Link Banner</label><input type="text" class="form-control" id="links" name="links[]" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="remove_'+nextindex+'" class="btn btn-danger remove" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

        }

    });

// Remove element
    $('.container').on('click','.remove',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        // Remove <div> with id
        $("#div_" + deleteindex).remove();
    }); 


    $(".addmobile").click(function(){
        // Finding total number of elements added
        var total_element = $(".elementmobile").length;
        // last <div> with element class id
        var lastid = $(".elementmobile:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 10;
        // Check total number elements
        if(total_element < max ){
        // Adding new div container after last occurance of element class
        $(".elementmobile:last").after("<div class='elementmobile row' id='divmobile_"+ nextindex +"'></div>");
        // Adding element to <div>
        $("#divmobile_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="banners">Banner Mobile</label><input type="file" name="bannersmobile[]"  class="form-control" placeholder="xxxx" id="txt_1" ><label class="form-label" for="linksmobile">Link Banner Mobile</label><input type="text" class="form-control" id="linksmobile" name="linksmobile[]" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="removemobile_'+nextindex+'" class="btn btn-danger removemobile" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

        }

    });

// Remove element
    $('.container').on('click','.removemobile',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        // Remove <div> with id
        $("#divmobile_" + deleteindex).remove();
    }); 

});



$(document).ready(function() {
    var escalas = 0;

    // Crear un elemento div añadiendo estilos CSS
    var containerescala = $(document.createElement('div'));

        $('#btnaddescala').click(function() {
            if (escalas <= 10) {
                escalas = escalas + 1;
                // Añadir caja de texto.
                $(containerescala).append('<div class="row" id="escp'+escalas+'"><div class="col-md-3 col-12"><div class="mb-1">'+
                '<label class="form-label" for="producto">Producto</label><input type="text" class="form-control" id="producto" name="producto[]" >'+
                '<span class="missing_alert text-danger" id="producto_alert"></span></div></div>'+
                '<div class="col-md-3 col-12"><div class="mb-1"><label class="form-label" for="price">Precio</label>'+
                '<input type="number" class="form-control" id="price" name="price[]">'+
                '<span class="missing_alert text-danger" id="price_alert"></span></div></div>'+
                '<div class="col-md-3 col-12"><div class="mb-1"><label class="form-label" for="quantity">Cantidad</label>'+
                '<input type="number" class="form-control" id="quantity" name="quantity[]">'+
                '<span class="missing_alert text-danger" id="quantity_alert"></span></div></div><div class="col-md-3 col-12"><div class="mb-1"><label class="form-label" for="imagen">Imagen</label><input type="file" class="form-control" id="imagen" name="imagen[]" ><span class="missing_alert text-danger" id="imagen_alert"></span></div></div></div>');                            
               

            $('#escalas-precios').after(containerescala); 
            }else{

                $('.limit').remove();
                $(containerescala).append('<label class="limit">Limite Alcanzado</label>'); 
                //$('#btnaddescala').attr('disabled', 'disabled');

            }
        });

        $('#btnremoveescala').click(function() {   // Elimina un elemento por click
            if (escalas != 0) { $('#escp' + escalas).remove(); escalas = escalas - 1; }
        
            if (escalas == 0) { $(containerescala).empty(); 
        
                $(containerescala).remove(); 
                //$('#btnaddescala').removeAttr('disabled'); 

            }
        });

       
    });
    </script>
@endpush
