<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function getItemsByUser(User $user)
    {
        return $this->doDBTransaction(
            function () use ($user) {
                return $user->carts()->where('status', true)->with('product')->get();
            },
            'Cart items retrieved successfully',
            'Cart items retrieval failed'
        );
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'action' => 'required|in:add,remove',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $user = auth()->user();
                $exist = $user->carts()->where('product_id', $request->product_id)->where('status', true)->first();

                if ($request->action === 'add') {
                    if ($exist) {
                        $exist->update([
                            'quantity' => $request->quantity,
                        ]);
                    } else {

                        $user->carts()->create([
                            'product_id' => $request->product_id,
                            'quantity' => $request->quantity,
                        ]);
                    }
                } else {
                    if ($exist) {
                        $exist->update([
                            'status' => false,
                        ]);
                    }
                }

                return $user->carts()->where('status', true)->with('product')->get();
            },
            'Product added to cart successfully',
            'Failed to add product to cart'
        );
    }
}
