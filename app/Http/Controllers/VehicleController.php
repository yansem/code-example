<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VehicleController extends Controller
{
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
