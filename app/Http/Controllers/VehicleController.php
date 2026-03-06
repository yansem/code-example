<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VehicleController extends Controller
{
    #[OA\Post(
        path: "/api/vehicles",
        description: "store vehicle",
        summary: "store vehicle",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/VehicleRequest")
        ),
        tags: ["Vehicle"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Created"
            ),
            new OA\Response('#/components/responses/ValidationErrorsResponse', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY),
        ]
    )]
    public function store(VehicleRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        Vehicle::create([
            'license_plate' => $validated['license_plate'],
            'is_default' => $validated['is_default'],
            'is_foreign' => $validated['is_foreign'],
            'vehicle_category_id' => $validated['vehicle_category_id'],
            'user_id' => auth()->id(),
        ]);

        return response()->json(status: ResponseAlias::HTTP_CREATED);
    }
}
