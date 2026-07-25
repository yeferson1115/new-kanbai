@extends('layouts.admin')

@section('title', 'Categorías')
@section('page_title', 'Agregar Categoría')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nueva Categoría</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/categories">Categorías &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nueva Categoría</li>
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
                        <h4 class="card-title">Crear Categoría</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('categories') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre Servicio">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="file">Imagen</label>
                                        <input type="file" class="form-control" id="file" name="file" >
                                        <span class="missing_alert text-danger" id="file_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Menú principal?</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_menu" id="is_menu1" value="1"  >
                                                <label class="form-check-label" for="is_menu1">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_menu" id="is_menu2" value="0" >
                                                <label class="form-check-label" for="is_menu2">No</label>
                                            </div>
                                        </div>
                                        <span class="missing_alert text-danger" id="is_menu_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status1" value="1">
                                                <label class="form-check-label" for="status1">Activada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status2" value="0">
                                                <label class="form-check-label" for="status2">Desactivada</label>
                                            </div>
                                        </div>
                                        <span class="missing_alert text-danger" id="state_alert"></span>
                                    </div>
                                </div>
                                
                                
                                <div class="accordion mb-5 mt-5" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button style="background: #e7e7e7;" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                Banners
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">                                                   
                                                <div class="row">
                                                    <div class="col-md-6 col-12">                                    
                                                        <div class="container mb-3 mt-3" style="padding: 0px;" >
                                                            <h4>Cargar Banners desktop</h4>
                                                            <div class='element row' id='div_1'>                                        
                                                                <div class="col-md-8 col-12">
                                                                    <label class="form-label" for="banners">Banner</label>
                                                                    <input type="file" class="form-control" id="banners" name="banners[]" >
                                                                    <label class="form-label" for="banners">Link Banner</label>
                                                                    <input type="text" class="form-control" id="links" name="links[]" >
                                                                    <span class="missing_alert text-danger" id="banners_alert"></span>
                                                                </div>
                                                                <div class="col-md-4 col-12 pt-2 ">                                           
                                                                    <a href="#" title="Agregar" class="btn btn-success add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">                                    
                                                        <div class="container mb-3 mt-3" style="padding: 0px;" >
                                                            <h4>Cargar Banners Mobile</h4>
                                                            <div class='elementmobile row' id='divmobile_1'>                                        
                                                                <div class="col-md-8 col-12">
                                                                    <label class="form-label" for="banners">Banner Mobile</label>
                                                                    <input type="file" class="form-control" id="banners" name="bannersmobile[]" >
                                                                    <label class="form-label" for="linksmobile">Link Banner Mobile</label>
                                                                    <input type="text" class="form-control" id="linksmobile" name="linksmobile[]" >
                                                                    <span class="missing_alert text-danger" id="banners_alert"></span>
                                                                </div>
                                                                <div class="col-md-4 col-12 pt-2 ">                                           
                                                                    <a href="#" title="Agregar" class="btn btn-success addmobile"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button style="background: #e7e7e7;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Banners publicidad
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                
                                               <div class="row">
                                                    <div class="col-md-6 col-12"> 
                                                        <div class="container mb-3 mt-3" style="padding: 0px;" >
                                                            <h4>Cargar banner publicidad desktop</h4>
                                                            <div class='elementp row' id='divpublicidad_1'> 
                                                                <div class="col-md-8 col-12">
                                                                    <label class="form-label" for="banners">Banner</label>
                                                                    <input type="file" class="form-control" id="banners" name="bannersp[]" >
                                                                    <label class="form-label" for="banners">Link Banner</label>
                                                                    <input type="text" class="form-control" id="links" name="linksp[]" >
                                                                    <span class="missing_alert text-danger" id="banners_alert"></span>
                                                                </div>
                                                                <div class="col-md-4 col-12 pt-2 ">
                                                                    <a href="#" title="Agregar" class="btn btn-success addpublicidad"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="container mb-3 mt-3" style="padding: 0px;" >
                                                            <h4>Cargar banner publicidad mobile</h4>
                                                            <div class='elementmobilep row' id='divmobilep_1'>
                                                                <div class="col-md-8 col-12">
                                                                    <label class="form-label" for="banners">Banner Mobile</label>
                                                                    <input type="file" class="form-control" id="banners" name="bannersmobilep[]" >
                                                                    <label class="form-label" for="linksmobile">Link Banner Mobile</label>
                                                                    <input type="text" class="form-control" id="linksmobile" name="linksmobilep[]" >
                                                                    <span class="missing_alert text-danger" id="banners_alert"></span>
                                                                </div>
                                                                <div class="col-md-4 col-12 pt-2 ">
                                                                    <a href="#" title="Agregar" class="btn btn-success addmobilep"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTree">
                                            <button style="background: #e7e7e7;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTree" aria-expanded="false" aria-controls="collapseTree">
                                                Imagenes de atrubutos
                                            </button>
                                        </h2>
                                        <div id="collapseTree" class="accordion-collapse collapse" aria-labelledby="headingTree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                               <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="container mb-3 mt-3" style="padding: 0px;" >
                                                            <h4>Cargar imagenes de atributos</h4>
                                                            <div class='elementa row' id='divatributo_1'> 
                                                                <div class="col-md-8 col-12">
                                                                    <label class="form-label" for="atributo">Imagen</label>
                                                                    <input type="file" class="form-control" id="atributo" name="atributo[]" >
                                                                    <label class="form-label" for="title">Titulo</label>
                                                                    <input type="text" class="form-control" id="title" name="title[]" >
                                                                    <span class="missing_alert text-danger" id="atributo_alert"></span>
                                                                </div>
                                                                <div class="col-md-4 col-12 pt-2 ">
                                                                    <a href="#" title="Agregar" class="btn btn-success addatributo"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                               </div>
                                            </div>
                                        </div>
                                    </div>
 
 
                                </div>
                                
                              

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

    <script src="{{ asset('js/admin/categories/create.js') }}"></script>
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
    </script>
@endpush
