<?php

namespace App\Http\Controllers;

use App\DTO\Parking\ParkingSessionData;
use App\Http\Requests\ParkingSessionCalculateRequest;
use App\Http\Requests\ParkingSessionRequest;
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
            content: new OA\JsonContent(ref: "#/components/schemas/ParkingSessionRequest")
        ),
        tags: ["ParkingSession"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Created"
            ),
            new OA\Response('#/components/responses/ValidationErrorsResponse', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY),
        ]
    )]
    public function store(ParkingSessionRequest $request, ParkingService $parkingService): JsonResponse
    {
        $data = $request->validated();

        $parkingService->store(new ParkingSessionData(
            zoneId: $data['zone_id'],
            vehicleId: $data['vehicle_id'],
            userId: auth()->user()->id,
            duration: $data['duration'],
            isAutoRenewal: $data['is_auto_renewal']
        ));

        return response()->json(status: ResponseAlias::HTTP_CREATED);
    }

    #[OA\Post(
        path: "/api/parkings/calculate",
        description: "Расчёт стоимости парковки",
        summary: "Расчёт стоимости парковки",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/ParkingSessionCalculateRequest")
        ),
        tags: ["ParkingSession"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный расчёт стоимости",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "cost",
                            description: "Стоимость парковки в копейках",
                            type: "integer",
                            format: "int64",
                            example: 1250
                        )
                    ],
                    type: "object"
                )
            ),
            new OA\Response(
                ref: '#/components/responses/ValidationErrorsResponse',
                response: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            ),
        ]
    )]
    public function calculate(ParkingSessionCalculateRequest $request, ParkingService $parkingService): JsonResponse
    {
        $data = $request->validated();

        $cost = $parkingService->calculate(new ParkingSessionData(
            zoneId: $data['zone_id'],
            vehicleId: $data['vehicle_id'],
            duration: $data['duration'],
        ));

        return response()->json(['cost' => $cost], status: ResponseAlias::HTTP_OK);
    }
}
