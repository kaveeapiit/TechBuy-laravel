<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $priceMin = '';
    public $priceMax = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->category);
                });
            })
            ->when($this->priceMin, function ($query) {
                $query->where('price', '>=', $this->priceMin);
            })
            ->when($this->priceMax, function ($query) {
                $query->where('price', '<=', $this->priceMax);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('livewire.product-list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
