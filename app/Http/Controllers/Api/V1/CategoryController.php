<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    #[OA\Get(
        path: "/api/v1/ai/categories",
        summary: "Get list of active categories",
        tags: ["Categories"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "title", type: "string", example: "Electronics"),
                            new OA\Property(property: "slug", type: "string", example: "electronics"),
                            new OA\Property(property: "subtitle", type: "string", example: "Gadgets and more"),
                            new OA\Property(property: "status", type: "string", example: "active")
                        ],
                        type: "object"
                    )
                )
            )
        ]
    )]
    public function index()
    {
        $categories = Category::active()->get();

        return CategoryResource::collection($categories);
    }
}
