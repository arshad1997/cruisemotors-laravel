<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Models\Company;
use App\Models\OptRequest;
use App\Models\User;
use App\Services\SnsOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends BaseAPIController
{
    protected $snsOtpService;

    public function __construct(SnsOtpService $snsOtpService)
    {
        $this->snsOtpService = $snsOtpService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->load(['company', 'roles']);
            return response()->json([
                'message' => 'Login successful',
                'data' => [
                    'token' => [
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'expires_in' => 60 * 60 * 24 * 30
                    ],
                    'user' => $user
                ],
                'success' => true,
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Email or password is incorrect',
                'success' => false,
                'code' => 401
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|string',
            'city_id' => 'nullable|exists:cities,id',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'nullable|exists:countries,id',

            // Role should be required
            'role' => 'required|string',

            // Company fields should only be required if role is company
            'designation' => 'required_if:role,company|string',
            'company_name' => 'required_if:role,company|string',
//            'company_email' => 'required_if:role,company|email',
//            'company_phone' => 'required_if:role,company|string',
            'company_website' => 'nullable|string',
            'company_address' => 'required_if:role,company|string',
        ]);

        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id
        ]);

        // Check role and create if it doesn't exist
        $roleName = $request->role === 'company' ? 'company' : 'user';
        $role = Role::query()->firstOrCreate(['name' => $roleName]);

        if ($roleName === 'company') {
            $user->update([
                'designation' => $request->designation
            ]);

            $company = Company::query()->create([
                'name' => $request->company_name,
                'email' => $request->company_email,
                'phone' => $request->company_phone,
                'website' => $request->company_website,
                'address' => $request->company_address,
                'user_id' => $user->id
            ]);
        }

        // Assign the role to the user
        $user->assignRole($roleName);

        $user->load('company');
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'data' => [
                'token' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => 60 * 60 * 24 * 30
                ],
                'user' => $user
            ],
            'success' => true,
            'code' => 201
        ], 201);

    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful',
            'success' => true,
            'code' => 200
        ]);
    }

    public function verifyToken(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                'message' => 'Token is valid',
                'success' => true,
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Token is invalid',
                'success' => false,
                'code' => 401
            ], 401);
        }
    }

    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^\+\d{1,15}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid phone number'], 400);
        }

        $phoneNumber = $request->input('phone_number');
        $userExist = User::query()->where('phone', $phoneNumber)->exists();

        if ($userExist) {
            $liveRequest = OptRequest::query()
                ->where('phone', $phoneNumber)
                ->where('expires_at', '>', now())
                ->whereNull('verified_at')
                ->where('status', 'pending')
                ->first();

            // Check if a request exists and was sent within the last 60 seconds
            if ($liveRequest) {
                $secondsSinceLastSent = now()->diffInSeconds($liveRequest->sent_at);

                if ($secondsSinceLastSent < 60) {
                    return response()->json([
                        'code' => 400,
                        'error' => 'OTP already sent. Please wait before requesting again.',
                        'time_left' => 60 - $secondsSinceLastSent
                    ], 400);
                }
            }

            // Generate and send OTP
            $otpCode = rand(100000, 999999); // Generate a 6-digit OTP code
            $messageId = $this->snsOtpService->sendOtp($phoneNumber, $otpCode);

            if ($messageId) {
                // Update existing OTP request or create a new one
                OptRequest::query()->updateOrCreate(
                    ['phone' => $phoneNumber],
                    [
                        'otp_code' => $otpCode,
                        'message_id' => $messageId,
                        'sent_at' => now(),
                        'expires_at' => now()->addMinutes(5)
                    ]
                );

                return response()->json(['code' => 200, 'success' => 'OTP sent successfully', 'messageId' => $messageId]);
            }
        } else {
            return response()->json(['code' => 404, 'error' => 'User not found'], 404);
        }

        return response()->json(['code' => 500, 'error' => 'Failed to send OTP'], 500);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^\+\d{1,15}$/',
            'otp_code' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid phone number or OTP code'], 400);
        }

        $phoneNumber = $request->input('phone_number');
        $otpCode = $request->input('otp_code');

        $optRequest = OptRequest::query()
            ->where('phone', $phoneNumber)
            ->where('otp_code', $otpCode)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->first();

        if ($optRequest) {
            $optRequest->update(['verified_at' => now(), 'status' => 'verified']);
            return response()->json(['code' => 200, 'success' => 'OTP verified successfully']);
        }

        return response()->json(['code' => 400, 'error' => 'Invalid OTP code'], 400);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^\+\d{1,15}$/',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid phone number, or password'], 400);
        }

        $phoneNumber = $request->input('phone_number');
        $password = $request->input('password');

        $optRequest = OptRequest::query()
            ->where('phone', $phoneNumber)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->first();

        if ($optRequest) {
            $optRequest->update(['verified_at' => now(), 'status' => 'verified']);

            $user = User::query()->where('phone', $phoneNumber)->first();
            $user->update(['password' => bcrypt($password)]);

            return response()->json(['code' => 200, 'success' => 'Password reset successfully']);
        }

        return response()->json(['code' => 400, 'error' => 'Invalid OTP code'], 400);
    }
}
