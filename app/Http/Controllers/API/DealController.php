<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Models\Deal;
use App\Models\StatusTracking;
use Illuminate\Http\Request;

class DealController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return Deal::query()->get();
            },
            'Deals retrieved successfully.',
            'Deals could not be retrieved.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'agent_name' => 'required|string|max:255', // Limit the max length to 255 chars
            'agent_phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/', // Phone should follow a pattern for proper phone numbers
            'client_name' => 'required|string|max:255', // Limit the max length to 255 chars
            'client_phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/', // Phone should follow a pattern for proper phone numbers
            'client_address' => 'required|string|max:500', // Limit max length for address to 500 chars
            'car_make_id' => 'required|integer|exists:car_makes,id', // Ensure it's an integer and exists
            'car_model_id' => 'required|integer|exists:car_models,id', // Ensure it's an integer and exists
            'year' => 'required|integer|min:1900|max:' . date('Y'), // Validate as a valid year
            'color' => 'required|string', // Limit color length to 100 chars
            'quantity' => 'required|integer|min:1', // Ensure quantity is a positive integer
            'destination' => 'required|string|max:255', // Limit the max length for destination
            'agent_targeted_amount' => 'required|numeric|min:0', // Ensure it’s a valid number and non-negative
            'agent_commission_amount' => 'required|numeric|min:0', // Ensure it’s a valid number and non-negative
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $deal = Deal::query()->create($request->all());
                StatusTracking::query()->create([
                    'trackable_id' => $deal->id,
                    'trackable_type' => Deal::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Make a deal submitted successfully.',
                ]);
                return $deal;
            },
            'Deal created successfully.',
            'Deal could not be created.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        return $this->doDBTransaction(
            function () use ($deal) {
                return Deal::query()->find($deal->id);
            },
            'Deal details retrieved successfully.',
            'Deal details could not be retrieved.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        //
    }
}
