<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\SubCategories;
use App\Models\Categories;
use App\Models\ProductsSubcategories;
use App\Models\SubCategoriesBanners;

use Illuminate\Support\Str;

use Image;

class SubcategoriesController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Categorías')->only('index');
        $this->middleware('permission:Crear Categoría')->only('create');
        $this->middleware('permission:Crear Categoría')->only('store');
        $this->middleware('permission:Editar Categoría')->only('update');
        $this->middleware('permission:Editar Categoría')->only('edit');
        $this->middleware('permission:Eliminar Categoría')->only('destroy');
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
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los servicios: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $subcategories = SubCategories::with('category')->get();
        return view ('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesmodel = new Categories();
        $categories=$categoriesmodel->all();
        return view ('admin.subcategories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = time().'.'.$request->file->extension();
        $request->file->move(public_path('images/subcategories'), $imageName);
        $url=strtolower($request->name);
        $url=str_replace(" ", "-", $url);
       
        $subcategories = SubCategories::create([
                'name'=>$request->name,
                'category_id'=>$request->category_id,
                'file'=>$imageName,
                'slug'=>$url,
                'state'=>$request->state,
                                 
            ]);

            if($request->file('banners')){
                $links=$request->links;
                foreach($request->file('banners') as $key=>$image){
                    $nametem=Str::random(7);
                    $imageName = time().'_sub_'.$nametem.'_'.$image->getClientOriginalName();
                    $imagen = Image::make($image);
                    $imagen->save(public_path('images/categories/banners/' . $imageName));
                   
                    $banners = SubCategoriesBanners::create([
                        'file'=>$imageName,
                        'subcategory_id'=>$subcategories->id,
                        'url'=>$links[$key],
                        'type'=>1                               
                    ]); 
                }
    
            }
    
            if($request->file('bannersmobile')){
                $links=$request->linksmobile;
                foreach($request->file('bannersmobile') as $key=>$image){
                    $nametem=Str::random(7);
                    $imageName = time().'_sub_'.$nametem.'_'.$image->getClientOriginalName();
                    $imagen = Image::make($image);
                    $imagen->save(public_path('images/categories/banners/' . $imageName));
                   
                    $banners = SubCategoriesBanners::create([
                        'file'=>$imageName,
                        'subcategory_id'=>$subcategories->id,
                        'url'=>$links[$key],
                        'type'=>2                               
                    ]); 
                }
    
            }
            



        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha guardado una nueva sub categoría en el sistema: '.$request->name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true, 'id' => $subcategories->encode_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = SubCategories::with('banners')->find(\Hashids::decode($id)[0]);
        $categoriesmodel = new Categories();
        $categories=$categoriesmodel->all();

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la sub categoría: '.$subcategory->name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        return view('admin.subcategories.edit', ['subcategory' => $subcategory,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $subcategory = SubCategories::find(\Hashids::decode($request->id)[0]);
        if ($request->file('file')) {
            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images/subcategories'), $imageName);

            $image_path = public_path().'/images/subcategories/'.$subcategory->file;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $subcategory->file = $imageName;

        }

        if($request->file('banners')){
            $links=$request->links;
            foreach($request->file('banners') as $key=>$image){
                $nametem=Str::random(7);
                $imageName = time().'_sub_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/banners/' . $imageName));
               
                $banners = SubCategoriesBanners::create([
                    'file'=>$imageName,
                    'subcategory_id'=>\Hashids::decode($request->id)[0],
                    'url'=>$links[$key],
                    'type'=>1                               
                ]); 
            }

        }

        if($request->file('bannersmobile')){
            $links=$request->linksmobile;
            foreach($request->file('bannersmobile') as $key=>$image){
                $nametem=Str::random(7);
                $imageName = time().'_sub_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/banners/' . $imageName));
               
                $banners = SubCategoriesBanners::create([
                    'file'=>$imageName,
                    'subcategory_id'=>\Hashids::decode($request->id)[0],
                    'url'=>$links[$key],
                    'type'=>2                               
                ]); 
            }

        }

        $url=strtolower($request->name);
        $url=str_replace(" ", "-", $url);
        $subcategory->name=$request->name;   
        $subcategory->slug=$url;  
        $subcategory->state=$request->state;  
        $subcategory->category_id=$request->category_id;   
        $subcategory->save();

        return json_encode(['success' => true, 'customer_id' => $subcategory->encode_id]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategories::find(\Hashids::decode($id)[0]);
        $image_path = public_path().'/images/subcategories/'.$subcategory->file;
        if (@getimagesize($image_path)) {
            unlink($image_path);
        }

        ProductsSubcategories::where('subcategory_id',$subcategory->id)->delete();
        SubCategories::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }

    public function dogsByCategory($category){
        $dogs = Categories::with('dogs','dogs.gallery')->where('url',$category)->first();
        return view ('app.subcategories.index', compact('dogs'));
    }
}
