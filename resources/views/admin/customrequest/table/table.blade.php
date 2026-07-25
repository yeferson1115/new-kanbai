<div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th>Opciones</th>
                                        <th>#</th>
                                        <th>Estado</th>
                                        <th>Categoría</th>
                                        <th>E-mail</th>
                                        <th>Teléfono</th>
                                        <th>Nombre</th>
                                        <th>Nombre empresa</th>
                                        <th>Cantidad</th>
                                        <th>Fecha de entrega</th>
                                        <th>Presupuesto por unidad</th>
                                        <th>Forma de entrega</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>
                                           
                                            <a  class="mb-1 btn btn-admin-quotation waves-effect waves-float waves-light" href="{{ url('solicitud-personalizada', [$item->encode_id,'edit']) }}" title="Editar">Gestionar </a>
                                            <!--<form method="POST" action="">

                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('solicitud-personalizada',[$item->encode_id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i data-feather='trash-2'></i></button>
                                                </div>
                                            </form>-->
                                        </td>
                                        <td>P{{ $item->id }}</td> 
                                        <td>@if($item->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                                        @if($item->state==1) <span class="badge  text-white bg-success">En Ejecución</span> @endif
                                        @if($item->state==9) <span class="badge  text-white bg-success">Finalizado</span> @endif
                                        @if($item->state==2) <span class="badge  text-white bg-danger">Cancelado</span> @endif
                                        @if($item->state==3) <span class="badge  text-white bg-info">Ganada</span> @endif</td>

                                                                               
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->cellphone }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_business }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->date_delivery }}</td>
                                        <td>{{ $item->budget_unit }}</td>
                                        <td>{{ $item->delivery_method }}</td>
                                        <td>{{ $item->observations }}</td>
                                      
                                        

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>