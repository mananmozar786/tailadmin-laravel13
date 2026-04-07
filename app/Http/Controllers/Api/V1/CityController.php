<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of active cities, optionally filtered by state or country.
     */
    public function index(Request $request)
    {
        $query = City::active();

        if ($request->has('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->has('country_id')) {
            $query->whereHas('state', function ($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        $cities = $query->orderBy('name')->get();

        return CityResource::collection($cities);
    }
}
