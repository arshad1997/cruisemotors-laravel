<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\CarBodyType;
use Illuminate\Http\Request;

class CarBodyTypeController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return CarBodyType::query()->get();
            },
            'Car body types retrieved successfully',
            'Car body types could not be retrieved'
        );
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
    public function show(CarBodyType $carBodyType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarBodyType $carBodyType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarBodyType $carBodyType)
    {
        //
    }
}
