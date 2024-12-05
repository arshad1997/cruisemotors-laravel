<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Attachments;
use App\Models\StatusTracking;
use App\Models\SupplyContract;
use Illuminate\Http\Request;

class SupplyContractController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return SupplyContract::query()->get();
            },
            'Supply contracts retrieved successfully',
            'Supply contracts could not be retrieved'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->doDBTransaction(
            function () use ($request) {
                $supplyContract = SupplyContract::query()->create($request->except('attachments'));
                $attachments = collect($request->attachments);

                foreach ($attachments as $attachment) {
                    if(isset($attachment['file'])) {
                        $fileId = uploadMedia($attachment['file'], 'tenders');
                        Attachments::query()->create([
                            'name' => $attachment['name'],
                            'file_id' => $fileId,
                            'attachment_for' => 'Supply Contract',
                            'source_type' => SupplyContract::class,
                            'source_id' => $supplyContract->id
                        ]);
                    }
                }

                StatusTracking::query()->create([
                    'trackable_id' => $supplyContract->id,
                    'trackable_type' => SupplyContract::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Supply contract submitted successfully.',
                ]);

                return $supplyContract;
            },
            'Supply contract created successfully',
            'Failed to create Supply contract'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplyContract $supplyContract)
    {
        return $this->doDBTransaction(
            function () use ($supplyContract) {
                return SupplyContract::query()->find($supplyContract->id);
            },
            'Supply contract details retrieved successfully',
            'Supply contract details could not be retrieved'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupplyContract $supplyContract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplyContract $supplyContract)
    {
        //
    }
}
