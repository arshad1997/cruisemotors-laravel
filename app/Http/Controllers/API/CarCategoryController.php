<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\CarCategory;
use Illuminate\Http\Request;

class CarCategoryController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return CarCategory::query()->get();
            },
            'Car categories retrieved successfully',
            'Car categories could not be retrieved'
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
    public function show(CarCategory $carCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarCategory $carCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarCategory $carCategory)
    {
        //
    }
}
