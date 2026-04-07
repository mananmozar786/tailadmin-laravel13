<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

class CityController extends Controller
{
    #[OA\Get(
        path: "/api/v1/cities",
        summary: "Display a listing of active cities",
        tags: ["Locations"],
        parameters: [
            new OA\Parameter(
                name: "state_id",
                in: "query",
                description: "Filter by state ID",
                required: false,
                schema: new OA\Schema(type: "integer")
            ),
            new OA\Parameter(
                name: "country_id",
                in: "query",
                description: "Filter by country ID",
                required: false,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of cities",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(type: "object")
                )
            )
        ]
    )]
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
