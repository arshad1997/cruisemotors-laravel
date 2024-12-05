<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Documentation;
use App\Models\OfferVehicle;
use App\Models\Quotation;
use App\Models\SupplyContract;
use App\Models\Tender;
use App\Models\VehicleOrder;
use Illuminate\Http\Request;

class UserPanelController extends BaseAPIController
{
    public function getForms(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:deal,order_vehicle,supply_contract,tender,quotation,documentation,offer_vehicle',
        ]);
        return $this->doDBTransaction(
            function () use ($request) {
                $user = auth()->user();
                return match ($request->type) {
                    'deal' => $user->deals,
                    'order_vehicle' => $user->vehicleOrders,
                    'supply_contract' => $user->supplyContracts,
                    'tender' => $user->tenders,
                    'quotation' => $user->quotations,
                    'documentation' => $user->documentations,
                    'offer_vehicle' => $user->offerVehicles,
                };
            },
            'Forms retrieved successfully',
            'Forms could not be retrieved'
        );
    }

    public function userInquiries()
    {
        return $this->doDBTransaction(
            function () {
                return auth()->user()->inquiries;
            },
            'Inquiries retrieved successfully',
            'Inquiries could not be retrieved'
        );
    }

    public function userCarBooking()
    {
        return $this->doDBTransaction(
            function () {
                return auth()->user()->carBookings;
            },
            'Car bookings retrieved successfully',
            'Car bookings could not be retrieved'
        );
    }
}
