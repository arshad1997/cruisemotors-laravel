<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Mail\FormSubmissionMail;
use App\Models\Documentation;
use App\Models\DocumentService;
use App\Models\StatusTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocumentationController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return Documentation::all();
            },
            'Successfully retrieved documentations.',
            'Failed to retrieve documentations.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_make_id' => 'required|exists:car_makes,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_variant_id' => 'nullable|exists:car_variants,id',
            'vin' => 'nullable|string',
            'year' => 'nullable|string',
            'comments' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*.name' => 'required|string',
            'attachments.*.file' => 'required|file',
            'service_items' => 'required|array|min:1',
            'service_items.*' => 'required|exists:document_services,id',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $documentation = Documentation::query()->create([
                    ...$request->except(['attachments', 'service_items']),
                    'status' => false,
                ]);

                $documentServices = DocumentService::query()->whereIn('id', $request->service_items)->get();

                $documentation->serviceItems()->createMany($documentServices->map(function ($documentService) {
                    return [
                        'document_service_id' => $documentService->id,
                        'cost' => $documentService->cost,
                    ];
                })->toArray());

                foreach ($request->attachments as $attachment) {
                    if (isset($attachment['file'])) {
                        $id = uploadMedia($attachment['file'], 'documentation');
                        $documentation->attachments()->create([
                            'name' => $attachment['name'],
                            'file_id' => $id,
                            'attachment_for' => 'Documentation',
                            'source_id' => $documentation->id,
                            'source_type' => Documentation::class,
                        ]);
                    }
                }

                StatusTracking::query()->create([
                    'trackable_id' => $documentation->id,
                    'trackable_type' => Documentation::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Documentation request submitted successfully.',
                ]);

                Mail::to($documentation->user->email)->send(new FormSubmissionMail('documentation', $documentation, $documentation->user));

                return $documentation;
            },
            'Successfully created documentation.',
            'Failed to create documentation.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Documentation $documentation)
    {
        return $this->doDBTransaction(
            function () use ($documentation) {
                return $documentation;
            },
            'Successfully retrieved documentation.',
            'Failed to retrieve documentation.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documentation $documentation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documentation $documentation)
    {
        //
    }
}
