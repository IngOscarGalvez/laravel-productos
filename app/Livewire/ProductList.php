<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public ?Product $selectedProduct = null;

    public function showDetails(Product $product)
    {
        $this->selectedProduct = $product;
        $this->dispatch('open-modal');
    }

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::with('category')->latest()->paginate(12),
        ]);
    }
}
