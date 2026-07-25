<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrdersTimeLine;


use Illuminate\Support\Str;

use Image;
use Mail;

class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Ver Ordenes')->only('index');
        $this->middleware('permission:Editar Orden')->only('update');
        $this->middleware('permission:Editar Orden')->only('edit');
        $this->middleware('permission:Eliminar Orden')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver las ordenes: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        if(auth()->user()->hasrole('Comercio')){
            $usuario=auth()->user()->id;
            $orders=Orders::with('items','items.producto','items.comercio','items.extras','items.extras.itemextra')->whereHas('items.producto', function ($query) use($usuario){
                return $query->where('user_id', '=', $usuario);
            })->orderBy('created_at', 'desc')->get();
           
            return view ('admin.orders.indexcomercio', compact('orders'));
            
        }else{
            $orders = Orders::with('items','items.producto','items.comercio','items.extras','items.extras.itemextra')->orderBy('created_at', 'desc')->get();
        }
        
        
        return view ('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orders  $service
     * @return \Illuminate\Http\Orders
     */
    public function show($idorder)
    {
        $order = Orders::with('items','items.producto','items.producto.gallery','items.comercio','items.color','items.talla','items.extras','items.extras.itemextra','timeline' )->find(\Hashids::decode($idorder)[0]);
       //dd($order);
        return view ('site.stateordes.index', ['order' => $order]);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //templateordersupdate
       
        $order = Orders::with('items','items.producto','items.comercio','items.color','items.talla','items.extras','items.extras.itemextra','timeline' )->find(\Hashids::decode($id)[0]);
        //dd($order);
        
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la orden: '.$order->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        return view('admin.orders.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $order = Orders::with('items','items.producto','items.comercio')->find(\Hashids::decode($id)[0]);
       
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
                    })->save(public_path('images/orders/' . $imageName));
                }
                OrdersTimeLine::create([
                    'order_id'=>\Hashids::decode($request->id)[0],
                    'description'=>$item,
                    'file'=>$imageName
                ]);
                             
                
                $neworder = Orders::with('items','items.producto','items.producto.gallery','items.comercio','timeline')->find(\Hashids::decode($id)[0]);
                $newdata=[
                    'description' =>$item,
                ];

                $data = array('data'=>$newdata, 'order'=>$neworder);
                
                Mail::send('admin.orders.partials.templateordersupdate', $data, function($message) use ($neworder){
                     $message->to($neworder->email, $neworder->name);
                     $message->subject('Solicitud Kanbai No. '.$neworder->id);
                     $message->from('ventas@kanbai.co','Kanbai');
                });

               // update
                
            }
        }

        if($request->state==3){
            $neworder = Orders::with('items','items.producto','items.producto.gallery','items.comercio','timeline')->find(\Hashids::decode($id)[0]);
            $newdata=[
                'description' =>'Tu pedido #'.$neworder->id.' ya esta confirmado Nos encontramos procesando tu orden. . Puedes consultar el estado de tu pedido en el Siguiente botón:',
            ];

            $data = array('data'=>$newdata, 'order'=>$neworder);
            
            Mail::send('admin.orders.partials.templateordersprocess', $data, function($message) use ($neworder){
                 $message->to($neworder->email, $neworder->name);
                 $message->subject('Solicitud Kanbai No. '.$neworder->id);
                 $message->from('ventas@kanbai.co','Kanbai');
            });
        }

        $order->state=$request->state;
        $order->save();

        return json_encode(['success' => true, 'customer_id' => $order->encode_id]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Orders::find(\Hashids::decode($id)[0]);
        $image_path = public_path().'/images/vauchers/'.$order->vaucher;
        if (@getimagesize($image_path)) {
            unlink($image_path);
        }       
        OrdersItems::where('order_id',$order->id)->delete();
        Orders::find(\Hashids::decode($id)[0])->delete();
       
       

        return json_encode(['success' => true]);
    }
    
}
