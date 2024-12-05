<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return PaymentMethod::all();
            },
            'Payment methods retrieved successfully.',
            'Payment methods retrieval failed. Please try again.'
        );
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }

    public function getPaymentMethods()
    {
        return $this->doDBTransaction(
            function () {
                return PaymentMethod::query()->where('status', true)->get();
            },
            'Payment methods retrieved successfully.',
            'Payment methods retrieval failed. Please try again.'
        );
    }
}
