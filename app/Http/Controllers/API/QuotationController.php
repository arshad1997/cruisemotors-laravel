<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\StatusTracking;
use Illuminate\Http\Request;

class QuotationController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return Quotation::with('items')->get();
            },
            'Quotations retrieved successfully',
            'Quotations retrieval failed'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'departure_country_id' => 'required|exists:countries,id',
            'departure_state_id' => 'required|exists:states,id',
            'departure_city_id' => 'nullable|exists:cities,id',
            'departure_port_id' => 'nullable|exists:ports,id',
            'pickup_country_id' => 'required|exists:countries,id',
            'pickup_state_id' => 'required|exists:states,id',
            'pickup_city_id' => 'nullable|exists:cities,id',
            'pickup_port_id' => 'nullable|exists:ports,id',
            'transportation_type' => 'required|in:air,sea,land',
            'quotation_items' => 'required|array',
            'quotation_items.*.car_make_id' => 'required|exists:car_makes,id',
            'quotation_items.*.car_model_id' => 'required|exists:car_models,id',
            'quotation_items.*.year' => 'required',
            'quotation_items.*.quantity' => 'required|integer|min:1',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $quotation = Quotation::query()->create([
                    'user_id' => auth()->id(),
                    'departure_country_id' => $request->departure_country_id,
                    'departure_state_id' => $request->departure_state_id,
                    'departure_city_id' => $request->departure_city_id,
                    'departure_port_id' => $request->departure_port_id,
                    'pickup_country_id' => $request->pickup_country_id,
                    'pickup_city_id' => $request->pickup_city_id,
                    'pickup_state_id' => $request->pickup_state_id,
                    'pickup_port_id' => $request->pickup_port_id ?? 0,
                    'transportation_type' => $request->transportation_type,
                ]);

                foreach ($request->quotation_items as $item) {
                    $quotation->items()->create($item);
                }

                StatusTracking::query()->create([
                    'trackable_id' => $quotation->id,
                    'trackable_type' => Quotation::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Quotation submitted successfully.',
                ]);

                return $quotation;
            },
            'Quotation created successfully',
            'Quotation creation failed'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        return $this->doDBTransaction(
            function () use ($quotation) {
                return Quotation::with('items')->find($quotation->id);
            },
            'Quotations retrieved successfully',
            'Quotations retrieval failed'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        return $this->doDBTransaction(
            function () use ($quotation) {
                $quotation->delete();
            },
            'Quotation deleted successfully',
            'Quotation deletion failed'
        );
    }
}
