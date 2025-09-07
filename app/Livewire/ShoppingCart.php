<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShoppingCart extends Component
{
    public $cartItems = [];
    public $total = 0;

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();

            if ($cart) {
                $this->cartItems = CartItem::with('product')
                    ->where('cart_id', $cart->id)
                    ->get()
                    ->toArray();
            } else {
                $this->cartItems = [];
            }
        } else {
            $this->cartItems = [];
        }

        $this->calculateTotal();
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($cartItemId);
            return;
        }

        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->update(['quantity' => $quantity]);
            $this->loadCart();
        }
    }

    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->delete();
            $this->loadCart();
        }
    }

    public function clearCart()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->delete();
                $this->loadCart();
            }
        }
    }

    private function calculateTotal()
    {
        $this->total = collect($this->cartItems)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
