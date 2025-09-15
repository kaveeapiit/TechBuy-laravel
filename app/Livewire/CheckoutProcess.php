<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CheckoutProcess extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $tax = 0;
    public $grandTotal = 0;

    // Shipping Information
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $zipCode = '';
    public $country = 'United States';

    // Payment Information
    public $paymentMethod = 'card';
    public $cardNumber = '';
    public $expiryDate = '';
    public $cvv = '';
    public $cardName = '';

    protected $rules = [
        'firstName' => 'required|string|min:2',
        'lastName' => 'required|string|min:2',
        'email' => 'required|email',
        'phone' => 'required|string|min:10',
        'address' => 'required|string|min:5',
        'city' => 'required|string|min:2',
        'state' => 'required|string|min:2',
        'zipCode' => 'required|string|min:5',
        'cardNumber' => 'required|string|min:16|max:19',
        'expiryDate' => 'required|string|min:5|max:5',
        'cvv' => 'required|string|min:3|max:4',
        'cardName' => 'required|string|min:2',
    ];

    public function mount()
    {
        $this->loadCart();
        $this->prefillUserData();
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
        }

        $this->calculateTotals();
    }

    public function prefillUserData()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->firstName = explode(' ', $user->name)[0] ?? '';
            $this->lastName = explode(' ', $user->name, 2)[1] ?? '';
            $this->email = $user->email;
        }
    }

    public function calculateTotals()
    {
        $this->total = collect($this->cartItems)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });

        $this->tax = $this->total * 0.08; // 8% tax
        $this->grandTotal = $this->total + $this->tax;
    }

    public function placeOrder()
    {
        $this->validate();

        if (empty($this->cartItems)) {
            session()->flash('error', 'Your cart is empty');
            return redirect()->route('cart');
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'TB-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => $this->total,
                'tax_amount' => $this->tax,
                'total_amount' => $this->grandTotal,
                'shipping_address' => json_encode([
                    'first_name' => $this->firstName,
                    'last_name' => $this->lastName,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'city' => $this->city,
                    'state' => $this->state,
                    'zip_code' => $this->zipCode,
                    'country' => $this->country,
                ]),
                'payment_method' => $this->paymentMethod,
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }

            // Clear cart
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->delete();
            }

            DB::commit();

            // In a real app, you would process payment here
            $order->update(['payment_status' => 'completed', 'status' => 'confirmed']);

            session()->flash('success', 'Order placed successfully! Order number: ' . $order->order_number);
            $this->dispatch('cart-updated');

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to place order. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.checkout-process');
    }
}
