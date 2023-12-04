<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends Controller
{
    /**
 * @OA\Post(
 *     path="/api/admin/register",
 *     operationId="adminRegister",
 *     tags={"Admin"},
 *     summary="Admin registration",
 *     description="Register a new admin",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Test User"),
 *             @OA\Property(property="email", type="string", example="test@test.com"),
 *             @OA\Property(property="password", type="string", example="123456"),*
     *         @OA\Property(property="is_admin", type="boolean", example="true"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Admin registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="generated_token_here"),
 *         ),
 *     ),
 * )
 */
    public function adminRegister(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:user,name',
            'email' => 'required|email|unique:user,email',
            'password' => 'required',
            'is_admin' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        if ($user) {
            $token = $user->createToken('adminToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'User registration failed'], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/login",
     *     operationId="adminLogin",
     *     tags={"Admin"},
     *     summary="Admin login",
     *     description="Login for admin users",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="test@test.com"),
     *             @OA\Property(property="password", type="string", example="123456"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Admin logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="generated_token_here"),
     *         ),
     *     ),
     * )
     */
    public function adminLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('authToken', ['is_admin' => $user->is_admin])->plainTextToken;
                $response = ['token' => $token];
                return response()->json($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response()->json($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response()->json($response, 422);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/list-order",
     *     operationId="listOrderHistory",
     *     tags={"Admin"},
     *     summary="List order history",
     *     description="Retrieve a paginated list of order history for admin users",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of order history",
     *         @OA\JsonContent(
     *      @OA\Property(property="id", type="integer", example=1),
     *      @OA\Property(property="devices_uuid", type="string", example="f55f7549-d185-433c-9a53-ffeb9ebc6c61"),
     *      @OA\Property(property="product_id", type="integer", example=6),
     *      @OA\Property(property="receipt_token", type="string", example="etsssstst"),
     *      @OA\Property(property="created_at", type="string", example="2023-12-04T04:16:38.000000Z"),
     *      @OA\Property(property="updated_at", type="string", example="2023-12-04T04:16:38.000000Z"),
     *
     *         ),
     *     ),
     * )
     */
    public function listOrderHistory(Request $request): JsonResponse
    {
        $accessToken = $request->user()->currentAccessToken();
        if ($accessToken === null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        $isAdmin = $user->is_admin;


        if (!$isAdmin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $orders = OrderHistory::with(['product:id,name,price'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return response()->json($orders);
    }
}
