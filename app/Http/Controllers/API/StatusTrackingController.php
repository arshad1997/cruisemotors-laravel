<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\StatusTracking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusTrackingController extends BaseAPIController
{
    public function updateStatus(Request $request)
    {
        $request->validate([
            'trackable_id' => 'required|integer',
            'trackable_type' => 'required|string',
            'status' => [
                'required',
                'string',
                Rule::in(StatusEnum::values())
            ],
            'comment' => 'nullable|string',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                return StatusTracking::query()->create($request->all());
            },
            'Status updated successfully',
            'Failed to update status',
        );
    }

    public function getStatus(Request $request)
    {
        $request->validate([
            'trackable_id' => 'required|integer',
            'trackable_type' => 'required|string',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                return StatusTracking::query()
                    ->where('trackable_id', $request->trackable_id)
                    ->where('trackable_type', $request->trackable_type)
                    ->get();
            },
            'Status retrieved successfully',
            'Failed to retrieve status',
        );
    }
}
