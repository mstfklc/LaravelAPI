<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\OrderHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

class SubscriptionController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'productId' => 'required|string',
            'receiptToken' => 'required|string',
        ]);

        $accessToken = $request->header('Authorization');
        if (!$accessToken) {
            return response()->json([
                'status' => false,
                'error' => 'Unauthorized',
            ]);
        }
        $accessToken = str_replace('Bearer ', '', $accessToken);
        $deviceAuth = Sanctum::personalAccessTokenModel()->where('token', hash('sha256', $accessToken))->first();

        return DB::transaction(function () use ($deviceAuth, $request) {
            $device = $deviceAuth->uuid;
            $product = Product::where('id', $request->input('productId'))->first();

            if (!$device || !$product) {
                return response()->json([
                    'status' => false,
                    'error' => 'Device or product not found',
                ]);
            }

            $order = OrderHistory::create([
                'device_id' => $device,
                'product_id' => $product->id,
                'price' => $product->price,
                'receipt_token' => $request->input('receiptToken'),
                'purchase_time' => now(),
            ]);
            $deviceUpdate = Device::where('uuid', $device)->update([
                'premium_status' => true,
            ]);

            if (!$order || !$deviceUpdate) {
                return response()->json([
                    'status' => false,
                    'error' => 'Order creation or device update failed',
                ]);
            }
            return response()->json([
                'status' => true,
            ]);
        });
    }
}
