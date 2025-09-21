<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCount extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function getCountProperty()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();

            if ($cart) {
                return CartItem::where('cart_id', $cart->id)->sum('quantity');
            }
        }

        return 0;
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
