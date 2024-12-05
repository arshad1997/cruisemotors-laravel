<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\DocumentService;
use Illuminate\Http\Request;

class DocumentServiceController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return DocumentService::query()->get();
            },
            'Document services retrieved successfully',
            'Document services could not be retrieved'
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
    public function show(DocumentService $documentService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentService $documentService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentService $documentService)
    {
        //
    }

    public function getActiveServices()
    {
        return $this->doDBTransaction(
            function () {
                return DocumentService::query()->where('status', true)->get();
            },
            'Active document services retrieved successfully',
            'Active document services could not be retrieved'
        );
    }
}
