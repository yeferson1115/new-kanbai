@extends('layouts.admin')

@section('title', 'Productos')
@section('page_title', 'Agregar Producto')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Nuevo Producto</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/products">Productos &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Nuevo Producto</li>
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
                        <h4 class="card-title">Crear Producto</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <input type="hidden" id="_url" value="{{ url('products') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-7 col-12">
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="name">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name" >
                                            <span class="missing_alert text-danger" id="name_alert"></span>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="delivery_time">Tiempo de entrega</label>
                                                <input type="text" class="form-control" id="delivery_time" name="delivery_time" placeholder="1 día" >
                                                <span class="missing_alert text-danger" id="delivery_time_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="easybuy">Easybuy</label>
                                                <select class="form-control" id="easybuy" name="easybuy" >
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                                <span class="missing_alert text-danger" id="easybuy_alert"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="description">Descripción</label>
                                                <textarea  name="description" class="ckeditor" id="description" rows="10" cols="80"></textarea>
                                                <span class="missing_alert text-danger" id="description_alert"></span>
                                            </div>
                                        </div> 
                                    </div>

                                    <div id="main" class="mb-5">
                                        <input type="button" id="btAdd" value="Agregar pregunta frecuente" class="bt btn-success btn" />
                                        <input type="button" id="btRemove" value="Eliminar pregunta frecuente" class="bt btn-danger btn" />
                                        
                                    </div>


                                    
                                    <h3 class="mt-3">Atributos y variaciones:</h3>
                                    <div class="d-flex align-items-start mt-1">
                                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Color</button>
                                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Tallas</button>
                                            <button class="nav-link" id="v-pills-extras-tab" data-bs-toggle="pill" data-bs-target="#v-pills-extras" type="button" role="tab" aria-controls="v-pills-extras" aria-selected="false">Extras</button>
                                        </div>
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <div id="main-color">
                                                    <a href="#" id="btAdd-color"  class="bt btn-success btn" ><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <a href="#" id="btRemove-color" value="Eliminar pregunta frecuente" class="bt btn-danger btn" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                <div id="main-tallas">
                                                    <a href="#" id="btAdd-tallas"  class="bt btn-success btn" ><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <a href="#" id="btRemove-tallas" value="Eliminar pregunta frecuente" class="bt btn-danger btn" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                   
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-extras" role="tabpanel" aria-labelledby="v-pills-extras-tab">
                                               
                                                <!-- Button trigger modal -->
                                                <button type="button" class="bt btn-success btn" data-bs-toggle="modal" data-bs-target="#modalextra">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>                                                  
                                                <div class="col-md-12" id="extras">
                                                    

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                             

                                <div class="col-md-5 col-12">
                                    <div class="container mb-3" style="padding: 0px;" >
                                        <div class='element row' id='div_1'>                                        
                                            <div class="col-md-8 col-12">
                                                <label class="form-label" for="image">Imagen</label>
                                                <input type="file" class="form-control" id="image" name="image[]" >
                                                <span class="missing_alert text-danger" id="image_alert"></span>
                                            </div>
                                            <div class="col-md-4 col-12 pt-2 ">                                           
                                                <a href="#" title="Agregar" class="btn btn-success add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='row'> 
                                        <div class="col-md-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="iva">Iva</label>
                                                <select class="form-select" id="iva" name="iva" >
                                                    <option value="0" >0%</option>
                                                    <option value="5" >5%</option>
                                                    <option value="19" >19%</option>
                                                </select>
                                                <span class="missing_alert text-danger" id="iva_alert"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="main-escala" class="row mb-3">
                                        <div class="col-6">
                                            <input type="button" id="btnaddescala" value="Nueva Escala de Precios" class="bt btn-primary btn" />
                                        </div>
                                        <div class="col-6">
                                            <input type="button" id="btnremoveescala" value="Eliminar Escala de Precios" class="bt btn-warning btn" />
                                        </div>
                                    </div>
                                    <div class="row" id="escalas-precios"> </div>

                                    <div class='row'> 
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="packaging_unit_quantity">Cantidad unidad de empaque</label>
                                                <input type="text" class="form-control" id="packaging_unit_quantity" name="packaging_unit_quantity">
                                                <span class="missing_alert text-danger" id="packaging_unit_quantity_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="shipping_price">Valor envio de la unidad de empaque</label>
                                                <input type="text" class="form-control" id="shipping_price" name="shipping_price" >
                                                <span class="missing_alert text-danger" id="shipping_price_alert"></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class='row'> 
                                        <div class="col-md-12 col-12">
                                            <label class="form-label" for="Categorias">Categorías</label>
                                            <div class="list-group" id="categories-container">
                                                @foreach ($categories as $item)
                                                    <label class="list-group-item category-item" data-category-name="{{ $item->name }}">
                                                        <input class="form-check-input me-1" type="checkbox" name="category_id[]" value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                        <div class="list-group">
                                                            @foreach ($item->subcategories as $x)
                                                                <label class="list-group-item item-subcategory">
                                                                    <input class="form-check-input me-1" type="checkbox" name="subcategory_id[]" value="{{ $x->id }}">
                                                                    {{ $x->name }}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-12 mt-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="user_id">Vendido por</label>
                                        <select  id="user_id" name="user_id" class="form-control">
                                            @if(!Auth::user()->hasRole('Comercio'))
                                            <option value="" >Seleccione</option>                                            
                                            <option value="1" >Alama de las cosas</option>
                                            @endif
                                            @foreach( $comercios as $key => $value )
                                            <option value="{{ $value->id }}" >{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="missing_alert text-danger" id="user_id_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status1" value="1" checked>
                                                <label class="form-check-label" for="status1">Activa</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status2" value="10" >
                                                <label class="form-check-label" for="status2">Desactivada</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </div>
                              

                                <div class="col-12 mt-3">
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


 <!-- Modal -->
 <div class="modal fade" id="modalextra" tabindex="-1" aria-labelledby="modalextraLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalextraLabel">Agregar Extra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('admin.products.partials.extras',['product_id'=>0])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

    <script src="{{ asset('js/admin/products/create.js') }}"></script>

<script>

    
$(document).ready(function() {
    var iCntcolor = 0;
// Crear un elemento div añadiendo estilos CSS
        var container = $(document.createElement('div'));

        $('#btAdd-color').click(function() {
            if (iCntcolor <= 19) {
                iCntcolor = iCntcolor + 1;
                // Añadir caja de texto.
                $(container).append('<div class="row" id="tb-color'+iCntcolor +'"><div class="col-md-12 col-12"><div class="mb-1"><label class="form-label" for="color">Color</label><input type="color" class="form-control"  name="color[]" ></div></div></div>');

                if (iCntcolor == 1) {   

                var divSubmit = $(document.createElement('div'));
                    

                }

        $('#main-color').after(container, divSubmit); 
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                
                $(container).append('<label>Limite Alcanzado</label>'); 
                $('#btAdd-color').attr('class', 'bt-disable'); 
                $('#btAdd-color').attr('disabled', 'disabled');

            }
        });

        $('#btRemove-color').click(function() {   // Elimina un elemento por click
            if (iCntcolor != 0) { $('#tb-color' + iCntcolor).remove(); iCntcolor = iCntcolor - 1; }
        
            if (iCntcolor == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd-color').removeAttr('disabled'); 
                $('#btAdd-color').attr('class', 'bt btn-success btn') 

            }
        });
        
    });


    $(document).ready(function() {
    var iCnttallas = 0;
// Crear un elemento div añadiendo estilos CSS
        var container = $(document.createElement('div'));

        $('#btAdd-tallas').click(function() {
            if (iCnttallas <= 19) {
                iCnttallas = iCnttallas + 1;
                // Añadir caja de texto.
                $(container).append('<div class="row" id="tb-tallas'+iCnttallas +'"><div class="col-md-12 col-12"><div class="mb-1"><label class="form-label" for="tallas">Talla</label><input type="text" class="form-control"  name="tallas[]" ></div></div></div>');

                if (iCnttallas == 1) {   

                var divSubmit = $(document.createElement('div'));
                    

                }

        $('#main-tallas').after(container, divSubmit); 
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                
                $(container).append('<label>Limite Alcanzado</label>'); 
                $('#btAdd-tallas').attr('class', 'bt-disable'); 
                $('#btAdd-tallas').attr('disabled', 'disabled');

            }
        });

        $('#btRemove-tallas').click(function() {   // Elimina un elemento por click
            if (iCnttallas != 0) { $('#tb-tallas' + iCnttallas).remove(); iCnttallas = iCnttallas - 1; }
        
            if (iCnttallas == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd-tallas').removeAttr('disabled'); 
                $('#btAdd-tallas').attr('class', 'bt btn-success btn') 

            }
        });
        
    });


    $(document).ready(function() {
    var iCntextras = 0;

        $('#btAdd-extras').click(function () {
            if (iCntextras >= 20) {
                alert("Límite de extras alcanzado");
                return;
            }

            iCntextras++;

            // Contenedor principal del extra
            const extraId = "extra_" + iCntextras;

            let html = `
                <div class="card p-2 mb-2" id="${extraId}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <label class="form-label">Nombre Extra</label>
                            <input type="text" class="form-control" name="name_extra[]">
                        </div>
                        <div class="col-md-6 col-12 d-flex align-items-end">
                            <button type="button" class="btn btn-primary btn-sm add-values" data-target="${extraId}">
                                Agregar valores
                            </button>
                        </div>
                    </div>

                    <!-- Contenedor dinámico de valores -->
                    <div class="mt-2 values-container"></div>
                </div>
            `;

            $('#main-extras').append(html);
        });


        $('#btRemove-extras').click(function() {   // Elimina un elemento por click
            if (iCntextras != 0) { $('#tb-extras' + iCntextras).remove(); iCntextras = iCntextras - 1; }
        
            if (iCntextras == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd-extras').removeAttr('disabled'); 
                $('#btAdd-extras').attr('class', 'bt btn-success btn') 

            }
        });
        
    });

    $(document).on("click", ".add-values", function () {

    var parentId = $(this).data("target");
    var container = $("#" + parentId).find(".values-container");

    let html = `
        <div class="row border rounded p-2 mb-2">
            <div class="col-md-3">
                <label class="form-label">Cantidad Min.</label>
                <input type="number" class="form-control" name="qty_min[${parentId}][]">
            </div>

            <div class="col-md-3">
                <label class="form-label">Cantidad Max.</label>
                <input type="number" class="form-control" name="qty_max[${parentId}][]">
            </div>

            <div class="col-md-4">
                <label class="form-label">Precio Extra</label>
                <input type="text" class="form-control" name="price_extra[${parentId}][]">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-value">X</button>
            </div>
        </div>
    `;

    container.append(html);
});

$(document).on("click", ".remove-value", function () {
    $(this).closest(".row").remove();
});



$(document).ready(function() {
    var iCnt = 0;
// Crear un elemento div añadiendo estilos CSS
        var container = $(document.createElement('div'));

        $('#btAdd').click(function() {
            if (iCnt <= 19) {
                iCnt = iCnt + 1;
                // Añadir caja de texto.
                $(container).append('<div class="row" id="tb'+iCnt +'"><div class="col-md-6 col-12"><div class="mb-1"><label class="form-label" for="question">Pegunta</label><input type="text" class="form-control"  name="question[]" ></div></div><div class="col-md-6 col-12"><div class="mb-1"><label class="form-label" for="answer">Respuesta</label><textarea class="form-control"  name="answer[]" ></textarea></div></div></div>');

                if (iCnt == 1) {   

                var divSubmit = $(document.createElement('div'));
                    

                }

        $('#main').after(container, divSubmit); 
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                
                $(container).append('<label>Limite Alcanzado</label>'); 
                $('#btAdd').attr('class', 'bt-disable'); 
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function() {   // Elimina un elemento por click
            if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
        
            if (iCnt == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd').removeAttr('disabled'); 
                $('#btAdd').attr('class', 'bt btn-success btn') 

            }
        });
        
    });

    $(document).ready(function(){

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
  $("#div_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="image">Imagen</label><input type="file" name="image[]"  class="form-control" placeholder="xxxx" id="txt_1" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="remove_'+nextindex+'" class="btn btn-danger remove" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

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
});



$(document).ready(function() {
    var escalas = 0;

    // Crear un elemento div añadiendo estilos CSS
    var containerescala = $(document.createElement('div'));

        $('#btnaddescala').click(function() {
            if (escalas <= 10) {
                escalas = escalas + 1;
                // Añadir caja de texto.
                $(containerescala).append('<div class="row" id="escp'+escalas+'"><div class="col-md-4 col-12"><div class="mb-1">'+
                '<label class="form-label" for="quantity_min_escala">Cantidad Mínima</label><input type="number" class="form-control" id="quantity_min_escala" name="quantity_min_escala[]" placeholder="0" >'+
                '<span class="missing_alert text-danger" id="quantity_min_escala_alert"></span></div></div>'+
                '<div class="col-md-4 col-12"><div class="mb-1"><label class="form-label" for="quantity_max">Cantidad Máxima</label>'+
                '<input type="number" class="form-control" id="quantity_max" name="quantity_max[]" placeholder="10" >'+
                '<span class="missing_alert text-danger" id="quantity_max_alert"></span></div></div>'+
                '<div class="col-md-4 col-12"><div class="mb-1"><label class="form-label" for="price_escala">Precio X Unidad</label>'+
                '<input type="number" class="form-control" id="price_escala" name="price_escala[]" placeholder="70000">'+
                '<span class="missing_alert text-danger" id="price_escala_alert"></span></div></div></div>');                            
               

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

  

$(document).ready(function() {

    function filtrarCategorias() {
        const easybuy = $('#easybuy').val();

        $('.category-item').each(function() {
            const nombre = $(this).data('category-name').trim().toLowerCase();

            if (easybuy == '1') {
                // Mostrar solo EasyGift
                if (nombre === 'easygift') {
                    $(this).show();
                } else {
                    $(this).hide();
                    $(this).find('input[type=checkbox]').prop('checked', false);
                }
            } else {
                // easybuy = 0 → se oculta EasyGift y se muestran las demás
                if (nombre === 'easygift') {
                    $(this).hide();
                    $(this).find('input[type=checkbox]').prop('checked', false);
                } else {
                    $(this).show();
                }
            }
        });
    }

    // Ejecutar al cargar la página
    filtrarCategorias();

    // Ejecutar cada vez que cambie el select easybuy
    $('#easybuy').on('change', filtrarCategorias);
});

</script>

@endpush

