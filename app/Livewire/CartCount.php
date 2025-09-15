<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;

    protected $listeners = ['cart-updated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();

            if ($cart) {
                $this->count = CartItem::where('cart_id', $cart->id)->sum('quantity');
            } else {
                $this->count = 0;
            }
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
