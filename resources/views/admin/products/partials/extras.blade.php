<form class="form" role="form" action="javascript:void(0)" method="POST" id="main-form-extra" autocomplete="off">
    <input type="hidden" id="_urlextra" value="{{ url('extras') }}">
    <input type="hidden" id="_tokenextra" value="{{ csrf_token() }}">
    <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="mb-1">
                <label class="form-label" for="display_name">Texto a Mostrar en el select</label>
                <input type="text" class="form-control" id="display_name" name="display_name" >
                <span class="missing_alert text-danger" id="display_name_alert"></span>
            </div>
        </div>
        <h4>Agregar Opciones</h4>
        <div id="main-extras">
            <a href="#" id="btAdd-extras"  class="bt btn-success btn" ><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="#" id="btRemove-extras"  class="bt btn-danger btn" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>                                                  
                                                      
        </div>
        <div class="col-12 mt-3">
            <button  id="btnEnviarExtra" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon-extra" class="fa fa-save"></i> Guardar</button>
        </div>
    </div>
</form>
                   

@push('scripts')

    <script src="{{ asset('js/admin/extras/create.js') }}"></script>
@endpush
