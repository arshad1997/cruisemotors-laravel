<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarMake;
use Illuminate\Http\Request;

class CarMakeController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return CarMake::query()->get();
            },
            'Car Makes retrieved successfully.',
            'Car Makes could not be retrieved.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:car_makes,name',
            'logo' => 'nullable|image',
            'official_website' => 'nullable|url',
        ]);
        return $this->doDBTransaction(
            function () use ($request) {
                $logoId = null;
                if ($request->hasFile('logo')) {
                    $logoId = uploadMedia($request->file('logo'), 'car-makes');
                }
                return CarMake::query()->create(['logo', $logoId, ...$request->except('logo')]);
            },
            'Car Make created successfully.',
            'Failed to create Car Make.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CarMake $carMake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarMake $carMake)
    {
        return $this->doDBTransaction(
            function () use ($request, $carMake) {
                $logoId = $carMake->logo;
                if ($request->hasFile('logo')) {
                    $logoId = uploadMedia($request->file('logo'), 'car-makes');
                }

                $carMake->update(['logo' => $logoId, ...$request->except('logo')]);

                return $carMake;
            },
            'Car Make created successfully.',
            'Failed to create Car Make.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarMake $carMake)
    {
        //
    }

    public function getFeaturedCarMakes($withCarList = 0)
    {
        return $this->doDBTransaction(
            function () use ($withCarList) {

                if(request()->featured){
                    $carMakes = CarMake::query()
                        ->where('is_featured', true)
                        ->get();
                } else {
                    $carMakes = CarMake::query()
                        ->limit(12)
                        ->get();
                }

                if ($withCarList) {
                    foreach ($carMakes as $carMake) {
                        $carMake->cars = Car::query()
                            ->where('car_make_id', $carMake->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();
                    }
                }

                return $carMakes;
            },
            'Featured Car Makes retrieved successfully.',
            'Featured Car Makes could not be retrieved.'
        );
    }
}
