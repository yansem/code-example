<?php

namespace App\OpenApi\Schemas\Requests\Parking;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ParkingSessionCalculateRequest",
    required: ["duration", "vehicle_id", "zone_id"],
    properties: [
        new OA\Property(
            property: "duration",
            description: "Длительность в минутах",
            type: "integer",
            example: "60"
        ),

        new OA\Property(
            property: "vehicle_id",
            description: "ID транспортного средства",
            type: "integer",
            example: 12
        ),

        new OA\Property(
            property: "zone_id",
            description: "ID парковочной зоны",
            type: "integer",
            example: 5
        ),
    ],
    type: "object"
)]
class ParkingSessionCalculateRequestSchema
{

}
