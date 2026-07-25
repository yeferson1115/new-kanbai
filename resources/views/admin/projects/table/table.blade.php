<div class="projects-table-wrapper">
    <div class="row mb-2 g-2 align-items-end">
        @if($easygift==0)
            @can('Crear Proyectos')
                <div class="col-md-auto">
                    <a href="{{ url('project/create') }}" class="btn btn-primary waves-effect waves-float waves-light">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Proyecto
                    </a>
                </div>
            @endcan
        @endif
        <div class="col-md-4">
            <label for="" class="form-label">Filtrar por Asesor:</label>
            <select class="form-select filterAsesor">
                <option value="">Todos</option>
                @foreach ($asesores as $asesor)
                    <option value="{{ $asesor->name }} {{ $asesor->lastname }}">{{ $asesor->name }} {{ $asesor->lastname }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table datatables" >
            <thead class="table-light">
                <tr >
                    <th>Opciones</th>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Metodo de Pago</th>
                    <th>No. Proyecto</th>
                    <th>Cliente</th>
                    <th>Fecha Envio</th>
                    <th>Comercio</th>
                    <th>Email Cliente</th>
                    <th>Asesor</th>
                    <th>Teléfono Asesor</th>
                    <th>Información de Envio</th>
                    <th>Fecha Finalización</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr class="odd row{{ $item->id }}">
                    <td>
                        <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('project', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>

                        @if($easygift==0)
                        <a  class="mb-1 btn btn-manage3 btn-warning  waves-effect waves-float waves-light" href="{{ url('project', [$item->encode_id,'manage']) }}" title="Editar" style="border-radius: 30px;">Editar </a>
                        @endif
                        <form method="POST" action="">

                            <div class="form-group">
                                <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('project',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user" style="border-radius: 30px;">Eliminar</button>
                            </div>
                        </form>
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>
                    @if($item->state==0) <span class="badge  text-white bg-warning">En Ejecución</span> @endif
                    @if($item->state==1) <span class="badge  text-white bg-success">Finalizado</span> @endif
                    @if($item->state==2) <span class="badge  text-white bg-danger">Cancelado</span> @endif
                    @if($item->state==9) <span class="badge  text-white bg-info">Por Completar </span> @endif</td>
                    <td> @if($item->easybuy==1)<span class="badge  text-white bg-success">Easybuy</span> @endif
                        @if($item->easybuy==0)<span class="badge  text-white bg-primary">Proyecto</span> @endif</td>
                    <td>{{ $item->payment_method }}</td>
                    <td>{{ $item->no_project }}</td>
                    <td>{{ $item->customer }}</td>

                    <!--<td>${{number_format($item->price, 0, 0, '.')}}</td>-->
                    <td>{{ $item->date_shopping }}</td>
                    <td>@if($item->comercio){{ $item->comercio->company_name }}@endif</td>
                    <td>{{ $item->email_customer }}</td>
                    <td>{{ $item->asesor }}</td>
                    <td>{{ $item->phone_asesor }}</td>
                    <td>{{ $item->information_shopping }}</td>
                    @if($item->date_finish!=null)
                        <td><span class="badge  text-white bg-danger stado">{{ $item->date_finish }}</span></td>
                        @else
                          <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
