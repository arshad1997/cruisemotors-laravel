<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return CarModel::query()->with(['carMake', 'carVariants'])->get();
            },
            'Car Models retrieved successfully.',
            'Car Models could not be retrieved.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:car_models,name',
            'car_make_id' => 'required|exists:car_makes,id',
            'logo' => 'nullable|image',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $logoId = null;
                if ($request->hasFile('logo')) {
                    $logoId = uploadMedia($request->file('logo'), 'car-model');
                }
                return CarModel::query()->create(['logo', $logoId, ...$request->except('logo')]);
            },
            'Car Model created successfully.',
            'Car Model could not be created.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CarModel $carModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $carModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $carModel)
    {
        //
    }

    public function getCarModelByMake(CarMake $carMake)
    {
        return $this->doDBTransaction(
            function () use ($carMake) {
                return CarModel::query()->where('car_make_id', $carMake->id)->with(['carMake'])->get();
            },
            'Car Models retrieved successfully.',
            'Car Models could not be retrieved.'
        );
    }

    public function getCarModelByMakeSlug($slug)
    {
        return $this->doDBTransaction(
            function () use ($slug) {
                $carMake = CarMake::query()->where('slug', $slug)->first();
                return CarModel::query()->where('car_make_id', $carMake->id)->with(['carMake'])->get();
            },
            'Car Models retrieved successfully.',
            'Car Models could not be retrieved.'
        );
    }
}
