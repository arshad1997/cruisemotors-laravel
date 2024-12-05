<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\StatusTracking;
use App\Models\VehicleOrder;
use Illuminate\Http\Request;

class OrderVehicleController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return VehicleOrder::with('items')->get();
            },
            'Vehicle orders retrieved successfully',
            'Vehicle orders retrieval failed'
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
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'port_id' => 'nullable|exists:ports,id',
            'order_vehicle_items' => 'required|array',
            'order_vehicle_items.*.car_make_id' => 'required|exists:car_makes,id',
            'order_vehicle_items.*.car_model_id' => 'required|exists:car_models,id',
            'order_vehicle_items.*.year' => 'required',
            'order_vehicle_items.*.quantity' => 'required|integer|min:1',
            'interior_color' => 'nullable|string',
            'exterior_color' => 'nullable|string',
            'product_date_time' => 'nullable|string',
            'engine_size' => 'nullable|string',
            'fuel_type' => 'nullable|in:Petrol,Diesel,Electric,Hybrid',
            'steering' => 'nullable|in:LHD,RHD',
            'delivery_date_time' => 'nullable|string',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $vehicleOrder = VehicleOrder::query()->create([
                    'client_name' => $request->client_name,
                    'client_phone' => $request->client_phone,
                    'company_name' => $request->company_name,
                    'designation' => $request->designation,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'port_id' => $request->port_id,
                    'interior_color' => $request->interior_color,
                    'exterior_color' => $request->exterior_color,
                    'product_date_time' => $request->product_date_time,
                    'engine_size' => $request->engin_size,
                    'fuel_type' => $request->fuel_type,
                    'steering' => $request->steering,
                    'delivery_date_time' => $request->delivery_date_time,
                    'payment_method_id' => $request->payment_method_id,
                ]);

                foreach ($request->order_vehicle_items as $orderVehicleItem) {
                    $vehicleOrder->items()->create([
                        'car_make_id' => $orderVehicleItem['car_make_id'],
                        'car_model_id' => $orderVehicleItem['car_model_id'],
                        'year' => $orderVehicleItem['year'],
                        'quantity' => $orderVehicleItem['quantity'],
                    ]);
                }

                StatusTracking::query()->create([
                    'trackable_id' => $vehicleOrder->id,
                    'trackable_type' => VehicleOrder::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Order a vehicle submitted successfully.',
                ]);

                return $vehicleOrder;
            },
            'Vehicle order created successfully',
            'Vehicle order creation failed'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleOrder $vehicleOrder)
    {
        return $this->doDBTransaction(
            function () use ($vehicleOrder) {
//                dd(VehicleOrder::with('items')->find($vehicleOrder->id));
                return VehicleOrder::with('items')->find($vehicleOrder->id);
            },
            'Vehicle orders retrieved successfully',
            'Vehicle orders retrieval failed'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleOrder $vehicleOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleOrder $vehicleOrder)
    {
        //
    }
}
