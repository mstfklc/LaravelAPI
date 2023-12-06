<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

        $token = $user->createToken('adminToken')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }
    public function adminLogin(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $user = User::where('email', $request->email)->where('is_admin', true)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                $token = $user->createToken('authToken', ['is_admin' => $user->is_admin])->plainTextToken;

                Auth::login($user);
                Auth::guard('web')->logoutOtherDevices($request->password);
                return redirect()->route('listOrderHistory')->withCookie(cookie('authToken', $token));
            }

            throw new ValidationException(
                Validator::make([], []),
                response()->json(['message' => 'Invalid credentials'], 422)
            );

        } catch (ValidationException $e) {
            return $e->getResponse();
        }
    }    public function showAdminLoginForm()
    {
        return view('adminLogin');
    }
}
