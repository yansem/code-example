<?php

namespace App\OpenApi\Schemas\Requests\Parking;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ParkingRequest",
    required: ["duration", "is_auto_renewal", "vehicle_id", "zone_id"],
    properties: [
        new OA\Property(
            property: "duration",
            description: "Длительность в минутах",
            type: "integer",
            example: "60"
        ),

        new OA\Property(
            property: "is_auto_renewal",
            description: "Продление существующей парковки",
            type: "boolean",
            example: false
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
class ParkingRequestSchema
{

}
