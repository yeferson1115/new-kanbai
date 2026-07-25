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
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="price_min">Precio Mínimo</label>
                                                <input type="number" class="form-control" id="price_min" name="price_min" placeholder="1000000" >
                                                <span class="missing_alert text-danger" id="price_min_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="price_max">Precio Máximo</label>
                                                <input type="number" class="form-control" id="price_max" name="price_max" placeholder="1000000" >
                                                <span class="missing_alert text-danger" id="price_max_alert"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="quantity_min">Cantidad Mínima</label>
                                                <input type="number" class="form-control" id="quantity_min" name="quantity_min" placeholder="10" >
                                                <span class="missing_alert text-danger" id="quantity_min_alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="delivery_time">Tiempo de entrega</label>
                                                <input type="text" class="form-control" id="delivery_time" name="delivery_time" placeholder="1 día" >
                                                <span class="missing_alert text-danger" id="delivery_time_alert"></span>
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
                                            <div class="mb-1">
                                                <label class="form-label" for="shipping_price">Valor Envio</label>
                                                <input type="text" class="form-control" id="shipping_price" name="shipping_price" >
                                                <span class="missing_alert text-danger" id="shipping_price_alert"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'> 
                                        <div class="col-md-12 col-12">
                                            <label class="form-label" for="Categorias">Categorías</label>
                                            <div class="list-group">
                                                @foreach ($categories as $item)
                                                <label class="list-group-item">
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
                                            <option value="" >Seleccione</option>
                                            <option value="1" >Alama de las cosas</option>
                                            @foreach( $comercios as $key => $value )
                                            <option value="{{ $value->id }}" >{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="missing_alert text-danger" id="user_id_alert"></span>
                                    </div>
                                </div>

                                </div>
                              

                                <div class="col-12">
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

    <script src="{{ asset('js/admin/products/create.js') }}"></script>

<script>

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
</script>
@endpush

