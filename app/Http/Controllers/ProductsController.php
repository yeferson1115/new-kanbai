<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\Categories;
use App\Models\ProductsGallery;
use App\Models\ProductsCategories;
use App\Models\ProductsSubcategories;
use App\Models\SubCategories;
use App\Models\User;
use App\Models\ProductsQuestions;
use App\Models\ProductsPriceRange;
use App\Models\ProductsColor;
use App\Models\ProductsTallas;
use App\Models\ProductsAdditional;
use App\Models\ProductsExtra;
use App\Models\ProductsExtrasItems;

use Illuminate\Support\Str;

use Image;

use Cart;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Ver Productos')->only('index');
        $this->middleware('permission:Crear Productos')->only('create');
        $this->middleware('permission:Crear Productos')->only('store');
        $this->middleware('permission:Editar Productos')->only('update');
        $this->middleware('permission:Editar Productos')->only('edit');
        $this->middleware('permission:Eliminar Productos')->only('destroy');
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
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los productos: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        if(auth()->user()->hasrole('Comercio')){
            $products = Products::where('user_id',auth()->user()->id)->where('state','!=',9)
            ->with('productcategories','productcategories.category')
            ->with('productsubcategories','productsubcategories.subcategory')->with('gallery','user')->get();
        }else{
            $products = Products::where('state','!=',9)->with('productcategories','productcategories.category')
            ->with('productsubcategories','productsubcategories.subcategory')
            ->with('gallery','user')->get();
        }
       
        
        return view ('admin.products.index', compact('products'));
    }

    public function aprovecreate(){
        $products = Products::with('productcategories','productcategories.category')
            ->with('productsubcategories','productsubcategories.subcategory')
            ->with('gallery','user')->where('state',2)->get();
        return view ('admin.products.aproveproducts', compact('products')); 
    }

    public function deleteproduct(){
        $products = Products::with('productcategories','productcategories.category')
            ->with('productsubcategories','productsubcategories.subcategory')
            ->with('gallery','user')->where('state',0)->get();
        return view ('admin.products.deleteproducts', compact('products')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::with('subcategories')->get();       
        $relacionEloquent = 'roles';
        if(auth()->user()->hasrole('Comercio')){            
            $comercios = User::where('id',auth()->user()->id)->get();
        }else{
            $comercios = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Comercio');
            })->get();
        }
        
        return view ('admin.products.create', compact('categories','comercios'));
    }

    public function aprobar(Request $request){
        $product = Products::find(\Hashids::decode($request->product_id)[0]);
        $product->state=$request->state;
        $product->save();
        $mensaje='';
        if($request->state==1){
            $mensaje='Aprobado';
        }
        if($request->state==3){
            $mensaje='Rechazado';
        }
        return json_encode(['success' => true,'message'=>$mensaje]);
    }

    public function eliminar(Request $request){
        $product = Products::find(\Hashids::decode($request->product_id)[0]);
        $product->state=$request->state;
        $product->save();
        $mensaje='';
        if($request->state==9){
            $mensaje='Eliminado';
        }
        if($request->state==1){
            $mensaje='Rechazado';
        }
        return json_encode(['success' => true,'message'=>$mensaje]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->shipping_price && $request->shipping_price!=0){
            $shipping_free=false;
        }else{
            $shipping_free=true;
        }
        $state=1;
        if(auth()->user()->hasrole('Comercio')){
            $state=2;
        }else{
            $state=$request->state;
        }
        
        
        $product = Products::create([
                'name'=>$request->name,
                'price'=>$request->price,
                'quantity_min'=>$request->quantity_min,
                'delivery_time'=>$request->delivery_time,
                'shipping_price'=>$request->shipping_price,
                'description'=>$request->description_render,
                'shipping_free'=>$shipping_free,
                'user_id'=>$request->user_id,
                'state'=>$state,
                'easybuy'=>$request->easybuy,
                'new'=>1,
                'iva'=>$request->iva,
                'packaging_unit_quantity'=>$request->packaging_unit_quantity
        ]);
        if($request->file('image')){
            
            foreach($request->file('image') as $image){
                $nametem=Str::random(7);
                $imagen = Image::make($image);
                $imageName = time().'_'.$nametem.'.'.$image->extension();

                $destinationPath = public_path('/thumbnail');
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/products/' . $imageName));
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/products/thumbnail/list/' . $imageName));
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/products/thumbnail/' . $imageName));
                
                $productgallery = ProductsGallery::create([
                    'file'=>$imageName,
                    'product_id'=>$product->id
                ]);

            }
        }
        if(isset($request->category_id)){
        foreach($request->category_id as $category){
           ProductsCategories::create([
                'category_id'=>$category,
                'product_id'=>$product->id
            ]);
        }
    }
        if(isset($request->subcategory_id)){
        foreach($request->subcategory_id as $subcategory){
            ProductsSubcategories::create([
                 'subcategory_id'=>$subcategory,
                 'product_id'=>$product->id
             ]);
         }
        }
         ProductsQuestions::where('product_id',$product->id )->delete();
         if(isset($request->question)){
             foreach($request->question as $key=>$item){
                 ProductsQuestions::create([
                     'question'=>$item,
                     'answer'=>$request->answer[$key],
                     'product_id'=>$product->id
                 ]);
             }
         }

         ProductsColor::where('product_id',$product->id )->delete();
        if(isset($request->color)){
            foreach($request->color as $key=>$item){
                ProductsColor::create([
                    'color'=>$item,
                    'product_id'=>$product->id
                ]);
            }
        }

        ProductsTallas::where('product_id',$product->id )->delete();
        if(isset($request->tallas)){
            foreach($request->tallas as $key=>$item){
                ProductsTallas::create([
                    'talla'=>$item,
                    'product_id'=>$product->id
                ]);
            }
        }

        if(isset($request->extra_id)){
            foreach($request->extra_id as $key=>$item){
                ProductsAdditional::create([
                    'product_extra_id'=>$item,
                    'product_id'=>$product->id
                ]);
                $extra=ProductsExtra::find($item);
                $extra->product_id=$product->id;
                $extra->state=1;
                $extra->save();
                
            }
        }



         ProductsPriceRange::where('product_id',$product->id )->delete();
        if(isset($request->price_escala)){
            foreach($request->price_escala as $key=>$item){
                ProductsPriceRange::create([
                    'price'=>$item,
                    'quantity_min'=>$request->quantity_min_escala[$key],
                    'quantity_max'=>$request->quantity_max[$key],
                    'product_id'=>$product->id
                ]);
            }
        }
         
        

        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha guardado un nuevo cachorro en el sistema: '.$request->title.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true, 'id' => $product->encode_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dogs  $dogs
     * @return \Illuminate\Http\Response
     */
    public function show(Dogs $dogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dogs  $dogs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::with('productcategories','productcategories.category')
        ->with('productsubcategories','productsubcategories.subcategory')
        ->with('gallery','questions','escalas','colores','tallas','adicional','adicional.extra','adicional.extra.items','extras','extras.items','extras.items.values')->find(\Hashids::decode($id)[0]);

      
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos del producto: '.$product->name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $categories = Categories::with('subcategories')->get();
        $relacionEloquent = 'roles';
        if(auth()->user()->hasrole('Comercio')){            
            $comercios = User::where('id',auth()->user()->id)->get();
        }else{
            $comercios = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Comercio');
            })->get();
        }
        return view('admin.products.edit', ['product' => $product,'categories' => $categories,'comercios'=>$comercios]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        
        if($request->shipping_price && $request->shipping_price!=0){
            $shipping_free=false;
        }else{
            $shipping_free=true;
        }
        $product = Products::find(\Hashids::decode($request->id)[0]);
        if($product->state==3){
            $product->state=2;
        }else{
            $product->state=$request->state;
        }
    
        $product->name=$request->name;
        $product->price=$request->price;
        $product->quantity_min=$request->quantity_min;
        $product->delivery_time=$request->delivery_time;
        $product->shipping_price=$request->shipping_price;
        $product->description=$request->description;
        $product->shipping_free=$shipping_free;
        $product->user_id=$request->user_id;
        $product->easybuy=$request->easybuy;
        $product->iva=$request->iva;
        $product->packaging_unit_quantity=$request->packaging_unit_quantity;
        
        $product->save();

        if($request->file('image')){       
            foreach($request->file('image') as $image){
                $nametem=Str::random(7);
                $imageName = time().'_'.$nametem.'.'.$image->extension();
                $imagen = Image::make($image);
                $destinationPath = public_path('/thumbnail');
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/products/' . $imageName));
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/products/thumbnail/' . $imageName));
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/products/thumbnail/list/' . $imageName));

                $doggallery = ProductsGallery::create([
                    'file'=>$imageName,
                    'product_id'=>$product->id
                ]);
            }
        }

        ProductsCategories::where('product_id',$product->id )->delete();
        if(isset($request->category_id)){
            foreach($request->category_id as $category){
                ProductsCategories::create([
                    'category_id'=>$category,
                    'product_id'=>$product->id
                ]);
            }
        }

         ProductsSubcategories::where('product_id',$product->id )->delete();
         if(isset($request->subcategory_id)){
            foreach($request->subcategory_id as $subcategory){
                ProductsSubcategories::create([
                     'subcategory_id'=>$subcategory,
                     'product_id'=>$product->id
                 ]);
             }
         }

         ProductsQuestions::where('product_id',$product->id )->delete();
        if(isset($request->question)){
            foreach($request->question as $key=>$item){
                ProductsQuestions::create([
                    'question'=>$item,
                    'answer'=>$request->answer[$key],
                    'product_id'=>$product->id
                ]);
            }
        }

        ProductsColor::where('product_id',$product->id )->delete();
        if(isset($request->color)){
            foreach($request->color as $key=>$item){
                if($request->file('image_color_'.$key)){ 

                    $nametem=Str::random(7);
                    $imageName = time().'_'.$nametem.'.'.$request->file('image_color_'.$key)->extension();
                    $imagen = Image::make($request->file('image_color_'.$key));
                    $imagen->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(public_path('images/products/color/' . $imageName));
                }elseif($request->input('image_color_old_'.$key)){
                    $imageName=$request->input('image_color_old_'.$key);
                }else{
                    $imageName=null;
                }
                
                ProductsColor::create([
                    'color'=>$item,
                    'name_color'=>$request->name_color[$key],
                    'product_id'=>$product->id,
                    'file'=>$imageName
                ]);
            }
        }

        ProductsTallas::where('product_id',$product->id )->delete();
        if(isset($request->tallas)){
            foreach($request->tallas as $key=>$item){
                ProductsTallas::create([
                    'talla'=>$item,
                    'product_id'=>$product->id
                ]);
            }
        }

        ProductsAdditional::where('product_id',$product->id )->delete();
        if(isset($request->extra_id)){
            foreach($request->extra_id as $key=>$item){
                ProductsAdditional::create([
                    'product_extra_id'=>$item,
                    'product_id'=>$product->id
                ]);
                $extra=ProductsExtra::find($item);
                $extra->product_id=$product->id;
                $extra->state=1;
                $extra->save();
                
            }
        }

        ProductsPriceRange::where('product_id',$product->id )->delete();
        if(isset($request->price_escala)){
            foreach($request->price_escala as $key=>$item){
                ProductsPriceRange::create([
                    'price'=>$item,
                    'quantity_min'=>$request->quantity_min_escala[$key],
                    'quantity_max'=>$request->quantity_max[$key],
                    'product_id'=>$product->id
                ]);
            }
        }
         

        return json_encode(['success' => true, 'customer_id' => $product->encode_id]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dogs  $dogs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(auth()->user()->hasrole('Comercio')){
            $product = Products::find(\Hashids::decode($id)[0]);
            $product->state=0;
            $product->save();
            return json_encode(['success' => true]);
        }
        $product = Products::find(\Hashids::decode($id)[0]);
        $gallery=ProductsGallery::where('product_id',$product->id)->get();

        foreach($gallery as $item){
            $image_path = public_path().'/images/products/'.$item->file;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            ProductsGallery::find($item->id)->delete();
        }
        ProductsCategories::where('product_id',$product->id )->delete();
        ProductsSubcategories::where('product_id',$product->id )->delete();
        Products::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }

    public function productsByCategory($category){
        $categorydata = Categories::with('banners','bannerscommerce','imagesattributes')->where('slug',$category)->first();
        
       
        $products=Products::with('productcategories','productcategories.category','gallery')
        ->whereRelation('productcategories','category_id',$categorydata->id)
        ->orderBy('views', 'DESC')->get();
        
        $categories=SubCategories::where('category_id',$categorydata->id)->where('state',1)->get();

        
        $info=array(
            'category_id'=>$categorydata->id, 
            'namecategory'=>$categorydata->name, 
            'slugcategory'=>$categorydata->slug, 
            'namesubcategory'=>null, 
            'slugsubcategory'=>null,
            'subcategory_id'=>null, 
            'banners'=>$categorydata->banners,
            'bannerscommerce'=>$categorydata->bannerscommerce,
            'imagesattributes'=>$categorydata->imagesattributes,
            'search'=>null
        );
        
        
        return view ('site.products.list', compact('products','info','categories'));
    }

    public function serachproduct($search){
        $products=Products::with('productcategories','productcategories.category','gallery')->where('name', 'LIKE', '%'.$search.'%')->get();
        $categories=Categories::where('state',1)->get();
        $info=array(
            'category_id'=>null, 
            'namecategory'=>str_replace('+', ' ', $search), 
            'slugcategory'=>null, 
            'namesubcategory'=>null, 
            'slugsubcategory'=>null,
            'subcategory_id'=>null, 
            'banners'=>null,
            'bannerscommerce'=>null,
            'imagesattributes'=>null,
            'search'=>str_replace('+', ' ', $search)

        );
        
        return view ('site.products.list', compact('products','info','categories'));

    }

    public function productsBySubCategory($category,$subcategory){
        $categorydata = Categories::with('banners','bannerscommerce','imagesattributes')->where('slug',$category)->first();
        $categories=SubCategories::where('category_id',$categorydata->id)->where('state',1)->get();
        $subcategorydata = SubCategories::with('banners')->where('slug',$subcategory)->first();
        

        $products=Products::with('productsubcategories','productsubcategories.subcategory','gallery')->whereRelation('productsubcategories','subcategory_id',$subcategorydata->id)->get();
        
        $info=array(
            'category_id'=>$categorydata->id, 
            'namecategory'=>$categorydata->name, 
            'slugcategory'=>$categorydata->slug, 
            'namesubcategory'=>$subcategorydata->name, 
            'slugsubcategory'=>$subcategorydata->slug, 
            'subcategory_id'=>$subcategorydata->id, 
            'banners'=>$subcategorydata->banners,
            'bannerscommerce'=>$categorydata->bannerscommerce,
            'imagesattributes'=>$categorydata->imagesattributes,
            'search'=>null


        );
        return view ('site.products.list', compact('products','info','categories'));
    }

    public function productsByid($productoid,$nameproduct){
        if(filter_var($productoid, FILTER_VALIDATE_INT)===false){
            abort(404);
        }
        $product=Products::with('productcategories','productcategories.category','gallery','user','questions','escalas','colores','tallas','adicional','adicional.extra','adicional.extra.items')
        ->where('id',filter_var($productoid, FILTER_VALIDATE_INT))->first();
        $viewsold=$product->views;
        /**Agregar visita */
        $product->views=$viewsold+1;
        $product->save();


        $categories = array();
        foreach ($product->productcategories as $item){                                      
            array_push($categories, $item->category_id);
         }

         $cantidadminima=ProductsPriceRange::where('product_id',$product->id)->min('quantity_min');
         $pricemax=ProductsPriceRange::where('product_id',$product->id)->max('price');
        

         $related=Products::with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
         ->whereHas('productcategories', function($query) use($categories)
         {
            $query->whereIn('category_id', $categories);
         })->whereHas('escalas', function ($query){
            $query->where('price','>',0);
        })->where('id','!=',$product->id)->orderBy('updated_at', 'desc')->get(); 
         
        
        return view ('site.products.product', compact('product','related','cantidadminima','pricemax'));
    }

    public function quotation($productoid){
        $product=Products::with('productcategories','productcategories.category','gallery','user')
        ->where('id',filter_var($productoid, FILTER_VALIDATE_INT))->first();
       
        return view ('site.quotation.create', compact('product'));
    }

    public function add(Request $request){
        
        $range=ProductsPriceRange::where('product_id',$request->producto_id)->get();
        $product = Products::with('productcategories','productcategories.category')
        ->with('productsubcategories','productsubcategories.subcategory')
        ->with('gallery','questions','escalas')->find($request->producto_id);
        $price=0;
        
        if(count($range)>0){
            foreach($range as $item){
                    if($request->quantity>=$item->quantity_min && $request->quantity<=$item->quantity_max){ 
                        $price=$item->price;
                        break;
                    }
                    if($request->quantity>$item->quantity_max){
                        $price=$item->price;
                    }
            }
        }else{
            $price=$product->price;
        }
        if($price==0){
            $price=$product->price;
        }

        $priceExtra=0;
        $arrayExtra=array();
        $cantidad=$request->quantity?$request->quantity:1;
        if(isset($request->extras)){
            foreach($request->extras as $key=>$item){
                if($item!=''){
                    $extra=ProductsExtrasItems::with('extra','values')->find($item);                  
                    $totalExtras = 0;
                    if (!$extra) continue;

                    // Buscar el valor correcto según qty_min / qty_max
                    foreach ($extra->values as $v) {
                        if ($cantidad >= $v->qty_min && $cantidad <= $v->qty_max) {
                            $totalExtras += $v->price;
                            break;
                        }
                    }

                    $priceExtra=$priceExtra+$totalExtras;
                    array_push($arrayExtra,array(
                        'extra'=>$extra->extra->name,
                        'id_item'=>$extra->id,
                        'name'=>$extra->name,
                        'price'=>$totalExtras
                    ));
                }
                
            }
        }

       
        Cart::session('primary')->add(
            array(
                'id' => $product->id, // inique row ID
                'name' => $product->name,
                'price' =>$price,
                'quantity' => $request->quantity?$request->quantity:1,
                'attributes' => array(
                    'urlfoto' => $product->gallery[0]->file,
                    'color'=>$request->color,
                    'size'=>$request->size,
                    'extra'=>$arrayExtra
                )
            ) 
        );
        
        return json_encode(['success' => true,'message_cart'=>"$product->name, ¡ Se ha agregado con éxito al carrito!"]);
    }

    public function addmobile(Request $request){
        
        
        $range=ProductsPriceRange::where('product_id',$request->producto_id)->get();
        $product = Products::with('productcategories','productcategories.category')
        ->with('productsubcategories','productsubcategories.subcategory')
        ->with('gallery','questions','escalas')->find($request->producto_id);
        $price=0;
        
        if(count($range)>0){
            foreach($range as $item){
                    if($request->quantity_m>=$item->quantity_min && $request->quantity_m<=$item->quantity_max){ 
                        $price=$item->price;
                        break;
                    }
            }
        }else{
            $price=$product->price;
        }
        if($price==0){
            $price=$product->price;
        }

        $priceExtra=0;
        $arrayExtra=array();
        $cantidad=$request->quantity_m?$request->quantity_m:1;

        if(isset($request->extras)){
            foreach($request->extras as $key=>$item){
                if($item!=''){
                $extra=ProductsExtrasItems::with('extra','values')->find($item);                  
                    $totalExtras = 0;
                    if (!$extra) continue;

                    // Buscar el valor correcto según qty_min / qty_max
                    foreach ($extra->values as $v) {
                        if ($cantidad >= $v->qty_min && $cantidad <= $v->qty_max) {
                            $totalExtras += $v->price;
                            break;
                        }
                    }

                    $priceExtra=$priceExtra+$totalExtras;
                array_push($arrayExtra,array(
                    'extra'=>$extra->extra->name,
                    'id_item'=>$extra->id,
                    'name'=>$extra->name,
                    'price'=>$totalExtras
                ));
                
            }
            }
        }
        
        Cart::session('primary')->add(
            array(
                'id' => $product->id, // inique row ID
                'name' => $product->name,
                'price' =>$price,
                'quantity' => $request->quantity_m?$request->quantity_m:1,
                'attributes' => array(
                    'urlfoto' => $product->gallery[0]->file,
                    'color'=>$request->color,
                    'size'=>$request->size,
                    'extra'=>$arrayExtra
                )
            ) 
        );
        return json_encode(['success' => true,'message_cart'=>"$product->name, ¡ Se ha agregado con éxito al carrito!"]);
        
    }
    public function getprice__(Request $request){
        $range=ProductsPriceRange::where('product_id',$request->producto_id)->get();
        $product = Products::with('productcategories','productcategories.category')
        ->with('productsubcategories','productsubcategories.subcategory')
        ->with('gallery','questions','escalas')->find($request->producto_id);
        $price=0;
        
        if(count($range)>0){
            foreach($range as $item){
                    if($request->quantity>=$item->quantity_min && $request->quantity<=$item->quantity_max){ 
                        $price=$item->price;
                        break;
                    }
            }
        }else{
            $price=$product->price;
        }
        if($price==0){
            $price=$product->price;
        }

        return json_encode(['success' => true,'price'=>$price]);
       

    }


public function getprice(Request $request)
{
    $productoId = $request->producto_id;
    $cantidad   = $request->quantity;
    $extras     = array_filter($request->extras ?? []); // siempre array limpio

    // 1. Consultar producto y sus rangos
    $ranges = ProductsPriceRange::where('product_id', $productoId)->get();
    $product = Products::find($productoId);

    // 2. Obtener precio base por cantidad
    $priceBase = 0;

    if ($ranges->count() > 0) {
        foreach ($ranges as $r) {
            if ($cantidad >= $r->quantity_min && $cantidad <= $r->quantity_max) {
                $priceBase = $r->price;
                break;
            }
        }
    }

    // Si no encontró rango o está en 0, tomar precio base del producto
    if ($priceBase == 0) {
        $priceBase = $product->price;
    }

    // 3. Calcular precio de EXTRAS
    $totalExtras = 0;

    if (!empty($extras)) {

        foreach ($extras as $itemId) {

            // Obtener item extra
            $item = ProductsExtrasItems::with('values')
                ->where('id', $itemId)
                ->first();

            if (!$item) continue;

            // Buscar el valor correcto según qty_min / qty_max
            foreach ($item->values as $v) {
                if ($cantidad >= $v->qty_min && $cantidad <= $v->qty_max) {
                    $totalExtras += $v->price;
                    break;
                }
            }
        }
    }

    // 4. Sumar precios
    $precioTotalUnidad = $priceBase + $totalExtras;
    return json_encode(['success' => true,'price'=>$precioTotalUnidad]);
   /* return response()->json([
        'success' => true,
        'price' => $precioTotalUnidad, // precio por unidad
    ]);*/
}


    public function easybuy(Request $request){
        
        $range=ProductsPriceRange::where('product_id',$request->producto_id)->get();
        $product = Products::with('productcategories','productcategories.category')
        ->with('productsubcategories','productsubcategories.subcategory')
        ->with('gallery','questions','escalas')->find($request->producto_id);
        $price=0;
        
        
        $quantity = $request->quantity ?? $request->quantity_m ?? 1; // Usar la cantidad válida

        if (count($range) > 0) {
            foreach ($range as $item) {
                if ($quantity >= $item->quantity_min && $quantity <= $item->quantity_max) { 
                    $price = $item->price;
                    break;
                }

                if ($quantity > $item->quantity_max) {
                    $price = $item->price;
                }
            }
        } else {
            $price = $product->price;
        }
        if($price==0){
            $price=$product->price;
        }

        $priceExtra=0;
        $arrayExtra=array();

        $quantity = $request->quantity ?? $request->quantity_m ?? 1;

        if(isset($request->extras)){
            foreach($request->extras as $key=>$item){
                if($item!=''){
                    $extra=ProductsExtrasItems::with('extra','values')->find($item);                  
                    $totalExtras = 0;
                    if (!$extra) continue;

                    // Buscar el valor correcto según qty_min / qty_max
                    foreach ($extra->values as $v) {
                        if ($quantity >= $v->qty_min && $quantity <= $v->qty_max) {
                            $totalExtras += $v->price;
                            break;
                        }
                    }

                    $priceExtra=$priceExtra+$totalExtras;
                    array_push($arrayExtra,array(
                        'extra'=>$extra->extra->name,
                        'id_item'=>$extra->id,
                        'name'=>$extra->name,
                        'price'=>$totalExtras
                    ));
                }
                
            }
        }else{
           $arrayExtra=null; 
        }
        

        
        Cart::session('secondary')->add(
            array(
                'id' => $product->id, // inique row ID
                'name' => $product->name,
                'price' =>$price,
                'quantity' => $quantity,
                'attributes' => array(
                    'urlfoto' => $product->gallery[0]->file,
                    'color'=>$request->color,
                    'size'=>$request->size,
                    'extra' => $arrayExtra,
                )
            ) 
        );
        
        
        return response()->json([
        'success' => true,
        'message_cart' => "$product->name, ¡Se ha agregado con éxito al carrito!",     
        'easybuy'=>1
        ]);
    }
    


public function searchAjax(Request $request)
{
    $keyword = $request->get('q');

    if (strlen($keyword) < 3) {
        return response()->json([]);
    }

    $products = Products::with('gallery','productcategories','productcategories.category')
        ->where('name', 'LIKE', "%$keyword%")
        ->limit(10)
        ->get();

    $results = $products->map(function ($product) {
        // imagen
        $imageName = $product->gallery->first()->file ?? null;
        $imagePath = $imageName 
            ? asset('images/products/thumbnail/'.$imageName) 
            : asset('images/no-image.png');

        // categoría (si existe la primera asociada)
        $categoryName = optional($product->productcategories->first()->category ?? null)->name;

        return [
            'id'       => $product->id,
            'name'     => $product->name,
            'category' => $categoryName ?? 'Sin categoría',
            'image'    => $imagePath,
            'url'      => url('catalogo/producto/'.$product->id.'/'.Str::slug($product->name)),
        ];
    });

    return response()->json($results);
    }
}
