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
    public $min_price;
    public $max_price;
    public $start_min;
    public $start_max;
    public $quantity;
    public $immediate_delivery = false;
    public $customizable = false;
    public $searchResults = [];

    protected $paginationTheme = 'bootstrap';
    public $pagination = 24;

    public function mount()
    {
        $this->start_min = ProductsPriceRange::min('price') ?? 1;
        $this->start_max = ProductsPriceRange::max('price') ?? 10000000;
        $this->min_price = $this->start_min;
        $this->max_price = $this->start_max;
    }

    public function updatedKeyword($value)
    {
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

    public function updating($name)
    {
        if (in_array($name, ['keyword', 'shipping_price', 'min_price', 'max_price', 'quantity', 'immediate_delivery', 'customizable'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->keyword = '';
        $this->shipping_price = null;
        $this->min_price = $this->start_min;
        $this->max_price = $this->start_max;
        $this->quantity = null;
        $this->immediate_delivery = false;
        $this->customizable = false;
        $this->resetPage();
    }

    public function render()
    {
        $query = Products::where('state', 1)
            ->with('productcategories', 'productcategories.category', 'productsubcategories', 'productsubcategories.subcategory', 'gallery', 'user', 'escalas', 'colores', 'tallas', 'extras')
            ->whereHas('escalas', function ($query) {
                $query->whereBetween('price', [$this->min_price, $this->max_price]);
            });

        if (!empty($this->info['search'])) {
            $search = $this->info['search'];
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        } elseif (empty($this->info['subcategory_id'])) {
            $query->whereRelation('productcategories', 'category_id', $this->info['category_id']);
        } else {
            $query->whereRelation('productsubcategories', 'subcategory_id', $this->info['subcategory_id']);
        }

        if ($this->shipping_price !== null) {
            $query->where('shipping_free', $this->shipping_price);
        }

        if ($this->quantity !== null && $this->quantity !== '') {
            $quantity = (int) $this->quantity;
            $query->whereHas('escalas', function ($query) use ($quantity) {
                $query->where('quantity_min', '<=', $quantity)
                    ->where(function ($query) use ($quantity) {
                        $query->where('quantity_max', '>=', $quantity)
                            ->orWhereNull('quantity_max');
                    });
            });
        }

        if ($this->immediate_delivery) {
            $query->where(function ($query) {
                $query->where('delivery_time', 'LIKE', '%inmediata%')
                    ->orWhere('delivery_time', 'LIKE', '%inmediato%')
                    ->orWhere('delivery_time', 'LIKE', '%hoy%')
                    ->orWhere('delivery_time', 'LIKE', '%24%')
                    ->orWhere('delivery_time', '0')
                    ->orWhere('delivery_time', '1');
            });
        }

        if ($this->customizable) {
            $query->where(function ($query) {
                $query->whereHas('colores')
                    ->orWhereHas('tallas')
                    ->orWhereHas('extras');
            });
        }

        switch ((string) $this->keyword) {
            case '2':
                $query->orderByDesc('created_at');
                break;
            case '3':
                $query->orderBy('price', 'ASC');
                break;
            case '4':
                $query->orderBy('price', 'DESC');
                break;
            default:
                $query->orderByDesc('created_at')->orderByDesc('views');
                break;
        }

        return view('livewire.products', [
            'products' => $query->paginate($this->pagination),
        ]);
    }
}
