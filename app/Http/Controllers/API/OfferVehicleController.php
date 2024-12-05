<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Models\OfferVehicle;
use App\Models\StatusTracking;
use Illuminate\Http\Request;

class OfferVehicleController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return OfferVehicle::with('items')->get();
            },
            'Offer vehicles retrieved successfully',
            'Offer vehicles retrieval failed'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_phone' => 'required|string',
            'company_name' => 'nullable|string',
            'designation' => 'nullable|string',
            'location' => 'required|string',
            'offer_vehicle_items' => 'required|array',
            'offer_vehicle_items.*.car_make_id' => 'required|exists:car_makes,id',
            'offer_vehicle_items.*.car_model_id' => 'required|exists:car_models,id',
            'offer_vehicle_items.*.year' => 'required',
            'offer_vehicle_items.*.quantity' => 'required|integer|min:1',
            'interior_color' => 'nullable|string',
            'exterior_color' => 'nullable|string',
            'production_date_time' => 'nullable|string',
            'engine_size' => 'nullable|string',
            'fuel_type' => 'nullable|in:Petrol,Diesel,Electric,Hybrid',
            'steering' => 'nullable|in:LHD,RHD',
            'asking_price' => 'nullable|numeric',
            'preferred_sale_method' => 'nullable|string',
            'comment' => 'nullable|string',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $offerVehicle = OfferVehicle::query()->create([
                    'client_name' => $request->client_name,
                    'client_phone' => $request->client_phone,
                    'company_name' => $request->company_name,
                    'designation' => $request->designation,
                    'location' => $request->location,
                    'interior_color' => $request->interior_color,
                    'exterior_color' => $request->exterior_color,
                    'production_date_time' => $request->production_date_time,
                    'engine_size' => $request->engin_size,
                    'fuel_type' => $request->fuel_type,
                    'steering' => $request->steering,
                    'asking_price' => $request->asking_price,
                    'preferred_sale_method' => $request->preferred_sale_method,
                    'comment' => $request->comment,
                ]);

                foreach ($request->offer_vehicle_items as $offerVehicleItem) {
                    $offerVehicle->items()->create([
                        'car_make_id' => $offerVehicleItem['car_make_id'],
                        'car_model_id' => $offerVehicleItem['car_model_id'],
                        'year' => $offerVehicleItem['year'],
                        'quantity' => $offerVehicleItem['quantity'],
                    ]);
                }

                StatusTracking::query()->create([
                    'trackable_id' => $offerVehicle->id,
                    'trackable_type' => OfferVehicle::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Offer us a vehicle submitted successfully.',
                ]);

                return $offerVehicle;
            },
            'Vehicle order created successfully',
            'Vehicle order creation failed'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(OfferVehicle $offerVehicle)
    {
        return $this->doDBTransaction(
            function () use ($offerVehicle) {
                return OfferVehicle::with('items')->find($offerVehicle->id);
            },
            'Offer vehicle detail retrieved successfully',
            'Offer vehicles detail retrieval failed'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferVehicle $offerVehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfferVehicle $offerVehicle)
    {
        //
    }
}
