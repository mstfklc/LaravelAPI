<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\Device;

class DeviceController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/device/login",
     *     operationId="deviceLogin",
     *     tags={"Device"},
     *     summary="Device login",
     *     description="Login or create a device",
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="uuid", type="string", example="d1816de2-bf16-4e4b-b1d0-3638e344b0e2"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="uuid", type="string", example="generated_uuid_here"),
     *             @OA\Property(property="premium_status", type="boolean", example=false),
     *             @OA\Property(property="config_info", type="object", example=null),
     *         ),
     *     ),
     * )
     */


    public function deviceLogin(Request $request): JsonResponse
    {
        $deviceUuid = $request->input('uuid');

        if (!$deviceUuid) {
            $device = Device::create([
                'uuid' => Str::uuid(),
                'premium_status' => false,
                'config_info' => null,
            ]);

        } else {
            $device = Device::where('uuid', $deviceUuid)->first();
            if (!$device) {
                return response()->json(['error' => 'Device not found'], 404);
            }
        }
        $accessToken = $device->createToken('authToken', ['uuid' => $device->uuid])->plainTextToken;
        $response = [
            'uuid' => $device->uuid,
            'premium_status' => $device->premium_status,
            'config_info' => $device->config_info,
            'access_token' => $accessToken,
        ];

        return response()->json($response);
    }
}
