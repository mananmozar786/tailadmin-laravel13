<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

class CountryController extends Controller
{
    #[OA\Get(
        path: "/api/v1/countries",
        summary: "Display a listing of active countries",
        tags: ["Locations"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of countries",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(type: "object")
                )
            )
        ]
    )]
    public function index()
    {
        $countries = Country::active()->orderBy('name')->get();
        return CountryResource::collection($countries);
    }
}
