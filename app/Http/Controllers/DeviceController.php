<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Device;
use Illuminate\Http\Request;
class DeviceController extends Controller
{
    public function deviceLogin(Request $request)
    {
        $request->validate([
            'deviceUuid' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Str::isUuid($value)) {
                    $fail($attribute . ' is not a valid UUID.');
                }
            }],
        ]);

        $device = Device::where('uuid', $request->input('deviceUuid'))->first();
        if ($device) {
            $accessToken = $device->createToken('authToken', ['deviceId'])->accessToken;
            return response()->json([
                'access_token' => $accessToken,
                'premium_status' => $device->premium_status,
                'config_info' => $device->config_info,
            ]);
        } else {
            $newDevice = Device::create([
                'uuid' => Str::uuid(),
                'premium_status' => false,
                'config_info' => null,
            ]);

            $accessToken = $newDevice->createToken('authToken', [$newDevice->uuid])->accessToken;
            return response()->json([
                'access_token' => $accessToken,
                'premium_status' => $newDevice->premium_status,
                'config_info' => $newDevice->config_info,
            ]);
        }
    }
}
