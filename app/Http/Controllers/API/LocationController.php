<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Port;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends BaseAPIController
{
    public function getCountries()
    {
        return $this->doDBTransaction(
            function () {
                return Country::all();
            },
            'Countries retrieved successfully.',
            'Countries could not be retrieved.'
        );
    }

    public function getCountryStates(Country $country)
    {
        return $this->doDBTransaction(
            function () use ($country) {
                return State::query()->where('country_id', $country->id)->with('country')->get();
            },
            'Country retrieved successfully.',
            'Country could not be retrieved.'
        );
    }

    public function getStateCities(Country $country, State $state)
    {
        return $this->doDBTransaction(
            function () use ($country, $state) {
                return City::query()->where('country_id', $country->id)->where('state_id', $state->id)->with('country', 'state')->get();
            },
            'Cities retrieved successfully.',
            'Cities could not be retrieved.'
        );
    }

    public function getCityPorts(Country $country, State $state, City $city)
    {
        return $this->doDBTransaction(
            function () use ($country, $state, $city) {
                return Port::query()->where('country_id', $country->id)->where('state_id', $state->id)->where('city_id', $city->id)->with('country', 'state', 'city')->get();
            },
            'Ports retrieved successfully.',
            'Ports could not be retrieved.'
        );
    }
}
