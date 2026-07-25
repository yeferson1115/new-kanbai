<?php

namespace App\Http\Controllers;

use App\Models\CustomRequest;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\CustomRequestHistory;
use App\Models\Projects;
use App\Models\CustomRequestGallery;
use App\Models\ProjectTimeLine;
use Illuminate\Support\Facades\Hash;


use App\Models\Log\LogSistema;

use Illuminate\Support\Str;

use Image;

use Mail;

use Barryvdh\DomPDF\Facade as PDF;
set_time_limit(300);


class CustomRequestController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Solicitudes Personalizadas')->only('indexpanel');
        $this->middleware('permission:Editar Solicitudes Personalizadas')->only('update');
        $this->middleware('permission:Editar Solicitudes Personalizadas')->only('edit');
        $this->middleware('permission:Eliminar Solicitudes Personalizadas')->only('destroy');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::with('subcategories')->get();
        return view('site.customrequest.create', compact('categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexpanel()
    {
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver las solicitudes personalizadas: '.date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();    

        $customrequest = CustomRequest::with('category')->get(); 
        $cespera = CustomRequest::where('state',0)->with('category')->orderBy('created_at', 'desc')->get(); 
        $cejecucion = CustomRequest::where('state',1)->with('category')->orderBy('created_at', 'desc')->get(); 
        $ccancelados = CustomRequest::where('state',2)->with('category')->orderBy('created_at', 'desc')->get(); 
        $cfinalizadas = CustomRequest::where('state',9)->with('category')->orderBy('created_at', 'desc')->get(); 
       
        return view('admin.customrequest.index', compact('customrequest','cespera','cejecucion','ccancelados','cfinalizadas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName=null;
        if($request->image){    
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/custom_request'), $imageName);
         
        }
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }else{
            $user=User::create([
                'name' => $request->name_user,
                'email' => $request->email_user,
                'username' => $request->email_user,
                'genero' => null,
                'name_business' => $request->name_business,
                'status'=>1,
                'phone'=> $request->phone,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole(2);
            $user_id=$user->id;

        }
        $customrequest = CustomRequest::create([
            'email'=>$request->email,
            'cellphone'=>$request->cellphone,
            'name'=>$request->name,
            'name_business'=>$request->name_business,
            'quantity'=>$request->quantity,
            'date_delivery'=>$request->date_delivery,
            'budget_unit'=>$request->budget_unit,
            'delivery_method'=>$request->delivery_method,
            'category_id'=>$request->category_id,
            'observations'=>$request->observations,
            'file'=>$imageName,
            'state'=>0,
            'user_request_id'=>$user_id                              
        ]);
        
        return json_encode(['success' => true, 'id' => $customrequest->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CustomRequest $CustomRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customrequest = CustomRequest::with('category','history')->find(\Hashids::decode($id)[0]);
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la solicitud personalizada: '.$customrequest->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $categories = Categories::with('subcategories')->get();
        return view('admin.customrequest.edit', ['customrequest' => $customrequest,'categories'=>$categories]);
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
       
        $CustomRequest = CustomRequest::find($request->customrequest_id);
        $CustomRequest->state = $request->state; 
        $CustomRequest->price_finish = $request->price_finish;  
        $CustomRequest->shipping_from = $request->shipping_from;  
        $CustomRequest->product = $request->product;      
        $CustomRequest->date_delivery_ok = $request->date_delivery_ok;  
        $CustomRequest->price_shiping = $request->price_shiping; 
        $CustomRequest->iva = $request->iva;  


        if($request->file('image')){    
            
            foreach($request->file('image') as $image){
                $nametem=Str::random(7);
                $imagen = Image::make($image);
                $imageName = time().'_'.$nametem.'.'.$image->extension();

                $destinationPath = public_path('/thumbnail');
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/custom_request/images/' . $imageName));               
               
                $productgallery = CustomRequestGallery::create([
                    'file'=>$imageName,
                    'custom_id'=>$CustomRequest->id                                 
                ]);       

            }
        }
       
       

       
        $CustomRequest->save();

        if($CustomRequest->state!=$request->state){
            CustomRequestHistory::create([
                'custom_request_id'=>$CustomRequest->id,
                'state'=>$request->state,                
            ]);  
        }

        if($request->state==1){
            $logo='https://kanbai.co/images/logo/logo.png';            
            $name_pdf = time().'_solicitud_'. $CustomRequest->id.'.pdf';
            $quotation = CustomRequest::with('gallery','history','user')->find($CustomRequest->id);
       
        $pdf = PDF::loadView('admin.customrequest.pdf',compact('logo','quotation'))
        ->setPaper('A4', 'portrait')->save(public_path('cotizaciones/'.$name_pdf));
        $quotation->filepdf=$name_pdf;
        $quotation->save();
        
        $quotationsend = CustomRequest::with('gallery','history','user')->find($CustomRequest->id);
        if($quotationsend->user!=null){
            $name=$quotation->user->name.' '.$quotation->user->lastname;
            $data = array('name'=>$name);
            $pdfsend = PDF::loadView('admin.customrequest.pdf',compact('logo','quotation'))->setPaper('A4', 'portrait');
            Mail::send('admin.quotations.templateemail', $data, function($message) use ($quotationsend,$pdfsend){
                $message->to($quotationsend->email, $quotationsend->name);
                $message->subject('Solicitud Kanbai No. '.$quotationsend->id);
                $message->attachData($pdfsend->output(), $quotationsend->id.".pdf");
                $message->from('ventas@kanbai.co','Kanbai');
           });
        }
        

        }
        if($request->state==3){
            $project=Projects::where('type',2)->where('id_type',$CustomRequest->id)->first();
            
            if($project==null){
                $projecto=Projects::create([
                    'type'=>2,
                    'id_type'=>$CustomRequest->id,
                    'name'=>$CustomRequest->product,
                    'ubication'=>$CustomRequest->shipping_from,
                    'price_delivery'=>$CustomRequest->price_shiping,
                    'price'=>$CustomRequest->price_finish,
                    'quantity'=>$CustomRequest->quantity,
                    'delivery_date'=>$CustomRequest->date_delivery_ok,
                    'iva'=>$CustomRequest->iva,
                    'state'=>1, 
                    'user_request_id'=>$CustomRequest->user_request_id            
                ]); 

                 ProjectTimeLine::create([
                    'project_id'=>$projecto->id,
                    'description'=>'Pedido en Preparación',
                    'file'=>null
                ]);
            }
        }

        return json_encode(['success' => true, 'campuse_id' => $CustomRequest->encode_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        CustomRequest::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
}
