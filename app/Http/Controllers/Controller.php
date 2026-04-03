<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "API documentation for My Application",
    title: "My Application API",
    contact: new OA\Contact(
        name: "API Support",
        url: "https://example.com/support",
        email: "support@example.com"
    )
)]
abstract class Controller
{
    use AuthorizesRequests;
    //
}
