<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Products;
use App\Models\ProductsPriceRange;

class Productos extends Component
{
    use WithPagination;
    public $info;
    public $keyword = '';
    public $shipping_price;
    protected $paginationTheme = 'bootstrap';
    public $pagination = 24;

    public $min_price;
    public $max_price;

    public $start_min;
    public $start_max;

    public function mount(){
        $this->min_price=ProductsPriceRange::min('price');
        $this->max_price=ProductsPriceRange::max('price');

        $this->start_min=ProductsPriceRange::min('price');
        $this->start_max=ProductsPriceRange::max('price');
    }


public $searchResults = [];

public function updatedKeyword($value)
{
    // Solo buscar si hay más de 2 letras
    if (strlen($value) >= 3) {
        $this->searchResults = Products::where('state', 1)
            ->where(function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%")
                  ->orWhere('description', 'like', "%{$value}%");
            })
            ->with('gallery')
            ->limit(5)
            ->get();
    } else {
        $this->searchResults = [];
    }
}


    public function render()
    {   

       
        switch ($this->keyword) {            
            case 1:
                if($this->info['subcategory_id']==null){
                    if($this->shipping_price===null){
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }else{
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }
                    
        
                }else{
                    if($this->shipping_price===null){
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }else{
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }
                    
                }                
                break;
            case 2:
                if($this->info['subcategory_id']==null){
                    if($this->shipping_price===null){
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productcategories','category_id',$this->info['category_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }else{
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productcategories','category_id',$this->info['category_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }
                    
        
                }else{
                    if($this->shipping_price===null){
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }else{
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }
                    
                }
                break;
            case 3:
                if($this->info['subcategory_id']==null){
                    if($this->shipping_price===null){
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productcategories','category_id',$this->info['category_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->orderBy('price', 'ASC')->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }else{
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productcategories','category_id',$this->info['category_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->orderBy('price', 'ASC')
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }
                    
            
                }else{
                    if($this->shipping_price===null){
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->orderBy('price', 'ASC')->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }else{
                        return view('livewire.products',[
                            'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                            ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                            ->whereHas('escalas', function ($query){
                                $query->whereBetween('price', [$this->min_price,$this->max_price])
                                ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                            })
                            ->orderBy('price', 'ASC')
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                        ]);
                    }
                    
                }
                break;
                case 4:
                    if($this->info['subcategory_id']==null){
                        if($this->shipping_price===null){
                            return view('livewire.products',[
                                'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                                ->whereRelation('productcategories','category_id',$this->info['category_id'])
                                ->whereHas('escalas', function ($query){
                                    $query->whereBetween('price', [$this->min_price,$this->max_price])
                                    ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                                })
                                ->orderBy('price', 'ASC')->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                            ]);
                        }else{
                            return view('livewire.products',[
                                'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                                ->whereRelation('productcategories','category_id',$this->info['category_id'])
                                ->whereHas('escalas', function ($query){
                                    $query->whereBetween('price', [$this->min_price,$this->max_price])
                                    ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                                })
                                ->orderBy('price', 'ASC')
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                            ]);
                        }
                        
                
                    }else{
                        if($this->shipping_price===null){
                            return view('livewire.products',[
                                'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                                ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                                ->whereHas('escalas', function ($query){
                                    $query->whereBetween('price', [$this->min_price,$this->max_price])
                                    ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                                })
                                ->orderBy('price', 'ASC')->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                            ]);
                        }else{
                            return view('livewire.products',[
                                'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                                ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                                ->whereHas('escalas', function ($query){
                                    $query->whereBetween('price', [$this->min_price,$this->max_price])
                                    ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                                })
                                ->orderBy('price', 'ASC')
                            ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                            ]);
                        }
                        
                    }
                break;
            default:
            if($this->info['search']!=null){
                return view('livewire.products',[
                    'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                    ->whereHas('escalas', function ($query){
                        $query->whereBetween('price', [$this->min_price,$this->max_price])
                        ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                    })->where('name', 'LIKE', '%'.$this->info["search"].'%')
                    ->orWhere('description', 'LIKE', '%'.$this->info["search"].'%')
                    ->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                ]);
            }

            if($this->info['subcategory_id']==null){
                if($this->shipping_price===null){
                    return view('livewire.products',[
                        'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                        ->whereRelation('productcategories','category_id',$this->info['category_id'])
                        ->whereHas('escalas', function ($query){
                            $query->whereBetween('price', [$this->min_price,$this->max_price])
                            ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                        })->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                    ]);
                }else{
                    return view('livewire.products',[
                        'products' => Products::where('state',1)->with('productcategories','productcategories.category','gallery','user','escalas','colores','tallas')
                        ->whereRelation('productcategories','category_id',$this->info['category_id'])
                        ->whereHas('escalas', function ($query){
                            $query->whereBetween('price', [$this->min_price,$this->max_price])
                            ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                        })
                        ->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                    ]);
                }
                
    
            }else{
                if($this->shipping_price===null){                    
                    
                    return view('livewire.products',[
                        'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                        ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                        ->whereHas('escalas', function ($query){
                            $query->whereBetween('price', [$this->min_price,$this->max_price])
                            ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                        })->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                    ]);
                }else{
                    return view('livewire.products',[
                        'products' => Products::where('state',1)->with('productsubcategories','productsubcategories.subcategory','gallery','user','escalas','colores','tallas')
                        ->whereRelation('productsubcategories','subcategory_id',$this->info['subcategory_id'])
                        ->whereHas('escalas', function ($query){
                            $query->whereBetween('price', [$this->min_price,$this->max_price])
                            ->orwhereBetween('price',[$this->min_price,$this->max_price])->orderBy('price', 'asc');
                        })->where('shipping_free',$this->shipping_price)->orderByDesc('created_at')->orderByDesc('views')->paginate($this->pagination),
                    ]);
                }
                
            }
        }

        
        
    }

    
}
