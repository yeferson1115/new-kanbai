<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProductQuotation;
use App\Models\CustomerUser;
use App\Models\Business;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
{
    $authUser = auth()->user();

    // Verificar si el usuario tiene business
    
    if (!$authUser->business) {
        $business = Business::firstOrCreate(
            ['nit' => '000000000'], // condición de búsqueda
            [
                'company_name' => 'kanbai',
                'billing_email' => $authUser->email,
                'address' => 'N/A',
                'department_id' => null,
                'city_id' => null,
                'state' => 1,
                'user_id' => $authUser->id,
                'term' => null
            ]
        );

        // Asignar el business al usuario
        $authUser->business_id = $business->id;
        $authUser->save();
        $authUser->load('business');
    }

    $user = User::with('roles','permissions')->find($authUser->id);

    $busine = Business::with('departaments','cities','asesor')
        ->where('state',1)
        ->find($authUser->business->id);

    $news = News::get();

    $projects = Projects::with(['timeline', 'productos', 'comercio', 'updates'])
        ->where('bussine_id', $authUser->business->id)
        ->get()
        ->map(function ($project) {
            $total = $project->productos->sum(function ($product) {
                return $product->price * $product->quantity;
            });

            $project->total = $total;
            return $project;
        });

    $users = User::with('roles','permissions','business')
        ->where('business_id', $authUser->business_id)
        ->get();

    return view('site.business.index', compact('user','users','busine','news','projects'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('site.business.createuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validación de los campos
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',  // Validar que el correo no exista
        'password' => 'required|string|min:8', // Confirmar contraseña
        'phone' => 'required|string|max:20',  // Validar el teléfono
        'charge' => 'required|string|max:100', // Validar cargo
    ]);

    // Si el correo electrónico es único y la validación es correcta, creamos el usuario
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'username' => $validatedData['email'],  // Suponiendo que username es igual a email
        'password' => Hash::make($validatedData['password']),
        'genero' => null,  // O establecer según la entrada
        'phone' => $validatedData['phone'],
        'charge' => $validatedData['charge'],
        'status' => 1,
        'business_id' => auth()->user()->business->id,
    ]);

    // Asignar un rol al usuario
    $user->assignRole(6);

    // Respuesta en formato JSON
    return response()->json([
        'success' => true,
        'message' => 'Registro exitoso!',
        'redirect_url' => route('login'), // Redirigir al login después del registro
    ]);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('asdasd');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->with('permissions')->find(\Hashids::decode($id)[0]);
        
        return view ('site.business.edituser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function myinformation(){
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        return view ('site.business.myinformation', compact('user'));
    }
    public function usuarios(){
        $users = User::with('roles','permissions','business')->where('business_id',auth()->user()->business_id)
        ->where('id','<>',auth()->user()->id)->get();
        return view ('site.business.users', compact('users'));
    }
    public function myprojects($id){
        $project = Projects::with('timeline','productos','comercio','updates')->find($id);

        $total=0;
        foreach($project->productos as $item){
            $total=$total+($item->price*$item->quantity);
        }
        return view ('site.projects.index', compact('project','total'));
        dd($project);
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        $projects = Projects::with('timeline')->where('user_request_id',auth()->user()->id)->get();
        return view ('site.business.myprojects', compact('user','projects'));
    }

    public function myquotations(){
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        //$productquotation = ProductQuotation::with('producto','producto.gallery','history','user')->where('user_request_id',auth()->user()->id)->get();
        $productquotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->where('user_request_id',auth()->user()->id)->get();
        //dd($productquotation);
        return view ('site.business.myquotations', compact('user','productquotation'));

    }
}
