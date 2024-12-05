<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseAPIController;
use App\Mail\InquirySubmittedMail;
use App\Models\Inquiry;
use App\Models\StatusTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return Inquiry::query()->get();
            },
            'Inquiries retrieved successfully',
            'Inquiries could not be retrieved'
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'message' => 'required',
        ]);

        return $this->doDBTransaction(
            function () use ($request) {
                $inquiry = new Inquiry();
                $inquiry->first_name = $request->first_name;
                $inquiry->last_name = $request->last_name;
                $inquiry->email = $request->email;
                $inquiry->phone = $request->phone;
                $inquiry->message = $request->message;
                $inquiry->save();

                // Send email after saving the inquiry
                Mail::to($inquiry->email)->send(new InquirySubmittedMail($inquiry));

                StatusTracking::query()->create([
                    'trackable_id' => $inquiry->id,
                    'trackable_type' => Inquiry::class,
                    'status' => StatusEnum::CREATED->value,
                    'comment' => 'Inquiry submitted successfully.',
                ]);
                return $inquiry;
            },
            'Inquiry submitted successfully.',
            'Inquiry submission failed.'
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiry)
    {
        return $this->doDBTransaction(
            function () use ($inquiry) {
                return Inquiry::query()->find($inquiry->id);
            },
            'Inquiry detail retrieved successfully',
            'Inquiry detail could not be retrieved'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }
}
