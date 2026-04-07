<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of active countries.
     */
    public function index()
    {
        $countries = Country::active()->orderBy('name')->get();
        return CountryResource::collection($countries);
    }
}
