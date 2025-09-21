<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboard extends Component
{
    public $totalOrders = 0;
    public $completedOrders = 0;
    public $totalSpent = 0;
    public $recentOrders = [];
    public $cartItemCount = 0;

    protected $listeners = ['cart-updated' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if (Auth::check()) {
            $userId = Auth::id();

            // Get order statistics
            $this->totalOrders = Order::where('user_id', $userId)->count();
            $this->completedOrders = Order::where('user_id', $userId)
                ->where('status', 'confirmed')
                ->count();
            $this->totalSpent = Order::where('user_id', $userId)
                ->where('payment_status', 'completed')
                ->sum('total_amount');

            // Get recent orders (last 5)
            $this->recentOrders = Order::where('user_id', $userId)
                ->with('items')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->toArray();

            // Get current cart count
            $cart = Cart::where('user_id', $userId)->first();
            if ($cart) {
                $this->cartItemCount = CartItem::where('cart_id', $cart->id)->sum('quantity');
            } else {
                $this->cartItemCount = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
