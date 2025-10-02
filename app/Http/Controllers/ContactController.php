<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mongo\PreOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display the contact us page
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store a new pre-order
     */
    public function storePreOrder(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'preorder_item' => ['required', 'string', 'max:500'],
        ]);

        try {
            // Enhanced MongoDB availability check
            if (!extension_loaded('mongodb')) {
                Log::error('MongoDB extension not loaded');
                return back()->with('error', 'Pre-order system is currently unavailable (Extension not loaded). Please try again later.');
            }

            // Test MongoDB connection through Laravel's MongoDB package
            try {
                $connectionString = config('database.connections.mongodb.dsn') ??
                    env('MONGODB_CONNECTION_STRING');

                if (!$connectionString) {
                    Log::error('MongoDB connection string not configured');
                    return back()->with('error', 'Pre-order system is currently unavailable (No connection string). Please try again later.');
                }

                // Test connection by attempting to create a simple query
                DB::connection('mongodb')->table('connection_test')->get();
            } catch (\Exception $e) {
                Log::error('MongoDB connection test failed', [
                    'error' => $e->getMessage(),
                    'connection_string_exists' => !empty($connectionString),
                    'mongodb_extension' => extension_loaded('mongodb'),
                ]);
                return back()->with('error', 'Pre-order system is currently unavailable (Connection failed). Please try again later.');
            }

            $preOrder = PreOrder::create([
                'user_id' => Auth::id(), // Will be null for guests
                'name' => $validated['name'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'preorder_item' => $validated['preorder_item'],
                'status' => 'pending',
                'notes' => null,
                'estimated_delivery' => null,
            ]);

            Log::info('Pre-order created successfully', [
                'preorder_id' => $preOrder->_id,
                'user_id' => Auth::id(),
                'item' => $validated['preorder_item']
            ]);

            $message = Auth::check()
                ? 'Your pre-order has been submitted successfully! You can track it in your dashboard.'
                : 'Your pre-order has been submitted successfully! Please register/login to track your pre-orders.';

            return redirect()->route('contact.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Pre-order creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Failed to submit pre-order. Please try again.');
        }
    }

    /**
     * Send contact message (you can implement this later)
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // For now, just log the message
        Log::info('Contact message received', $validated);

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
