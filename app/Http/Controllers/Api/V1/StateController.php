<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

class StateController extends Controller
{
    #[OA\Get(
        path: "/api/v1/states",
        summary: "Display a listing of active states",
        tags: ["Locations"],
        parameters: [
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
                description: "List of states",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(type: "object")
                )
            )
        ]
    )]
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
