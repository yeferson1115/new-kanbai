<div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th>Opciones</th>
                                        <th>#</th>
                                        <th>Estado</th>
                                        <th>Producto</th>
                                        <th>Enviado desde</th>
                                        <th>Precio unidad</th>
                                        <th>Cantidad</th>
                                        <th>Envio</th>
                                        <th>Fecha de entrega</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                           
                                            <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('project', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>
                                            <!--<form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('solicitud-personalizada',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>-->
                                        </td>
                                        <td>{{ $item->id }}</td> 
                                        <td>
                                        @if($item->state==1) <span class="badge  text-white bg-warning">En Ejecución</span> @endif
                                        @if($item->state==9) <span class="badge  text-white bg-success">Finalizado</span> @endif
                                        @if($item->state==2) <span class="badge  text-white bg-danger">Cancelado</span> @endif</td>

                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->ubication }}</td>
                                        <td>${{number_format($item->price, 0, 0, '.')}}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{number_format($item->price_delivery, 0, 0, '.')}}</td>
                                        <td>{{ $item->delivery_date }}</td>   

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>