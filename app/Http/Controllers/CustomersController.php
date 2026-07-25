<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\Departaments;
use App\Models\Cities;
use App\Models\User;

use Illuminate\Support\Facades\DB;

use Vinkla\Hashids\Facades\Hashids;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los Clientes: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $sql = "SELECT c.*,d.name as namedepartement, ci.name as namecity FROM customers c inner join departaments d on c.departament_id=d.id
        inner join cities ci on ci.id=c.city_id ";
        $customers = DB::select($sql);
        return view ('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depto = new Departaments();
        $deptos=$depto->all();

        return view ('admin.customers.create',compact('deptos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customers = Customers::create($request->all());

        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha guardado nuevo cliente en sistema: '.$request->name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true, 'user_id' => $customers->encode_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customers::find(\Hashids::decode($id)[0]);

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos del cliente: '.$customer->display_name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $depto = new Departaments();
        $deptos=$depto->all();
        return view('admin.customers.edit', ['customer' => $customer,'deptos' => $deptos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customers = Customers::find(\Hashids::decode($id)[0]);
        $customers->first_name = $request->first_name;
        $customers->last_name = $request->last_name;
        $customers->type = $request->type;
        $customers->identification_type = $request->identification_type;
        $customers->identification = $request->identification;
        $customers->regimen = $request->regimen;
        $customers->departament_id = $request->departament_id;
        $customers->city_id = $request->city_id;
        $customers->phone = $request->phone;
        $customers->email = $request->email;
        $customers->address_line = $request->address_line;


        $customers->save();

        return json_encode(['success' => true, 'campuse_id' => $customers->encode_id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
    }

    public function cities($departament_id)
    {

        $cities = Cities::where('departament_id', $departament_id)->get();

        return with(["cities" => $cities]);
    }

    public function register(){
        $depto = new Departaments();
        $deptos=$depto->all();

        return view ('app.customers.register',compact('deptos'));
    }

    public function registercustomer(Request $request)
    {
        try {
        $validated = $request->validate([
            'identification' => ['required', 'numeric', 'unique:customers'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers','unique:users'],  
            'username' => ['required', 'string', 'max:255', 'unique:users'],         
        ],[
            'identification.unique'=>'El número de identificación ya se encuentra registrado',
            'username.unique'=>'El nombre de usuario ya se encuentra registrado'
        ]);

        $user=User::create([
            'name'=>$request->first_name,
            'lastname'=>$request->last_name,
            'document'=>$request->identification,
            'username'=>$request->username,
            'genero'=>$request->genero,
            'email'=>$request->email,
            'password'=>$request->password,
            'campuse_id'=>1,
            'status'=>1
        ]);
        $user->assignRole(2);
        $customer = new Customers();
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->type = $request->type;
        $customer->identification = $request->identification;
        $customer->identification_type = $request->identification_type;
        $customer->address_line = $request->address_line;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->departament_id = $request->departament_id;
        $customer->city_id = $request->city_id;
        $customer->user_id = $user->id;       
        $customer->save();
        return json_encode(['success' => true, 'customer_id' => $customer->encode_id]);
     

        }catch (exception $e) {
           
        }
    }
    public function validaremail(Request $request)
    {

        try {
            $validated = $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:customers','unique:users']      
            ]);
            return json_encode(['success' => true, 'customer_id' => 1]);
    
            }catch (exception $e) {
               
            }
    }
}
