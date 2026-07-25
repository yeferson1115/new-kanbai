@extends('layouts.admin')

@section('title', 'Categorías')
@section('page_title', 'Editar Categoría')
@section('page_subtitle', 'Editar')
@section('content')


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar: {{ $category->name }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/home">Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/categories">Categorías &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Editar: {{ $category->name }}</li>
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
                        <h4 class="card-title">Editar Categoría</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" id="main-form" autocomplete="off" enctype="multipart/form-data">
                            <!--<input type="hidden" id="_url" value="{{ url('categories',[$category->encode_id]) }}">-->
                            <input type="hidden" id="_url" value="{{ route('updatecategory') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $category->encode_id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombres" value="{{ $category->name }}">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="file">Foto</label>
                                        <input type="file" class="form-control" id="file" name="file" >
                                        <img style="max-height: 70px;" src="{{ asset('images/categories/'.$category->file.'') }}" alt="Imagen">
                                        <span class="missing_alert text-danger" id="file_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Menú principal?</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_menu" id="is_menu1" value="1" {{ ($category->is_menu=="1")? "checked" : "" }} >
                                                <label class="form-check-label" for="is_menu1">Si</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_menu" id="is_menu2" value="0" {{ ($category->is_menu=="0")? "checked" : "" }} >
                                                <label class="form-check-label" for="is_menu2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status1" value="1" {{ ($category->state=="1")? "checked" : "" }} >
                                                <label class="form-check-label" for="status1">Activa</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="status2" value="0" {{ ($category->state=="0")? "checked" : "" }} >
                                                <label class="form-check-label" for="status2">Desactivada</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            

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

                                <div class="col-md-6 col-12 mb-4">
                                    <h4>Banners actuales desktop</h4>
                                    <div class='row'>  
                                        @if(count($category->banners)>0)
                                            @foreach($category->banners as $item)
                                                @if($item->type==1)
                                                <div class="col-md-2 col-12">
                                                    <img style="max-width: 100%;" class="mb-1" src="{{ asset('images/categories/banners/'.$item->file.'') }}">
                                                    <form method="POST" action="">
                                                            <div class="form-group">
                                                                <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('categoriesbanner',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                            </div>
                                                    </form>
                                                </div> 
                                                @endif
                                            @endforeach 
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 mb-4">
                                    <h4>Banners actuales Mobile</h4>
                                    <div class='row'>  
                                        @if(count($category->banners)>0)
                                            @foreach($category->banners as $item)
                                                @if($item->type==2)
                                                <div class="col-md-2 col-12">
                                                    <img style="max-width: 100%;" class="mb-1" src="{{ asset('images/categories/banners/'.$item->file.'') }}">
                                                    <form method="POST" action="">
                                                            <div class="form-group">
                                                                <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('categoriesbanner',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                            </div>
                                                    </form>
                                                </div> 
                                                @endif
                                            @endforeach 
                                        @endif
                                    </div>
                                </div>
                                

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save"></i> Actualizar</button>
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

    <script src="{{ asset('js/admin/categories/edit.js') }}"></script>
    <script>
        
$(document).ready(function(){

// Add new element
    $(".add").click(function(){
        // Finding total number of elements added
        var total_element = $(".element").length;
        // last <div> with element class id
        var lastid = $(".element:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 10-{{count($category->banners)}};
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
        var max = 10-{{count($category->banners)}};
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

$('.delete-user').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var data=$(e.target).closest('form').serialize();
Swal.fire({
title: 'Seguro que desea eliminar la imagen?',
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
            'Imagen eliminada correctamente',
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
