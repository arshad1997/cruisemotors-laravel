<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\CarVariant;
use Illuminate\Http\Request;

class CarVariantController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return CarVariant::query()->get();
            },
            'Car variants retrieved successfully.',
            'Car variants could not be retrieved.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:car_variants,name',
            'car_model_id' => 'required|exists:car_models,id',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                return CarVariant::query()->create($request->all());
            },
            'Car variant created successfully.',
            'Car variant could not be created.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CarVariant $carVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarVariant $carVariant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarVariant $carVariant)
    {
        //
    }

    public function getVariantByModel(CarModel $carModel)
    {
        return $this->doDBTransaction(
            function () use ($carModel) {
                return CarVariant::query()->where('car_model_id', $carModel->id)->get();
            },
            'Car variants retrieved successfully.',
            'Car variants could not be retrieved.'
        );
    }

    public function getVariantByModelSlug($slug)
    {
        return $this->doDBTransaction(
            function () use ($slug) {
                $carModel = CarModel::query()->where('slug', $slug)->first();
                return CarVariant::query()->where('car_model_id', $carModel->id)->get();
            },
            'Car variants retrieved successfully.',
            'Car variants could not be retrieved.'
        );
    }
}
