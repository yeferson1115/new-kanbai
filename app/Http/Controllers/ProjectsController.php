<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\ProjectTimeLine;
use App\Models\User;
use App\Models\CustomerUser;

use App\Models\Products;
use App\Models\Customers;
use App\Models\ProjectsProducts;
use App\Models\ProjectUpdates;
use App\Models\Business;
use App\Models\UpdateRequest;

use Illuminate\Support\Str;

use App\Models\Log\LogSistema;

use Image;

use Mail;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProjectsController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Proyectos')->only('indexpanel');
        $this->middleware('permission:Editar Proyectos')->only('update');
        $this->middleware('permission:Editar Proyectos')->only('edit');
        $this->middleware('permission:Ver Proyectos')->only('destroy');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        $projects = Projects::with('timeline')->where('user_request_id',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $project = Projects::with('timeline')->find(\Hashids::decode($id)[0]);
//dd($project);
        return view ('site.projects.index', compact('user','projects','project'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexpanel(Request $request)
    {
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los proyectos: '.date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        $isEasyGift = $request->is('easygift');         
        $type = $isEasyGift ? 'easygift' : 'normal';        
         if ($type === 'easygift') {
            $easygift = 1;
        } else {
            $easygift = 0;
        }
       

        $projectsBaseQuery = Projects::with('comercio', 'empresa')->where('easybuy', $easygift);

        if (auth()->user()->hasrole('Comercio')) {
            $projectsBaseQuery->where('seller_id', auth()->user()->id);
        } elseif (auth()->user()->hasrole('Empresa')) {
            $projectsBaseQuery->where('bussine_id', auth()->user()->id);
        }

        $todos = (clone $projectsBaseQuery)->orderBy('created_at', 'desc')->get();
        $ejecucion = $todos->where('state', 0)->values();
        $finalizadas = $todos->where('state', 1)->values();
        $cancelados = $todos->where('state', 2)->values();
        $porCompletar = $todos->where('state', 9)->values();

       
        $relacionEloquent = 'roles';
        $asesores = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Asesor');
        })->get();

        return view('admin.projects.index', compact('todos', 'ejecucion', 'cancelados', 'finalizadas', 'porCompletar', 'asesores', 'easygift'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $comercios = Business::where('state',1)->get();
        $relacionEloquent = 'roles';
        $vendedores = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Comercio');
        })->get();  
        
        $asesores = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Asesor');
        })->get();      
        return view ('admin.projects.create', compact('comercios','vendedores','asesores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{

    $total=0;
    foreach ($request->producto as $key => $item) {
        $total=$total+($request->price[$key]*$request->quantity[$key]);      
    }


    $project = Projects::create([
        'no_project'        => $request->no_project,
        'customer'          => $request->customer,
        'date_shopping'     => $request->date_shopping,
        'bussine_id'        => $request->bussine_id,
        'email_customer'    => $request->email_customer,
        'email_customer2'   => $request->email_customer2,
        'asesor'            => $request->asesor,
        'phone_asesor'      => $request->phone_asesor,
        'information_shopping' => $request->information_shopping,            
        'seller_id'         => $request->seller_id,
        'state'             => 0,
        'total'=>$total
    ]);
    ProjectTimeLine::create([
        'project_id'=>$project->id,
        'description'=>'Pedido en Preparación',
        'file'=>null
    ]);


    // Guardar productos
    if (isset($request->producto)) {
        foreach ($request->producto as $key => $item) {
            $nametem = Str::random(7);
            $imageName = time().'_'.$nametem.'.'.$request->imagen[$key]->extension();
            $request->imagen[$key]->move(public_path('images/custom_request'), $imageName);

            ProjectsProducts::create([
                'producto'   => $item,
                'price'      => $request->price[$key],
                'quantity'   => $request->quantity[$key],
                'imagen'     => $imageName,
                'project_id' => $project->id
            ]);
        }
    }

    // Enviar correo a ambos emails si existen
    Mail::send('admin.projects.templatenewproject', ['project' => $project], function($message) use ($project) {
        $message->to($project->email_customer, $project->customer);

        if (!empty($project->email_customer2)) {
            $message->cc($project->email_customer2);
        }

        $message->subject('Solicitud Kanbai No. '.$project->no_project);
        $message->from('ventas@kanbai.co', 'Kanbai');
    });

    return response()->json(['success' => true, 'id' => $project->id]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Projects::with('timeline','productos','comercio','updates','comercio.asesor')->find(\Hashids::decode($id)[0]);     
        $total=0;

        foreach($project->productos as $item){
            $total=$total+($item->price*$item->quantity);
        }   
        return view ('site.business.detailsproject', compact('project','total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $project = Projects::with('timeline','productos','comercio','updates','productos.color','productos.talla','productos.extras','productos.extras.itemextra','updateRequests.vendedor')
        ->find(\Hashids::decode($id)[0]);
    
    // Buscar solicitudes pendientes
    $updaterequest = UpdateRequest::with('vendedor')
        ->where('project_id', \Hashids::decode($id)[0])
        ->where('estado', 'pendiente')
        ->first();
    
    // Verificar si hay solicitud pendiente y si la fecha límite es mayor a la actual
    $mostrarCronometro = false;
    $tiempoRestante = null;
    $fechaVencimiento = null;
    
    if ($updaterequest && $updaterequest->fecha_limite) {
        $ahora = now();
        $fechaLimite = \Carbon\Carbon::parse($updaterequest->fecha_limite);
        
        if ($fechaLimite->greaterThan($ahora)) {
            $mostrarCronometro = true;
            $fechaVencimiento = $fechaLimite;
            
            // Calcular tiempo restante en segundos
            $tiempoRestante = $ahora->diffInSeconds($fechaLimite, false);
            
            // Si el tiempo es negativo, marcar como vencido
            if ($tiempoRestante < 0) {
                $updaterequest->update(['estado' => 'vencido']);
                $mostrarCronometro = false;
            }
        } else {
            // Fecha límite ya pasó, marcar como vencido
            $updaterequest->update(['estado' => 'vencido']);
        }
    }

    $log = new LogSistema();
    $log->user_id = auth()->user()->id;
    $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la solicitud personalizada: '.$project->id.' a las: '
    . date('H:m:i').' del día: '.date('d/m/Y');
    $log->save();
    
    $categories = Categories::with('subcategories')->get();
    $total=0;
    foreach($project->productos as $item){
        $total=$total+($item->price*$item->quantity);
    }

    $comercios = Business::where('state',1)->get();
    $relacionEloquent = 'roles';
    $vendedores = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Comercio');
        })->get();   
    
    return view('admin.projects.edit', [
        'project' => $project,
        'total' => $total,
        'comercios' => $comercios,
        'vendedores' => $vendedores,
        'updaterequest' => $updaterequest,
        'mostrarCronometro' => $mostrarCronometro,
        'tiempoRestante' => $tiempoRestante,
        'fechaVencimiento' => $fechaVencimiento
    ]);
}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {       
        $CustomRequest = Projects::with('timeline','productos','comercio')->find(\Hashids::decode($request->id)[0]);
        $total=0;
        foreach($CustomRequest->productos as $item){
            $total=$total+($item->price*$item->quantity);
        }
        $CustomRequest->total=$total;
        
        if(isset($request->description)){
            $images=$request->image;
            foreach($request->description as $key=>$item){
                $imageName=null;
                if(isset($images[$key])){
                    $imagen = Image::make($images[$key]);
                    $imageName = time().'_'.$images[$key]->getClientOriginalName().'.'.$images[$key]->extension();
                    $imagen->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(public_path('images/projects/' . $imageName));
                }
                ProjectTimeLine::create([
                    'project_id'=>\Hashids::decode($request->id)[0],
                    'description'=>$item,
                    'file'=>$imageName
                ]);

               
                $newdata=[
                    'description' =>$request->description
                ];

                

                Mail::send('site.projects.templateprojectupdate', ['project' => $CustomRequest,'total'=>$total,'data'=>$newdata], function($message) use ($CustomRequest){
                     $message->to($CustomRequest->email_customer, $CustomRequest->customer);
                     $message->subject('Solicitud Kanbai No. '.$CustomRequest->id);
                     $message->from('ventas@kanbai.co','Kanbai');
                });

               // update
                
            }
        }

        if($request->state){
            $CustomRequest->state = $request->state; 
            if($request->state==1){
                $CustomRequest->date_finish=date('Y-m-d');
            }
        }
         if(($request->confirmed && $request->confirmed=='1') && $request->state==$CustomRequest->state){
            $CustomRequest->state = 0; 
        }
        if($request->bussine_id){
            $CustomRequest->bussine_id = $request->bussine_id; 
        }
        if($request->seller_id){
            $CustomRequest->seller_id = $request->seller_id; 
            $asesor=User::find($request->seller_id);
            $CustomRequest->asesor=$asesor->name.' '.$asesor->lastname;
            $CustomRequest->phone_asesor=$asesor->phone;
        }
        $CustomRequest->save();

        return json_encode(['success' => true, 'campuse_id' => $CustomRequest->encode_id]);
    }

    public function updates(Request $request)
{
    $CustomRequest = Projects::with('timeline', 'productos', 'comercio')
        ->find(\Hashids::decode($request->id)[0]);

    $total = 0;
    foreach ($CustomRequest->productos as $item) {
        $total += ($item->price * $item->quantity);
    }

    if (isset($request->update_text)) {
        $images = $request->file('image_update'); // Mejor usar file() para subir imágenes
        $imageNames = [];

        if ($images) {
            // Si viene una sola imagen, la convertimos en array para tratar igual que múltiples
            if (!is_array($images)) {
                $images = [$images];
            }

            foreach ($images as $image) {
                $imagen = Image::make($image);
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/projects/' . $imageName));

                $imageNames[] = $imageName;
            }
        }

        ProjectUpdates::create([
            'project_id' => \Hashids::decode($request->id)[0],
            'description' => $request->update_text,
            'file' => isset($imageNames[0]) ? $imageNames[0] : null // Guarda solo la primera en DB
        ]);

        $newdata = [
            'description' => $request->update_text
        ];

        // Enviar correo con adjuntos
        Mail::send('site.projects.templateprojectupdate', [
            'project' => $CustomRequest,
            'total' => $total,
            'data' => $newdata
        ], function ($message) use ($CustomRequest, $imageNames) {
            $message->to($CustomRequest->email_customer, $CustomRequest->customer)
                ->subject('Solicitud Kanbai No. ' . $CustomRequest->id)
                ->from('ventas@kanbai.co', 'Kanbai');

            // Adjuntar todas las imágenes
            foreach ($imageNames as $name) {
                $message->attach(public_path('images/projects/' . $name));
            }
        });
    }

    $CustomRequest->state = $request->state;
    $CustomRequest->save();

    return json_encode(['success' => true, 'campuse_id' => $CustomRequest->encode_id]);
}

    public function templateupdate($data=''){
        if($data===''){
                $data=[                
                    'description' => 'Que me lo entrguen yaaaa'                          
                ];
            $project = Projects::with('timeline')->find(3);
            $cliente = Customers::where('id',$project->user_request_id)->first();
            $usuario = User::where('id',$cliente->user_id)->first();
            //$producto = Products::with('productcategories','productcategories.category','gallery','user')->where('id',filter_var(9, FILTER_VALIDATE_INT))->first();
        }
        //$data = array('data'=>$request, 'producto'=>$product);        
        return view ('site.projects.templateprojectupdate', compact('data', 'project', 'cliente','usuario'));
    }


 

public function envios(Request $request)
{
    $request->validate([
        'guia' => 'required|string|max:255',
        'empresa' => 'required|string|max:255',
        'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'videos.*' => 'nullable|mimes:mp4,avi,mov|max:10240',
    ]);
    $project = Projects::with('timeline','productos','comercio')->find(\Hashids::decode($request->project_id)[0]);

    $imagenesPaths = [];
    $videosPaths = [];

    // Crear carpetas si no existen
    if (!file_exists(public_path('images/envios'))) {
        mkdir(public_path('images/envios'), 0777, true);
    }

    if (!file_exists(public_path('images/videos'))) {
        mkdir(public_path('images/videos'), 0777, true);
    }

    // Guardar imágenes
    if ($request->hasFile('imagenes')) {
        foreach ($request->file('imagenes') as $imagen) {
            $filename = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $ruta = 'images/envios/' . $filename;
            $imagen->move(public_path('images/envios'), $filename);
            $imagenesPaths[] = $ruta;
        }
    }

    // Guardar videos
    if ($request->hasFile('videos')) {
        foreach ($request->file('videos') as $video) {
            $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $ruta = 'images/videos/' . $filename;
            $video->move(public_path('images/videos'), $filename);
            $videosPaths[] = $ruta;
        }
    }

    $project->guia = $request->guia;
    $project->empresa = $request->empresa;
    $project->imagenes = $imagenesPaths;
    $project->videos = $videosPaths;
    $project->save();

    ProjectTimeLine::create([
        'project_id'=>\Hashids::decode($request->project_id)[0],
        'description'=>'Pedido Despachado',
        'file'=>null
    ]);

    ProjectUpdates::create([
        'project_id'=>\Hashids::decode($request->project_id)[0],
        'description'=>'Tu pedido ha sido despachado con éxito con número de guía '.$request->guia.' de la empresa transportadora '.$request->empresa.' Adjunto encontrarás la evidencia de despacho. Cualquier inquietud que tengas no dudes en contactar a tu asesor para apoyarte',
        'file'=>null
    ]);

   
    $newdata=[
        'description' =>'Tu pedido ha sido despachado con éxito con número de guía '.$request->guia.' de la empresa transportadora '.$request->empresa.' Adjunto encontrarás la evidencia de despacho. Cualquier inquietud que tengas no dudes en contactar a tu asesor para apoyarte'
    ];

    $total=0;
    foreach($project->productos as $item){
        $total=$total+($item->price*$item->quantity);
    }

    Mail::send('site.projects.templateprojectupdate', ['project' => $project, 'total' => $total, 'data' => $newdata], function ($message) use ($project, $imagenesPaths, $videosPaths) {
        $message->to($project->email_customer, $project->customer);
        $message->subject('Solicitud Kanbai No. ' . $project->id);
        $message->from('solicitud@kanbai.co', 'Kanbai');
    
        // Adjuntar imágenes
        foreach ($imagenesPaths as $imagen) {
            $message->attach(public_path($imagen));
        }
    
        // Adjuntar videos
        foreach ($videosPaths as $video) {
            $message->attach(public_path($video));
        }
    });

    return response()->json(['success' => true]);
}

    public function pedidos()
    {
        $businessId = auth()->user()->business->id;

        $projects = Projects::with(['timeline', 'productos', 'comercio', 'updates'])
            ->where('bussine_id', $businessId)
            ->get()
            ->map(function ($project) {
                $total = $project->productos->sum(function ($product) {
                    return $product->price * $product->quantity;
                });

                $project->total = $total;
                return $project;
            });

        return view('site.business.projects', compact('projects'));
    }

    public function destroy($id)
    {
        $project=Projects::findOrFail(\Hashids::decode($id)[0]);
        ProjectsProducts::where('project_id',$project->id)->delete();
        ProjectTimeLine::where('project_id',$project->id)->delete();
        ProjectUpdates::where('project_id',$project->id)->delete();
        $project->delete();
        return json_encode(['success' => true]);

    }

    public function manage($id)
{
    // decodificar id (Hashids)
    $decoded = \Hashids::decode($id);
    if (!isset($decoded[0])) {
        abort(404);
    }
    $projectId = $decoded[0];

    $project = Projects::with('timeline','productos','comercio','updates')->find($projectId);
    if (!$project) abort(404);

    // datos auxiliares que usa el form
    $comercios = Business::where('state',1)->get();
    $relacionEloquent = 'roles';
    $vendedores = User::whereHas($relacionEloquent, function ($query) {
        return $query->where('name', '=', 'Comercio');
    })->get();

    // calcula total (igual que en edit)
    $total = 0;
    foreach ($project->productos as $item){
        $total += ($item->price * $item->quantity);
    }

    // retorna un partial blade con solo el formulario (ver sección siguiente)
    return view('admin.projects.partials.manage_form', compact('project','comercios','vendedores','total'));
}

public function updateAjax(Request $request)
{
    // validar mínimo que venga el id
    if (!$request->filled('id')) {
        return response()->json(['success' => false, 'message' => 'ID missing'], 422);
    }

    $decoded = \Hashids::decode($request->id);
    if (!isset($decoded[0])) {
        return response()->json(['success' => false, 'message' => 'ID inválido'], 404);
    }
    $projectId = $decoded[0];

    $project = Projects::with('productos','timeline')->find($projectId);
    if (!$project) {
        return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
    }

    // --- Actualizar campos simples ---
    $fields = [
        'no_project','customer','date_shopping','bussine_id','email_customer','email_customer2',
        'asesor','phone_asesor','email_asesor','information_shopping','seller_id','state'
    ];
    foreach($fields as $f) {
        if ($request->has($f)) $project->{$f} = $request->input($f);
    }
    if($request->seller_id){
        $asesor=User::find($request->seller_id);
        $project->asesor=$asesor->name.' '.$asesor->lastname;
        $project->phone_asesor=$asesor->phone;
    }
    if ($request->has('state') && $request->input('state') == 1) {
        $project->date_finish = date('Y-m-d');
        ProjectTimeLine::create([
            'project_id'=>$project->id,
            'description'=>'Pedido entregado',
            'file'=>null
        ]);
    }
    

    // --- Manejo de productos: removed_products[], producto[], producto_id[], price[], quantity[], imagen[] ---
    if ($request->has('removed_products')) {
        ProjectsProducts::whereIn('id', $request->removed_products)->where('project_id', $project->id)->delete();
    }

    $productoArr = $request->input('producto', []);
    $productoIdArr = $request->input('producto_id', []);

    $imagenes = $request->file('imagen') ?? [];

    $total=0;
    foreach ($productoArr as $index => $productoNombre) {
        $prodId = $productoIdArr[$index] ?? null;
        $price = $request->input("price.$index", 0);
        $quantity = $request->input("quantity.$index", 1);

        $imageName = null;
        if (isset($imagenes[$index]) && $imagenes[$index]) {
            $file = $imagenes[$index];
            $nametem = Str::random(7);
            $imageName = time().'_'.$nametem.'.'.$file->extension();
            $file->move(public_path('images/custom_request'), $imageName);
        }
        $total=$total+($price*$quantity);
        if ($prodId) {
            $prod = ProjectsProducts::find($prodId);
            if ($prod) {
                $prod->producto = $productoNombre;
                $prod->price = $price;
                $prod->quantity = $quantity;
                if ($imageName) $prod->imagen = $imageName;
                $prod->save();
            }
        } else {
            ProjectsProducts::create([
                'producto' => $productoNombre,
                'price' => $price,
                'quantity' => $quantity,
                'imagen' => $imageName,
                'project_id' => $project->id
            ]);
        }
    }
    $project->total=$total;
    $project->save();

    // --- Timeline: si vienen description[] y image[] (misma lógica que en tu store/update original) ---
    if ($request->has('description')) {
        $imagesTimeline = $request->file('image') ?? [];
        foreach ($request->description as $k => $desc) {
            $fileName = null;
            if (isset($imagesTimeline[$k]) && $imagesTimeline[$k]) {
                $img = Image::make($imagesTimeline[$k]);
                $fileName = time().'_'.$imagesTimeline[$k]->getClientOriginalName().'.'.$imagesTimeline[$k]->extension();
                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/projects/' . $fileName));
            }
            ProjectTimeLine::create([
                'project_id' => $project->id,
                'description' => $desc,
                'file' => $fileName
            ]);
        }
    }

    // aquí podrías enviar mails si lo necesitas (igual que en tu update original)

    return response()->json(['success' => true, 'message' => 'Proyecto actualizado', 'project_id' => $project->encode_id]);
}

// Agrega este método al final de ProjectsController.php
public function exportProjects(Request $request)
{
    $isEasyGift = $request->get('easygift', 1); // Por defecto 1 para easygift
    
    // Obtener los proyectos según el rol del usuario SOLO con easybuy = 1
    if(auth()->user()->hasrole('Comercio')){
        $projects = Projects::with(['comercio', 'empresa', 'productos', 'productos.producto'])
            ->where('seller_id', auth()->user()->id)
            ->where('easybuy', 1) // Solo easygift
            ->orderBy('created_at', 'desc')
            ->get();
    } elseif(auth()->user()->hasrole('Empresa')){
        $projects = Projects::with(['comercio', 'empresa', 'productos', 'productos.producto'])
            ->where('bussine_id', auth()->user()->id)
            ->where('easybuy', 1) // Solo easygift
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        $projects = Projects::with(['comercio', 'empresa', 'productos', 'productos.producto'])
            ->where('easybuy', 1) // Solo easygift
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Crear nuevo archivo de Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Título del reporte
    $sheet->setCellValue('A1', 'REPORTE DE EASY GIFT');
    $sheet->mergeCells('A1:Q1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    // Fecha del reporte
    $sheet->setCellValue('A2', 'Fecha de generación: ' . date('d/m/Y H:i:s'));
    $sheet->mergeCells('A2:Q2');
    $sheet->getStyle('A2')->getFont()->setItalic(true);
    
    // Encabezados (fila 4)
    $headers = [
        'FECHA PEDIDO',
        'CLIENTE (Empresa)',
        'NIT',
        'NOMBRE USUARIO',
        'CORREO USUARIO',
        'NOMBRE DESTINATARIO',
        'DIRECCION DESTINATARIO',
        'TELEFONO',
        'MUNICIPIO',
        'PRODUCTO',
        'CANTIDAD',
        'VALOR ENVIO',
        'TOTAL',
        'ESTADO',
        'GUIA',
        'COMERCIO',
        'VENDEDOR'
    ];

    // Aplicar encabezados
    foreach (range('A', 'Q') as $index => $column) {
        $sheet->setCellValue($column . '4', $headers[$index] ?? '');
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    
    // Estilo para los encabezados
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4472C4'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ];
    $sheet->getStyle('A4:Q4')->applyFromArray($headerStyle);

    // Llenar datos
    $row = 5;
    foreach ($projects as $project) {
        // Obtener datos de la empresa
        $empresa = $project->empresa ?? null;
        $usuario = $project ? User::find($project->user_id) : null;
        $asesor = $project->comercio ? User::find($project->comercio->user_id) : null;        
        
        // Si hay múltiples productos, crear una fila por producto
        if ($project->productos->count() > 0) {
            foreach ($project->productos as $productoItem) {
                $producto = $productoItem->producto;
                
                $valorEnvio = $productoItem ? $productoItem->shipping_price : 0;
                
                $sheet->setCellValue('A' . $row, $project->created_at->format('d/m/Y H:i'));
                $sheet->setCellValue('B' . $row, $project ? $project->empresa : '');
                $sheet->setCellValue('C' . $row, $project ? $project->document : '');
                $sheet->setCellValue('D' . $row, $usuario ? $usuario->name.' '.$usuario->lastname : '');
                $sheet->setCellValue('E' . $row, $usuario ? $usuario->email : '');
                $sheet->setCellValue('F' . $row, $project->customer);
                $sheet->setCellValue('G' . $row, $project->address ?? '');
                $sheet->setCellValue('H' . $row, $project->cellphone ?? '');
                $sheet->setCellValue('I' . $row, $project->city ?? '');
                $sheet->setCellValue('J' . $row, $productoItem->producto);
                $sheet->setCellValue('K' . $row, $productoItem->quantity);
                $sheet->setCellValue('L' . $row, $valorEnvio);
                $sheet->setCellValue('M' . $row, $project->total ?? 0);
                $sheet->setCellValue('N' . $row, $this->getStateText($project->state));
                $sheet->setCellValue('O' . $row, $project->guia ?? '');
                $sheet->setCellValue('P' . $row, $project->comercio ? $project->comercio->company_name : '');
                $sheet->setCellValue('Q' . $row, $asesor ? $asesor->name.' '.$asesor->lastname : '');
                
                // Formato de números
                $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('$#,##0');
                $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('$#,##0');
                
                $row++;
            }
        } else {
            // Si no hay productos, crear una fila con datos básicos
            $sheet->setCellValue('A' . $row, $project->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('B' . $row, $project ? $project->empresa : '');
            $sheet->setCellValue('C' . $row, $project ? $project->document : '');
            $sheet->setCellValue('D' . $row, $usuario ? $usuario->name.''.$usuario->lastname : '');
            $sheet->setCellValue('E' . $row, $usuario ? $usuario->email : '');
            $sheet->setCellValue('F' . $row, $project->customer);
            $sheet->setCellValue('G' . $row, $project->address ?? '');
            $sheet->setCellValue('H' . $row, $project->cellphone ?? '');
            $sheet->setCellValue('I' . $row, $project->city ?? '');
            $sheet->setCellValue('J' . $row, 'Sin productos');
            $sheet->setCellValue('K' . $row, 0);
            $sheet->setCellValue('L' . $row, 0);
            $sheet->setCellValue('M' . $row, $project->total ?? 0);
            $sheet->setCellValue('N' . $row, $this->getStateText($project->state));
            $sheet->setCellValue('O' . $row, $project->guia ?? '');
            $sheet->setCellValue('P' . $row, $project->comercio ? $project->comercio->company_name : '');
            $sheet->setCellValue('Q' . $row, $asesor ? $asesor->name.' '.$asesor->lastname : '');
            
            $row++;
        }
    }

    // Estilo para los datos
    $dataStyle = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ];
    
    if ($row > 5) {
        $sheet->getStyle('A5:Q' . ($row-1))->applyFromArray($dataStyle);
        
        // Agregar totales
        $lastRow = $row;
        $sheet->setCellValue('J' . $lastRow, 'TOTALES:');
        $sheet->getStyle('J' . $lastRow)->getFont()->setBold(true);
        
        $sheet->setCellValue('K' . $lastRow, '=SUM(K5:K' . ($row-1) . ')');
        $sheet->setCellValue('L' . $lastRow, '=SUM(L5:L' . ($row-1) . ')');
        $sheet->setCellValue('M' . $lastRow, '=SUM(M5:M' . ($row-1) . ')');
        
        $sheet->getStyle('K' . $lastRow . ':M' . $lastRow)->getFont()->setBold(true);
        $sheet->getStyle('K' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L' . $lastRow)->getNumberFormat()->setFormatCode('$#,##0');
        $sheet->getStyle('M' . $lastRow)->getNumberFormat()->setFormatCode('$#,##0');
    }

    // Crear el archivo
    $writer = new Xlsx($spreadsheet);
    $filename = 'reporte_easygift_' . date('Y-m-d_His') . '.xlsx';
    
    // Configurar la respuesta
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
}
private function getStateText($state)
{
    switch ($state) {
        case 0:
            return 'En Ejecución';
        case 1:
            return 'Finalizado';
        case 2:
            return 'Cancelado';
        case 9:
            return 'Por Completar';
        default:
            return 'Desconocido';
    }
}

}
