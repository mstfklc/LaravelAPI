<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;


class SubscriptionController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/purchase/product",
     *     operationId="purchaseProduct",
     *     tags={"Subsciption"},
     *     summary="Purchase a product",
     *     description="Process a product purchase for authenticated users",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="productId", type="string", example="123456"),
     *             @OA\Property(property="receiptToken", type="string", example="example_receipt_token"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product purchased successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *         ),
     *     ),
     * )
     */
    public function purchaseProduct(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|string',
            'receiptToken' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        $user = Auth::user();

        return DB::transaction(function () use ($user, $request) {
            $uuid = $user->uuid;
            $product = Product::find($request->input('productId'));

            if (!$product) {
                return response()->json(['errors' => 'Product not found'], 400);
            }
            OrderHistory::create([
                'devices_uuid' => $uuid,
                'product_id' => $product->id,
                'receipt_token' => $request->input('receiptToken'),
            ]);
            $user->update([
                'premium_status' => true,
            ]);

            return response()->json([
                'status' => true,
            ]);
        });
    }
}
