<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    #[OA\Post(
        path: "/api/auth/register",
        operationId: "register",
        description: "Создаёт нового пользователя и возвращает API-токен (Sanctum)",
        summary: "Регистрация пользователя",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/RegisterRequest")
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Успешная регистрация",
                content: new OA\JsonContent(
                    required: ["token"],
                    properties: [
                        new OA\Property(
                            property: "token",
                            type: "string",
                            example: "1|randomlongtokenhere1234567890"
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string"),
                        new OA\Property(property: "errors", type: "object"),
                    ]
                )
            ),
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name'       => $validated['name'],
            'surname'    => $validated['surname'],
            'patronymic' => $validated['patronymic'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
        ], ResponseAlias::HTTP_CREATED);
    }

    #[OA\Post(
        path: "/api/auth/login",
        operationId: "login",
        description: "Логин пользователя и возвращение API-токена (Sanctum)",
        summary: "Логин пользователя",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/LoginRequest")
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Успешный логин",
                content: new OA\JsonContent(
                    required: ["token"],
                    properties: [
                        new OA\Property(
                            property: "token",
                            type: "string",
                            example: "1|randomlongtokenhere1234567890"
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string"),
                        new OA\Property(property: "errors", type: "object"),
                    ]
                )
            ),
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(status: ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
        ], ResponseAlias::HTTP_OK);
    }


    #[NoReturn] #[OA\Post(
        path: "/api/auth/logout",
        operationId: "logout",
        description: "Логаут пользователя и удаление API-токена (Sanctum)",
        summary: "Логаут пользователя",
        tags: ["Auth"],
        responses: [
            new OA\Response(
                response: 204,
                description: "Успешный логаут"
            )
        ]
    )]
    public function logout(Request $request): \Illuminate\Http\Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent(ResponseAlias::HTTP_NO_CONTENT);
    }
}
