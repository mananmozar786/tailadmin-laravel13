<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreBmiRequest;
use App\Http\Requests\Api\V1\UpdateProfileRequest;
use App\Services\HealthService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class HealthController extends Controller
{
    protected HealthService $healthService;

    public function __construct(HealthService $healthService)
    {
        $this->healthService = $healthService;
    }

    #[OA\Post(
        path: "/api/v1/health/bmi",
        summary: "Store BMI data and return calculated BMI and status",
        tags: ["Health"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["height", "weight"],
                properties: [
                    new OA\Property(property: "height", type: "number", format: "float", example: 180, description: "Height in cm (50-300)"),
                    new OA\Property(property: "weight", type: "number", format: "float", example: 75, description: "Weight in kg (20-300)")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "BMI calculated successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "bmi", type: "number", format: "float", example: 23.15),
                        new OA\Property(property: "status", type: "string", example: "Normal")
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function storeBmi(StoreBmiRequest $request): JsonResponse
    {
        $user = auth()->user();
        $height = $request->validated('height');
        $weight = $request->validated('weight');

        $bmi = $this->healthService->calculateBmi($height, $weight);
        $status = $this->healthService->getBmiStatus($bmi);

        $user->update([
            'height' => $height,
            'weight' => $weight,
            'bmi' => $bmi,
            'bmi_status' => $status,
        ]);

        return response()->json([
            'bmi' => $bmi,
            'status' => $status,
        ]);
    }

    #[OA\Patch(
        path: "/api/v1/health/profile",
        summary: "Update user profile and recalculate BMI",
        tags: ["Health"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "height", type: "number", format: "float", example: 180),
                    new OA\Property(property: "weight", type: "number", format: "float", example: 75),
                    new OA\Property(property: "age", type: "integer", example: 30)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Profile updated successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "success"),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        $user->update($data);

        // Recalculate BMI if BOTH height and weight are present after update
        if ($user->height && $user->weight) {
            $bmi = $this->healthService->calculateBmi($user->height, $user->weight);
            $status = $this->healthService->getBmiStatus($bmi);

            $user->update([
                'bmi' => $bmi,
                'bmi_status' => $status,
            ]);
        }

        return response()->json($user->fresh());
    }
}
