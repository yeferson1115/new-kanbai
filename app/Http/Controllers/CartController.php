<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Products;
use App\Models\ProductsPriceRange;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrdersItemsExtras;
use App\Models\ProductsColor;
use App\Models\ProductsTallas;
use App\Models\Projects;
use App\Models\ProjectsProducts;
use App\Models\ProjectsProductsExtras;
use App\Models\ProjectTimeLine;

use App\Models\ProductQuotation;
use App\Models\ProductQuotationHistory;
use App\Models\ProductQuotationItems;
use App\Models\ProductQuotationItemsExtra;
use App\Models\User;

use Illuminate\Support\Str;
use Cart;

use Mail;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

use Barryvdh\DomPDF\Facade as PDF;
set_time_limit(300);

class CartController extends Controller
{
    public function __construct()
    {        
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        // Verificar si el carrito secundario tiene productos
        $cartSecondary = Cart::session('secondary')->getContent();

        // Si el carrito secundario tiene productos, redirigir a otra vista
        if ($cartSecondary->isNotEmpty()) {
            return redirect()->route('carrito.secondary');
        }

        // Si el carrito secundario está vacío, continuar con la vista de carrito principal
        return view('site.cart.index');
    }
    public function secondary()
    {
        // Aquí puedes renderizar una vista específica para el carrito secundario
        return view('site.cart.secondary');
    }
    public function pay()
    {
        //Cart::clear();
        //dd(Cart::getContent());
        return view('site.cart.checkout');
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

    public function templateEmail($data=''){
       
            $productos=array(array(
              "id" => 30,
              "name" => "Gorra corporativa",
              "price" => 45000.0,
              "quantity" => "3",
              "urlfoto" => "1674698419_Gorra-corporativa-kanbai.jpg.jpg",
              "color_id" => null,
              "talla_id" => "31",
              "extras" => array(
                0 => array(
                  "extra" => "Estampado",
                  "id_item" => 1,
                  "name" => "prueba 1",
                  "price" => 50000.0
                )
              )
                ));

                $cliente=array(
                    "name" => "zxczxc",
                    "company" => "zxczxc",
                    "email" => "yeferson1115@gmail.com"
                );
          
       $total=500000;
        //$data = array('data'=>$request, 'producto'=>$product);        
        return view ('admin.quotations.templatequotationEmail', compact('productos','total','cliente'));
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $totalextras = 0;
     $totalenvio=0;
    $productos = [];
    foreach (Cart::session('primary')->getContent() as $cart) {
        if ($cart->attributes->extra != null && count($cart->attributes->extra) > 0) {
            foreach ($cart->attributes->extra as $extra) {
                $totalextras += ($extra['price'] * $cart->quantity);
            }
        }

         $talla = null;
        if ($cart->attributes->size != null) {
            $datatalla = ProductsTallas::find($cart->attributes->size);
            $talla = $datatalla->talla;
        }
        $productos[] = [
            'id'      => $cart->id,
            'name'    => $cart->name,
            'price'   => $cart->price,
            'quantity'=> $cart->quantity,
            'urlfoto' => $cart->attributes->urlfoto,
            'talla'   => $talla,
            'extras'  => $cart->attributes->extra
        ];
        $product = Products::where('id', $cart->id)->first();
        /*$packaging_unit_quantity = $product->packaging_unit_quantity;
        $quantity_requested = $cart->quantity; 
        $empaques = ceil($quantity_requested / $packaging_unit_quantity);
        $totalenvio=$totalenvio+($product->shipping_price*$empaques);*/

        $packaging_unit_quantity = (float) ($product->packaging_unit_quantity ?? 0);
        $quantity_requested = (float) ($cart->quantity ?? 0);
        $shipping_price = (float) ($product->shipping_price ?? 0);

        if ($packaging_unit_quantity > 0) {
            $empaques = ceil($quantity_requested / $packaging_unit_quantity);
        } else {
            // Si el empaque no tiene cantidad definida, asumimos 1 o 0 según tu lógica
            $empaques = 0;
        }

        $totalenvio += $shipping_price * $empaques;
    }

    
  

    $total = Cart::session('primary')->getTotal() + $totalextras+$totalenvio;
    $cliente = [
        'name'    => $request->name,
        'company' => $request->company,
        'email'   => $request->email,
        'phone'   => $request->phone,
    ];

    // =============================
    // 🔹 Obtener asesor disponible (reparto equitativo)
    // =============================

    // 1. Obtener todos los asesores con el rol "Asesor"
    $asesores = User::whereHas('roles', function ($query) {
        $query->where('name', 'Asesor');
    })->orderBy('id')->get();

    // Si no hay asesores registrados, dejamos user_id en null
    $userIdAsignado = null;

    /*if ($asesores->count() > 0) {
        // 2. Obtener el último asesor que recibió una cotización
        $ultimoAsesorId = ProductQuotation::whereNotNull('user_id')
            ->latest('id')
            ->value('user_id');

        // 3. Buscar el índice del último asesor asignado
        $indiceUltimo = $asesores->search(function ($asesor) use ($ultimoAsesorId) {
            return $asesor->id === $ultimoAsesorId;
        });

        // 4. Calcular el siguiente índice (circular)
        $indiceSiguiente = ($indiceUltimo === false || $indiceUltimo + 1 >= $asesores->count())
            ? 0
            : $indiceUltimo + 1;

        // 5. Asignar el siguiente asesor
        $userIdAsignado = $asesores[$indiceSiguiente]->id;
    }*/


    // =============================
    // 🔹 Siempre guardar cotización
    // =============================
  
   
    $cotizacion = ProductQuotation::create([
        'email'          => $request->email,
        'name'           => $request->name,
        'cellphone'      => $request->phone, // ojo: aquí usabas distinto en email/phone
        'quantity'       => $request->quantity,
        'address'        => $request->address,
        'date_delivery'  => $request->date_delivery,
        'observations'   => $request->observations,
        'user_id'        => $userIdAsignado,
        'user_request_id'=> null,
        'total'          => $total,
        'channel'        => $request->type, // 👈 guardar si fue email o whatsapp
        'name_business'=>$request->company,
        'price_shiping'=>$totalenvio,
        'totalextras'=>$totalextras,
    ]);

    foreach (Cart::session('primary')->getContent() as $cart) {
        $producto = Products::with('user')->where('id', $cart->id)->first();
        $item = ProductQuotationItems::create([
            'product_id'          => $cart->id,
            'productquotation_id' => $cotizacion->id,
            'commerce_id'         => $producto->user_id,
            'price'               => $cart->price,
            'quantity'            => $cart->quantity,
            'color_id'            => $cart->attributes->color,
            'talla_id'            => $cart->attributes->size,
        ]);

        if (!empty($cart->attributes->extra) && count($cart->attributes->extra) > 0) {
            foreach ($cart->attributes->extra as $extra) {
                ProductQuotationItemsExtra::create([
                    'product_quotation_id'      => $cotizacion->id,
                    'product_quotation_item_id' => $item->id,
                    'extra_id'                  => $extra['id_item'],
                    'price'                     => $extra['price'],
                    'quantity'                  => $cart->quantity
                ]);
            }
        }
    }

    ProductQuotationHistory::create([
        'quotation_id' => $cotizacion->id,
        'state'        => 0,
    ]);


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

    // =============================
    // 🔹 Ahora enviar según el canal
    // =============================

    if ($request->type === 'email') {
        Mail::send('admin.quotations.templatequotationEmail', [
            'productos' => $productos,
            'total'     => $total,
            'cliente'   => $cliente
        ], function ($message) {
            $message->to('info@alma-de-colombia-sas1.odoo.com', 'Kanbai');
            $message->subject('Nueva Cotización');
            $message->from('ventas@kanbai.co', 'Kanbai');
        });

        Cart::session('primary')->clear();

        return response()->json(['success' => true]);

    } elseif ($request->type === 'whatsapp') {
        $message = "Hola Kanbai, requerimos cotizar los siguientes ítems: ";
        foreach ($productos as $p) {
            $message .= "- Producto: {$p['name']} Cantidad: {$p['quantity']} Precio: $" .
                        number_format($p['price'], 0, ',', '.') . " ";
            if (count($p['extras']) > 0) {
                foreach ($p['extras'] as $extra) {
                    $message .= "Extras {$extra['name']} x{$p['quantity']} $" .
                                number_format($extra['price'] * $p['quantity'], 0, ',', '.') . " ";
                }
            }
        }
        $message .= "Total: $" . number_format($total, 0, ',', '.');
        $url = "https://api.whatsapp.com/send?phone=3104058361&text=" . urlencode($message);

        Cart::session('primary')->clear();

        return response()->json(['success' => true, 'whatsapp_url' => $url]);
    }

        

    return response()->json(['success' => false]);
}


    public function storeeasybuy(Request $request){
        $totalextras=0;
        $totalenvio=0;
        foreach(Cart::session('secondary')->getContent() as $cart){   
            if($cart->attributes->extra!=null && count($cart->attributes->extra)>0){
                foreach($cart->attributes->extra as $extra){
                    $totalextras=$totalextras+($extra['price']*$cart->quantity);
                }
            }

            $product = Products::where('id', $cart->id)->first();
            $packaging_unit_quantity = (float) ($product->packaging_unit_quantity ?? 0);
            $quantity_requested = (float) ($cart->quantity ?? 0);
            $shipping_price = (float) ($product->shipping_price ?? 0);

            if ($packaging_unit_quantity > 0) {
                $empaques = ceil($quantity_requested / $packaging_unit_quantity);
            } else {
                // Si el empaque no tiene cantidad definida, asumimos 1 o 0 según tu lógica
                $empaques = 0;
            }

            $totalenvio += $shipping_price * $empaques;
            
        }
        
        //$product_user=$this->groupArray($productos,'user_id');
        
        /**Se insertan los productos de la cotizacion */      
        foreach(Cart::session('secondary')->getContent() as $cart){
            $product=Products::with('user')->where('id',$cart->id)->first();
            $color=null;
            if($cart->attributes->color!=null){
                $datacolor=ProductsColor::find($cart->attributes->color);
                
            }
            $talla=null;
            if($cart->attributes->size!=null){
                $datatalla=ProductsTallas::find($cart->attributes->size);
                $talla=$datatalla->talla;
                
            }
            $seller_id=$product->user_id;
        }
        
         $no_project = Str::uuid()->toString();
        // Recortar si es necesario, aunque esto no es necesario con un UUID
        $no_project = substr($no_project, 0, 36); 

         $imageName = null;
        if ($request->file('vaucher')) {
            $imageName = time().'.'.$request->vaucher->extension();
            $request->vaucher->move(public_path('images/vauchers'), $imageName);
        }

        if($request->payment_method=='PSE, Tarjeta débito o crédito'){

        }

        $project = Projects::create([
            'no_project'=>$no_project ,
            'customer'=>$request->name,
            'date_shopping'=>$request->date_delivery,
            'bussine_id'=>auth()->user()->business_id,
            'email_customer'=>auth()->user()->email,
            'email_customer2'=>$request->email,
            'asesor'=>null,
            'phone_asesor'=>null,
            'information_shopping'=>$request->observation,            
            'seller_id'=>$seller_id,
            'state'=>9,
            'easybuy'=>1,
            'vaucher'=>$imageName,
            'total'=>Cart::getTotal()+$totalextras+$totalenvio,
            'document'=>$request->document,   
            'cellphone'=>$request->cellphone,   
            'address'=>$request->address,   
            'city'=>$request->city,   
            'payment_method'=>$request->payment_method,  
            'status_wompi'=>0,
            'reference'=>'knb_'.$no_project,
            'user_id'=>auth()->user()->id,
            'empresa'=>$request->name_business
        ]);

        ProjectTimeLine::create([
            'project_id'=>$project->id,
            'description'=>'Pedido en Preparación',
            'file'=>null
        ]);

        $fulltotal=Cart::getTotal()+$totalextras+$totalenvio;

         foreach(Cart::session('secondary')->getContent() as $cart){           
            $product=Products::with('user')->where('id',$cart->id)->first();
           $itemproduct=ProjectsProducts::create([
                    'producto'=>$product->name,
                    'price'=>$cart->price,
                    'quantity'=>$cart->quantity,
                    'imagen'=>$cart->attributes->urlfoto,
                    'color_id'=>$cart->attributes->color,
                    'talla_id'=>$cart->attributes->size,
                    'project_id'=>$project->id,
                    'product_id'=>$product->id
            ]);

           
            if($cart->attributes->extra!=null && count($cart->attributes->extra)>0){
                foreach($cart->attributes->extra as $extra){
                    ProjectsProductsExtras::create([
                        'project_id'=>$project->id,
                        'project_item_id'=>$itemproduct->id,
                        'extra_id'=>$extra['id_item'],
                        'price'=>$extra['price'],
                        'quantity'=>$cart->quantity,
                    ]);
                }
            } 
            
        }

        

        Mail::send('admin.projects.templatenewproject', ['project' => $project], function($message) use ($project){
            $message->to($project->email_customer, $project->customer);
            $message->subject('Solicitud Kanbai No. '.$project->no_project);
            $message->from('ventas@kanbai.co','Kanbai');
       });

       $wompi=0;
       if($request->payment_method=='PSE, Tarjeta débito o crédito'){
            $wompi = array(
                'reference'=>'knb_'.$project->no_project,
                'total'=>$fulltotal,
                'email'=>auth()->user()->email,
                'fullName'=>$request->name,
                'phoneNumber'=>$request->cellphone,
                'legalId'=>$request->document
            );
       }
      
        Cart::session('secondary')->clear();
        return json_encode(['success' => true, 'id' => $project->id,'wompi'=>$wompi]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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



   public function updatecart(Request $request) {
    // Verificamos si el carrito es el principal o el secundario
    if ($this->isSecondaryCart()) {
        // Si es el carrito secundario, actualizamos la cantidad en el carrito secundario
        Cart::session('secondary')->update($request->producto_id, [
            'quantity' => $request->quantity, // Actualizamos la cantidad del producto
        ]);
    } else {
        // Si es el carrito principal, actualizamos la cantidad en el carrito principal
        Cart::update($request->producto_id, [
            'quantity' => $request->quantity, // Actualizamos la cantidad del producto
        ]);
    }

    // Recorremos el carrito para actualizar los precios basados en las cantidades
    foreach (Cart::session('primary')->getContent() as $cart) {
        if ($cart->id == $request->producto_id) {

            // Obtener el rango de precios para el producto
            $range = ProductsPriceRange::where('product_id', $request->producto_id)->get();

            // Obtener el producto completo con sus relaciones
            $product = Products::with('productcategories', 'productcategories.category')
                ->with('productsubcategories', 'productsubcategories.subcategory')
                ->with('gallery', 'questions', 'escalas')->find($request->producto_id);
            
            // Precio por defecto del producto
            $price = $product->price;

            // Si hay rangos de precios, ajustamos el precio según la cantidad
            if (count($range) > 0) {
                foreach ($range as $item) {
                    if ($cart->quantity >= $item->quantity_min && $cart->quantity <= $item->quantity_max) {
                        $price = $item->price;
                        break;
                    }
                    if ($cart->quantity > $item->quantity_max) {
                        $price = $item->price;
                    }
                }
            }

            // Actualizamos el precio del producto en el carrito
            if ($this->isSecondaryCart()) {
                // Si es el carrito secundario, actualizamos el precio en el carrito secundario
                Cart::session('secondary')->update($request->producto_id, [
                    'price' => $price, // Actualizamos el precio basado en el rango
                ]);
            } else {
                // Si es el carrito principal, actualizamos el precio en el carrito principal
                Cart::session('primary')->update($request->producto_id, [
                    'price' => $price, // Actualizamos el precio basado en el rango
                ]);
            }
        }
    }

    return json_encode(['success' => true]);
}

    public function updateprice(Request $request){
        $id=$request->producto_id;
        $product = explode("-", $request->producto_id);
        $id_product=$product[0];
        $producto = Products::with('gallery','tamanos')->find($id_product);
        //dd($producto->tamanos[0]->price);
        
        $productsize=ProductSizes::find($request->size);
        Cart::session('primary')->update($id, [
            'price' =>$productsize->price,
            'attributes' =>  array(
                'urlfoto' => $producto->gallery[0]->file,                
            ) // si la cantidad actual del producto es 1, se sumarán 2 items dando como resultado 3
        ]);
        return json_encode(['success' => true]);  

   
    }

    public function removeitem(Request $request) {
      
        //$producto = Producto::where('id', $request->id)->firstOrFail();
        if ($this->isSecondaryCart()) {
            // Si es el carrito secundario, eliminamos el producto del carrito secundario
            Cart::session('secondary')->remove($request->id);
            Session::flash('message', "¡Producto eliminado con éxito del carrito secundario!");
            Session::flash('redirect', '/carrito/secondary');
        } else {
            // Si no es el carrito secundario, eliminamos del carrito principal
            Cart::session('primary')->remove($request->id);
            Session::flash('message', "¡Producto eliminado con éxito de su carrito!");
            Session::flash('redirect', '/carrito');
        }

        return back()->with('success', "Producto eliminado con éxito de su carrito.");
    }

   

    public function removeitemadmin(Request $request) {
        // Verificamos si el carrito es el principal o el secundario
        if ($this->isSecondaryCart()) {
            // Si es el carrito secundario, eliminamos el producto del carrito secundario
            Cart::session('secondary')->remove($request->id);
        } else {
            // Si no es el carrito secundario, eliminamos del carrito principal
            Cart::session('primary')->remove($request->id);
        }

         return json_encode(['success' => true]);
    }

    private function isSecondaryCart() {
        return Cart::session('secondary')->getContent()->count() > 0;
    }
}
