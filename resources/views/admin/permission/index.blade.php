@extends('layouts.admin')

@section('title', 'Permisos')
@section('page_title', 'Permisos')


@section('content')

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-line-primary">
            <div class="card-header">
                <h5 class="font-weight-bold">Permisos del rol {{ $name }}</h5>
                <div class="card-tools"></div>
              </div>
              <div class="card-body">
               <form role="form" id="main-form">
                <input type="hidden" id="_url" value="{{ url('permission', [$name]) }}">
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="row">
                    @foreach ($permissions as $item)
                    <div class="col-md-4 col-12">
                        <div class="mb-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="permissions{{ $item->id }}" value="{{ $item->name }}" {{ $role->hasPermissionTo($item->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permissions{{ $item->id }}">{{ $item->name }}</label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                  <div class="form-group pading">
                     <label for="name">Contraseña actual</label>
                     <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Contraseña actual">
                     <span class="missing_alert text-danger" id="current_password_alert"></span>
                    </div>
                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit">
                      <i id="ajax-icon" class="fa fa-edit"></i> Editar
                    </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection

@push('scripts')
 <script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
 </script>
  <script src="{{ asset('js/admin/permission/index.js') }}"></script>
@endpush
