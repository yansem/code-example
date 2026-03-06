<?php

namespace App\Http\Swagger;

use OpenApi\Attributes as OAT;
#[OAT\Schema(
    schema: 'ValidationErrors',
    required: ['message', 'errors'],
    properties: [
        new OAT\Property('message', type: 'string'),
        new OAT\Property('errors', type: 'object', example: ['field' => ['string']]),
    ],
)]
#[OAT\Response(
    response: 'ValidationErrorsResponse',
    description: 'Validation errors',
    content: new OAT\JsonContent(ref: '#/components/schemas/ValidationErrors'),
)]
class OpenApi
{

}
