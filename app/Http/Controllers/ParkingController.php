<?php

namespace App\Http\Controllers;

use App\DTO\Parking\CreateParkingData;
use App\Http\Requests\ParkingRequest;
use App\Services\ParkingService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ParkingController extends Controller
{
    #[OA\Post(
        path: "/api/parkings",
        description: "store parking",
        summary: "store parking",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/ParkingRequest")
        ),
        tags: ["Parking"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Created"
            ),
            new OA\Response('#/components/responses/ValidationErrorsResponse', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY),
        ]
    )]
    public function store(ParkingRequest $request, ParkingService $parkingService): JsonResponse
    {
        $data = $request->validated();

        $parkingService->store(new CreateParkingData(
            zoneId: $data['zone_id'],
            vehicleId: $data['vehicle_id'],
            duration: $data['duration'],
            isAutoRenewal: $data['is_auto_renewal']
        ));

        return response()->json(status: ResponseAlias::HTTP_CREATED);
    }
}
