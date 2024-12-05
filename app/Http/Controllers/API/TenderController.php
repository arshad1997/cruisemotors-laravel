<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Attachments;
use App\Models\StatusTracking;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return Tender::query()->get();
            },
            'Tenders retrieved successfully',
            'Tenders could not be retrieved'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->doDBTransaction(
            function () use ($request) {
                $tender = Tender::query()->create($request->except('attachments'));
                $attachments = collect($request->attachments);

                foreach ($attachments as $attachment) {
                    if(isset($attachment['file'])) {
                        $fileId = uploadMedia($attachment['file'], 'tenders');
                        Attachments::query()->create([
                            'name' => $attachment['name'],
                            'file_id' => $fileId,
                            'attachment_for' => 'Tender',
                            'source_type' => Tender::class,
                            'source_id' => $tender->id
                        ]);
                    }
                }

                StatusTracking::query()->create([
                    'trackable_id' => $tender->id,
                    'trackable_type' => Tender::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Tender submitted successfully.',
                ]);

                return $tender;
            },
            'Tender created successfully',
            'Failed to create Tender'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Tender $tender)
    {
        return $this->doDBTransaction(
            function () use ($tender) {
                return Tender::query()->find($tender->id);
            },
            'Tender details retrieved successfully',
            'Tender details could not be retrieved'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tender $tender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tender $tender)
    {
        //
    }
}
