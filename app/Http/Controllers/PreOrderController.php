<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mongo\PreOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PreOrderController extends Controller
{
    /**
     * Display user's pre-orders
     */
    public function index()
    {
        try {
            // Check if MongoDB is available
            if (!extension_loaded('mongodb')) {
                return view('user.preorders.index', ['preorders' => collect(), 'mongodb_unavailable' => true]);
            }

            $preorders = PreOrder::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.preorders.index', compact('preorders'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch pre-orders', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return view('user.preorders.index', ['preorders' => collect(), 'error' => true]);
        }
    }

    /**
     * Show the form for creating a new pre-order
     */
    public function create()
    {
        return view('user.preorders.create');
    }

    /**
     * Store a newly created pre-order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'preorder_item' => ['required', 'string', 'max:500'],
        ]);

        try {
            $preOrder = PreOrder::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'preorder_item' => $validated['preorder_item'],
                'status' => 'pending',
            ]);

            return redirect()->route('user.preorders.index')->with('success', 'Pre-order created successfully!');
        } catch (\Exception $e) {
            Log::error('Pre-order creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Failed to create pre-order. Please try again.');
        }
    }

    /**
     * Display the specified pre-order
     */
    public function show($id)
    {
        try {
            $preorder = PreOrder::where('_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return view('user.preorders.show', compact('preorder'));
        } catch (\Exception $e) {
            return redirect()->route('user.preorders.index')->with('error', 'Pre-order not found.');
        }
    }

    /**
     * Show the form for editing the specified pre-order
     */
    public function edit($id)
    {
        try {
            $preorder = PreOrder::where('_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Only allow editing if status is pending
            if ($preorder->status !== 'pending') {
                return redirect()->route('user.preorders.index')->with('error', 'This pre-order cannot be edited.');
            }

            return view('user.preorders.edit', compact('preorder'));
        } catch (\Exception $e) {
            return redirect()->route('user.preorders.index')->with('error', 'Pre-order not found.');
        }
    }

    /**
     * Update the specified pre-order
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'preorder_item' => ['required', 'string', 'max:500'],
        ]);

        try {
            $preorder = PreOrder::where('_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Only allow updating if status is pending
            if ($preorder->status !== 'pending') {
                return redirect()->route('user.preorders.index')->with('error', 'This pre-order cannot be updated.');
            }

            $preorder->update($validated);

            Log::info('Pre-order updated successfully', [
                'preorder_id' => $id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('user.preorders.index')->with('success', 'Pre-order updated successfully!');
        } catch (\Exception $e) {
            Log::error('Pre-order update failed', [
                'error' => $e->getMessage(),
                'preorder_id' => $id,
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Failed to update pre-order. Please try again.');
        }
    }

    /**
     * Remove the specified pre-order
     */
    public function destroy($id)
    {
        try {
            $preorder = PreOrder::where('_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Only allow deletion if status is pending or cancelled
            if (!in_array($preorder->status, ['pending', 'cancelled'])) {
                return redirect()->route('user.preorders.index')->with('error', 'This pre-order cannot be deleted.');
            }

            $preorder->delete();

            Log::info('Pre-order deleted successfully', [
                'preorder_id' => $id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('user.preorders.index')->with('success', 'Pre-order deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Pre-order deletion failed', [
                'error' => $e->getMessage(),
                'preorder_id' => $id,
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Failed to delete pre-order. Please try again.');
        }
    }

    /**
     * Cancel a pre-order
     */
    public function cancel($id)
    {
        try {
            $preorder = PreOrder::where('_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Only allow cancellation if not already completed
            if ($preorder->status === 'completed') {
                return redirect()->route('user.preorders.index')->with('error', 'Completed pre-orders cannot be cancelled.');
            }

            $preorder->update(['status' => 'cancelled']);

            return redirect()->route('user.preorders.index')->with('success', 'Pre-order cancelled successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel pre-order. Please try again.');
        }
    }
}
