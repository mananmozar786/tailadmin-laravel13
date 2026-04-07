<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of active states, optionally filtered by country.
     */
    public function index(Request $request)
    {
        $query = State::active();

        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        $states = $query->orderBy('name')->get();

        return StateResource::collection($states);
    }
}
