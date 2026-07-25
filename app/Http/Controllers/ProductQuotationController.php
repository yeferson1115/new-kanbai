<?php

namespace App\Http\Controllers;

use App\Models\ProductQuotation;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProductQuotationHistory;
use App\Models\ProductQuotationItems;
use App\Models\ProductQuotationItemsExtra;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrdersItemsExtras;

use App\Models\Log\LogSistema;
use Mail;

use Barryvdh\DomPDF\Facade as PDF;
set_time_limit(300);

use Cart;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

use Carbon\Carbon;

class ProductQuotationController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Cotizaciones')->only('index');
        //$this->middleware('permission:Editar Cotizaciones')->only('update');
        $this->middleware('permission:Editar Cotizaciones')->only('edit');
        $this->middleware('permission:Eliminar Cotizaciones')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //@if(Auth::user()->hasrole('Usuario'))
       
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver las cotizaciones: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        if(auth()->user()->hasrole('Comercio')){
            $usuario=auth()->user()->id;
            $quotations=ProductQuotation::with('items','user')->whereHas('items.producto', function ($query) use($usuario){
                return $query->where('user_id', '=', $usuario);
            })->orderBy('created_at', 'desc')->get();
            $qespera=ProductQuotation::with('items','user')->whereHas('items.producto', function ($query) use($usuario){
                return $query->where('user_id', '=', $usuario);
            })->where('state',0)->orderBy('created_at', 'desc')->get();
            $qcanceladas=ProductQuotation::with('items','user')->whereHas('items.producto', function ($query) use($usuario){
                return $query->where('user_id', '=', $usuario);
            })->where('state',2)->orderBy('created_at', 'desc')->get();
            $qaprobadas=ProductQuotation::with('items','user')->whereHas('items.producto', function ($query) use($usuario){
                return $query->where('user_id', '=', $usuario);
            })->where('state',3)->orderBy('created_at', 'desc')->get();
            return view ('admin.quotations.indexcomercio', compact('quotations','qespera','qcanceladas','qaprobadas'));
            
        }else{            
            $quotations = ProductQuotation::with('producto','user')->orderBy('created_at', 'desc')->get();
            $qespera = ProductQuotation::where('state', 0)->with('producto','user')->orderBy('created_at', 'desc')->get();
            $qcanceladas = ProductQuotation::where('state', 2)->with('producto','user')->orderBy('created_at', 'desc')->get();
            $qaprobadas = ProductQuotation::where('state', 1)->with('producto','user')->orderBy('created_at', 'desc')->get();
        }

        return view ('admin.quotations.index', compact('quotations','qespera','qcanceladas','qaprobadas'));
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


    public function templateQuotationUser($data=''){
        $logo='https://kanbai.co/images/logo/logo.png';    
        $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->find(1);
            
        $galeria = array();
        foreach($quotation->items as  $key=>$item){
            foreach($item->producto->gallery as  $image){
            array_push($galeria, 'https://kanbai.co/images/products/thumbnail/'.$image->file);
            //array_push($galeria, 'http://localhost:81/images/products/thumbnail/'.$item->file);
            }
        } 
        
       return view('admin.quotations.pdf',compact('logo','quotation','galeria'));
        //$data = array('data'=>$request, 'producto'=>$product);        
        return view ('site.quotation.templatequotationuser', compact('data', 'producto', 'vendedor'));
    }

    public function templateQuotationVendor($data=''){
         $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->find(1);
        
        $logo='https://kanbai.co/images/logo/logo.png';            
        $name_pdf = time().'_'. $quotation->id.'.pdf';       

        $galeria = array();
        foreach($quotation->items as  $key=>$item){
            foreach($item->producto->gallery as  $image){
            array_push($galeria, 'https://kanbai.co/images/products/thumbnail/'.$image->file);
            //array_push($galeria, 'http://localhost:81/images/products/thumbnail/'.$item->file);
            }
        }  
        //$data = array('data'=>$request, 'producto'=>$product);        
        return view ('site.quotation.templatequotationuser', compact('data', 'producto', 'vendedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $totalextras=0;
        foreach(Cart::getContent() as $cart){   
            if(count($cart->attributes->extra)>0){
                foreach($cart->attributes->extra as $extra){
                    $totalextras=$totalextras+($extra['price']*$cart->quantity);
                }
            }
        }

        $productos=array();
        foreach(Cart::getContent() as $cart){

            $product=Products::with('user')->where('id',$cart->id)->first();
            $p=array(
                'id'=>$cart->id,
                'name'=>$cart->name,
                'price'=>$cart->price,
                'quantity'=>$cart->quantity,
                'urlfoto'=>$cart->attributes->urlfoto,
                'user_id'=>$product->user_id,
                'data_user'=>$product->user,
                'color_id'=>$cart->attributes->color,
                'talla_id'=>$cart->attributes->size,
                'extras'=>$cart->attributes->extra
            );
            array_push($productos,$p);

        }
        
        $product_user=$this->groupArray($productos,'user_id');
       
        $producto=Cart::getContent();
        $product=Products::with('user')->where('id',$request->product_id)->first();
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
        $cotizacion = ProductQuotation::create([
            'email'=>$request->email,
            'name'=>$request->name,
            'cellphone'=>$request->cellphone,
            'quantity'=>$request->quantity,
            'address'=>$request->address,
            'date_delivery'=>$request->date_delivery,
            'observations'=>$request->observations,
            'user_id'=>$product->user->id,
            'user_request_id'=>$user_id,
            'total'=>Cart::getTotal()+$totalextras,
            'name_business'=>$request->company
        ]);  
        /**Se insertan los productos de la cotizacion */
        foreach(Cart::getContent() as $cart){
            $producto=Products::with('user')->where('id',$cart->id)->first();
            $item=ProductQuotationItems::create([
                'product_id'=>$cart->id,
                'productquotation_id'=>$cotizacion->id,
                'commerce_id'=>$producto->user_id,
                'price'=>$cart->price,
                'quantity'=>$cart->quantity,
                'color_id'=>$cart->attributes->color,
                'talla_id'=>$cart->attributes->size,
            ]);
            if(count($cart->attributes->extra)>0){
                foreach($cart->attributes->extra as $extra){
                    ProductQuotationItemsExtra::create([
                        'product_quotation_id'=>$cotizacion->id,
                        'product_quotation_item_id'=>$item->id,
                        'extra_id'=>$extra['id_item'],
                        'price'=>$extra['price'],
                        'quantity'=>$cart->quantity
                    ]);
                }
            } 
        }
        ProductQuotationHistory::create([
            'quotation_id'=>$cotizacion->id,
            'state'=>0,
        ]); 

        //$user = User::where('id',$producto->user_id)->first();

        setlocale(LC_ALL,"es_ES");
        setlocale(LC_TIME, "spanish");
        $newDate = date("d-m-Y", strtotime($request->date_delivery));  
        $fecha = strftime("%d %b, %Y", strtotime($newDate));
        $request['fecha']=$fecha;
        $request['idsolicitud']=$cotizacion->id;
        $data = array('data'=>$request, 'producto'=>$productos);

        /**Generamos PDF */
        $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user','items.color','items.talla','items.extras','items.extras.itemextra')->find($cotizacion->id);
        
        $logo='https://kanbai.co/images/logo/logo-kanbai-color.png';            
        $name_pdf = time().'_'. $quotation->id.'.pdf';       

        $galeria = array();
        foreach($quotation->items as  $key=>$item){
            foreach($item->producto->gallery as  $image){
            array_push($galeria, 'https://kanbai.co/images/products/thumbnail/'.$image->file);
            //array_push($galeria, 'http://localhost:81/images/products/thumbnail/'.$item->file);
            }
        }        
        $pdf = PDF::loadView('admin.quotations.pdf',compact('logo','quotation','galeria'))
        ->setPaper('A4', 'portrait')->save(public_path('cotizaciones/'.$name_pdf));
        $quotation->file=$name_pdf;
        $quotation->save();
        /**Enviamos pdf por correo */
        if($quotation->user!=null){
            $name=$quotation->user->name.' '.$quotation->user->lastname;
            $data = array('name'=>$name);
            $pdfsend = PDF::loadView('admin.quotations.pdf',compact('logo','quotation','galeria'))->setPaper('A4', 'portrait');
            Mail::send('admin.quotations.templateemail', $data, function($message) use ($quotation,$pdfsend){
                $message->to($quotation->email, $quotation->name);
                $message->subject('Solicitud Kanbai No. '.$quotation->id);
                $message->attachData($pdfsend->output(), $quotationsend->id.".pdf");
                $message->from('ventas@kanbai.co','Kanbai');
           });
        }

        foreach($product_user as $item){
            $user = User::where('id',$item['user_id'])->first();
            $data = array('data'=>$request, 'producto'=>$item['groupeddata'], 'vendedor'=> $user);
            Mail::send('site.quotation.templatequotationvendor', $data, function($message) use ($request, $user){
                $message->to($user->email, $user->name);
                $message->subject('Solicitud Kanbai No. '.$request->idsolicitud);
                $message->from('ventas@kanbai.co','Kanbai');
           });
        }
        
        Cart::clear();
        return json_encode(['success' => true, 'id' => $cotizacion->id]);
        //return json_encode(['success' => true, 'id' => $cotizacion->id]);
    }

function groupArray($array,$groupkey)
{
 if (count($array)>0)
 {
 	$keys = array_keys($array[0]);
 	$removekey = array_search($groupkey, $keys);		if ($removekey===false)
 		return array("Clave \"$groupkey\" no existe");
 	else
 		unset($keys[$removekey]);
 	$groupcriteria = array();
 	$return=array();
 	foreach($array as $value)
 	{
 		$item=null;
 		foreach ($keys as $key)
 		{
 			$item[$key] = $value[$key];
 		}
 	 	$busca = array_search($value[$groupkey], $groupcriteria);
 		if ($busca === false)
 		{
 			$groupcriteria[]=$value[$groupkey];
 			$return[]=array($groupkey=>$value[$groupkey],'groupeddata'=>array());
 			$busca=count($return)-1;
 		}
 		$return[$busca]['groupeddata'][]=$item;
 	}
 	return $return;
 }
 else
 	return array();
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation =ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->where('user_request_id',auth()->user()->id)->find(\Hashids::decode($id)[0]);
        
        return view ('site.quotation.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user','items.extras','items.extras.itemextra')->find(\Hashids::decode($id)[0]);
        
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la cotizacion: '.$quotation->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
       
        
        //$logo='https://kanbai.co/images/logo/logo.png'; 
       
        $logo=null;
        $relacionEloquent = 'roles';
        $asesores = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Asesor');
            })->get();  
        
        //return view('admin.quotations.pdf', ['quotation' => $quotation,'logo'=>$logo,'galeria'=>$galeria]);
        return view('admin.quotations.edit', ['quotation' => $quotation,'logo'=>$logo,'asesores'=>$asesores]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
       
        if($request->state && $request->deny){
            $productquotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user','items.color','items.talla' )->find(\Hashids::decode($id)[0]);
            $productquotation->state = $request->state;
            $productquotation->deny = $request->deny;
            
            $productquotation->save();
            return json_encode(['success' => true, 'campuse_id' => $productquotation->encode_id]);
        }
        
        if($request->new_state==0){
           
         /**Borramos los items y agregamos los nuevos */
         ProductQuotationItems::where('productquotation_id',\Hashids::decode($id)[0])->delete();
         $items=$request->product_id;
         $prices=$request->price;
         $quantitys=$request->quantity;
         $product_id=$request->product_id;
         $talla_id=$request->talla_id;
         $color_id=$request->color_id;
         $total=0;
         
         foreach($items as $key=>$item){
            $producto=Products::with('user')->where('id',$product_id[$key])->first();     
                
            $talla = isset($talla_id[$key]) && !empty($talla_id[$key]) ? $talla_id[$key] : null;
            $color = isset($color_id[$key]) && !empty($color_id[$key]) ? $color_id[$key] : null;


            $itemsProduct=ProductQuotationItems::create([
                'product_id'=>$product_id[$key],
                'productquotation_id'=>\Hashids::decode($id)[0],
                'commerce_id'=>$producto->user_id,
                'price'=>$prices[$key],
                'quantity'=>$quantitys[$key],
                'talla_id'=>$talla,
                'color_id'=>$color,
            ]);
            $idextra=$item;
            $extras=$request->input('extra_id_'.$idextra);            
            $precios=$request->input('price_extra_'.$idextra);
            $totalextra=0;
            if($extras){
                 foreach($extras as $keye=>$extra){
                    $extra=ProductQuotationItemsExtra::find($extra);
                    $extra->price=$precios[$keye];
                    $extra->quantity=$quantitys[$key];
                    $extra->product_quotation_item_id=$itemsProduct->id;
                    $extra->save();
                    $totalextra=$totalextra+($precios[$keye]*$quantitys[$key]);
                }
            }
           

            $total=(float)$total+((float)$prices[$key]*$quantitys[$key])+$totalextra;
         }
         

        

        $productquotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user','items.color','items.talla','items.extras','items.extras.itemextra')->find(\Hashids::decode($id)[0]);
        if($productquotation->state!= $request->state){
            ProductQuotationHistory::create([
                'quotation_id'=>$productquotation->id,
                'state'=>$request->state,
            ]);
        }
        if($request->state){
            $productquotation->state = $request->state;
        }
        if($request->price_shiping){
            $productquotation->price_shiping = $request->price_shiping;
        }
        if($request->name){
            $productquotation->name = $request->name;
        }
        if($request->cellphone){
            $productquotation->cellphone = $request->cellphone;
        }
        if($request->email){
            $productquotation->email = $request->email;
        }
        
        if($request->comment){
            $productquotation->comment = $request->comment;
        }
        if($request->deny){
            $productquotation->deny = $request->deny;
        }
        if($request->deny_customer){
            $productquotation->deny_customer = $request->deny_customer;
        }
        if($request->type_document){
            $productquotation->type_document = $request->type_document;
        }
        if($request->document){
            $productquotation->document = $request->document;
        }
        if($request->name_business){
            $productquotation->name_business = $request->name_business;
        }
        if($request->city){
            $productquotation->city = $request->city;
        }
        $productquotation->total = $total;
        $productquotation->plazo= $request->plazo;
        $productquotation->user_id= $request->user_id;
        $productquotation->name_business=$request->name_business;
        $productquotation->date_delivery=$request->date_delivery;
        $productquotation->version = $productquotation->version + 1;
        
        $productquotation->save();

       

      
        $logo='https://kanbai.co/images/logo/logo-kanbai-color.png';
        $name_pdf = time().'_'. $productquotation->id.'.pdf';
        $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user','items.color','items.talla','items.extras','items.extras.itemextra')->find(\Hashids::decode($id)[0]);
            
        $galeria = array();
        foreach($quotation->items as  $key=>$item){
            foreach($item->producto->gallery as  $image){
            array_push($galeria, 'https://kanbai.co/images/products/thumbnail/'.$image->file);
            //array_push($galeria, 'http://localhost:81/images/products/thumbnail/'.$item->file);
            }
        }
        
        $pdf = PDF::loadView('admin.quotations.pdf',compact('logo','quotation','galeria'))
        ->setPaper('A4', 'portrait')->save(public_path('cotizaciones/'.$name_pdf));
        $quotation->file=$name_pdf;
        $quotation->save();
        
        $quotationsend = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->find(\Hashids::decode($id)[0]);
         
    }

        if($request->state==3){
            $quotationnextorder = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user','items.color','items.talla','items.extras','items.extras.itemextra')->find(\Hashids::decode($id)[0]);
            $quotationnextorder->state=3;
            $quotationnextorder->save();
            
            $totalextras=0;
            foreach($quotationnextorder->items as $cart){
                if(count($cart->extras)>0){
                    foreach($cart->extras as $extra){
                        $totalextras=$totalextras+($extra->price*$cart->quantity);
                    }
                }
            }
            

        
        $imageName = null;
        
        $order=Orders::create([
            'email'=>$quotationnextorder->email,
            'type_document'=>$quotationnextorder->type_document,
            'document'=>$quotationnextorder->document,
            'name_business'=>$quotationnextorder->name_business,
            'name'=>$quotationnextorder->name,
            'cellphone'=>$quotationnextorder->cellphone,
            'address'=>$quotationnextorder->address,
            'city'=>$quotationnextorder->city,
            'date_delivery'=>$quotationnextorder->date_delivery,
            'observation'=>$quotationnextorder->observations,
            'total'=>Cart::getTotal()+$totalextras,
            'payment_method'=>null,
            'vaucher'=>null,
            'state'=>1
        ]);


        foreach($quotationnextorder->items as $cart){
            $product=Products::with('user')->where('id',$cart->product_id)->first();
            $item=OrdersItems::create([
                'order_id'=>$order->id,
                'product_id'=>$cart->product_id,
                'quantity'=>$cart->quantity,
                'price_unit'=>$cart->price,
                'commerce_id'=>$product->user_id,
                'color_id'=>$cart->color_id,
                'talla_id'=>$cart->talla_id,
            ]);
            if(count($cart->extras)>0){
                foreach($cart->extras as $extra){
                    OrdersItemsExtras::create([
                        'order_id'=>$order->id,
                        'order_item_id'=>$item->id,
                        'extra_id'=>$extra->extra_id,
                        'price'=>$extra->price,
                        'quantity'=>$cart->quantity,
                    ]);
                }
            }
            
        }
                                     
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $reference=substr(str_shuffle($permitted_chars), 0, 6)."-".$order->id;

        $ordeupdate = Orders::find($order->id);
        $ordeupdate->reference=$reference;
        $ordeupdate->save();
        Cart::clear();


        }
       
        


        return json_encode(['success' => true, 'campuse_id' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        \Config::set('dompdf.enable_remote', true);
        \Config::set('dompdf.defines.enable_remote', true);
        $productquotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->find(\Hashids::decode($id)[0]);
        if($productquotation->uid==null){
            $productquotation->uid = (string) Str::uuid();
            $productquotation->save();
        }
        $logo='https://kanbai.co/images/logo/logo-kanbai-color.png';            
        $name_pdf = time().'_'. $productquotation->id.'.pdf';
        $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->find(\Hashids::decode($id)[0]);
            
        $galeria = array();
        foreach($quotation->items as  $key=>$item){
            foreach($item->producto->gallery as  $image){
            array_push($galeria, 'https://kanbai.co/images/products/thumbnail/'.$image->file);
            //array_push($galeria, 'http://localhost:81/images/products/thumbnail/'.$item->file);
            }
        } 
        
        if($productquotation->state!= 6){
            ProductQuotationHistory::create([
                'quotation_id'=>$productquotation->id,
                'state'=>6
            ]);
            
            $quotationactu = ProductQuotation::find(\Hashids::decode($id)[0]);            
            $quotationactu->state = 6;
            $quotationactu->save();            
        }
        
        $quotationsend = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->find(\Hashids::decode($id)[0]);
        $quotationsend->enviado = $quotationsend->enviado + 1;
        $quotationsend->save();
        if($quotationsend->email!=null){
            $name=$quotation->name.' '.$quotation->lastname;
            $data = array('name'=>$name,'uid'=>$productquotation->uid,'id'=>$productquotation->id);
            $pdfsend = PDF::loadView('admin.quotations.pdf',compact('logo','quotation','galeria'))->setPaper('A4', 'portrait');
            $name_pdf = time().'_'. $productquotation->id.'.pdf';
            
            $pdfsend->save(public_path('cotizaciones/'.$name_pdf));
            $quotationsend->file=$name_pdf;
            $quotationsend->state=1;
            $quotationsend->save();
            Mail::send('admin.quotations.templateemail', $data, function($message) use ($quotationsend,$pdfsend){
                $message->to($quotationsend->email, $quotationsend->name);
                $message->subject('Solicitud Kanbai No. '.$quotationsend->id);
                $message->attachData($pdfsend->output(), $quotationsend->id.".pdf");
                $message->from('ventas@kanbai.co','Kanbai');
           });
        }
        

        return json_encode(['success' => true]);
    }
    public function vercotizacion($uid){
        $quotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->where('uid',$uid)->first();
        
        return view ('site.quotation.showquotation', compact('quotation'));
    }
}
