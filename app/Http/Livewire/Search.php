<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Products;
use Livewire\WithPagination;



class Search extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $pagination = 12;
    
    public function render()
    {
        return view('livewire.search');
    }
}
