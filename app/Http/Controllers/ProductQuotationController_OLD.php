<?php

namespace App\Http\Controllers;

use App\Models\ProductQuotation;
use Illuminate\Http\Request;
use App\Models\Products;

use App\Models\Log\LogSistema;

class ProductQuotationController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Cotizaciones')->only('index');
        $this->middleware('permission:Editar Cotizaciones')->only('update');
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
            $quotations = ProductQuotation::where('user_id',auth()->user()->id)->with('producto')->get();
        }else{            
            $quotations = ProductQuotation::with('producto')->get();
        }
        return view ('admin.quotations.index', compact('quotations'));
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
        $product=Products::with('user')
        ->where('id',$request->product_id)->first();
        $cotizacion = ProductQuotation::create([
            'product_id'=>$request->product_id,
            'email'=>$request->email,
            'name'=>$request->name,
            'cellphone'=>$request->cellphone,
            'quantity'=>$request->quantity,
            'address'=>$request->address,
            'date_delivery'=>$request->date_delivery,
            'observations'=>$request->observations,
            'user_id'=>$product->user->id,
                             
        ]);
        return json_encode(['success' => true, 'id' => $cotizacion->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductQuotation $productQuotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = ProductQuotation::with('producto')->find(\Hashids::decode($id)[0]);

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la cotizacion: '.$quotation->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
       
        return view('admin.quotations.edit', ['quotation' => $quotation]);
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
        $productquotation = ProductQuotation::find(\Hashids::decode($id)[0]);
        $productquotation->state = $request->state;     
        $productquotation->save();

        return json_encode(['success' => true, 'campuse_id' => $productquotation->encode_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductQuotation  $productQuotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = ProductQuotation::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
}
