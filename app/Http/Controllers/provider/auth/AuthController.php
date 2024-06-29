<?php

namespace App\Http\Controllers\provider\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\VerificationCodeMail;
use App\Models\Media;
use App\Models\Provider;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = Provider::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'is_active'=>1,
            'password' => Hash::make($validatedData['password']),
        ]);
        $verificationCode = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

// Store the verification code in the verification table
        $verification = Verification::updateOrCreate(
            ['phone' => $user->phone], // Search condition: Update based on the email column
            ['code' => $verificationCode] // Data to update or insert
        );

        return response()->json([
            'status' => 201,
            'msg' => __('validation.user_registered_successfully'),
            'data' => $verificationCode
        ]);
    }

    public function verifyUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required',
        ]);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        $verification = Verification::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if ($verification) {
            $user = Provider::where('phone', $request->phone)->first();
            // Update user attributes
            $user->verified_at = now(); // Set email_verified_at to current timestamp
            $user->is_verified = 1; // Set is_verified to 1 (verified)

            // Save the updated user object
            $user->save();
            $verification->delete(); // Remove the verification record

            $token = $user->createToken('token')->plainTextToken;
            $response['msg'] = __('validation.user_verified_successfully');
            $user['token'] = $token;
            $response["data"] = $user;
            $response["status"] = 200;

            return response()->json(
                $response);

        }
        $response['msg'] = __('validation.InvalidCode');

        return response()->json($response);
    }

    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required']);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        $user = Provider::where('phone', $request->phone)->first();

        if ($user) {
            // Generate a new verification code
            $verificationCode = mt_rand(1000, 9999);

            // Store the verification code in the verification table
            $verification = Verification::updateOrCreate(
                ['phone' => $user->phone],
                ['code' => $verificationCode]
            );

            $response['msg'] = __('validation.codeResent');
            $response["status"] = 200;
            $response["data"] = $verificationCode;


            return response()->json($response);
        }
             $response['msg'] = __('validation.user_not_found');

        return response()->json($response);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();



            if ($user->is_verified == 0) {
                // Resend verification code logic
                // Generate a new verification code
                $verificationCode = mt_rand(1000, 9999);

                // Store the verification code in the verification table
                $verification = Verification::updateOrCreate(
                    ['phone' => $user->phone],
                    ['code' => $verificationCode]
                );
                $response['msg'] = __('validation.user_not_verified');
                $response["status"] = 410;
                $response["data"] = $verificationCode;

                return response()->json($response);
            }

            if ($user->is_active == 0) {
                $response['msg'] = __('validation.user_not_active');
                return response()->json($response);
            }

            $token = $user->createToken('token')->plainTextToken;
            $response['msg'] = __('validation.user_login_successfully');
            $user['token'] = $token;
            $response["data"] = $user;
            $response["status"] = 200;
            return response()->json($response);
        }
        $response['msg'] = __('validation.invalid_credentials');

        return response()->json($response);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required']);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        $user = Provider::where('phone', $request->phone)->first();

        if ($user) {
            // Generate a new verification code
            $verificationCode = mt_rand(1000, 9999);

            // Store the verification code in the verification table
            $verification = Verification::updateOrCreate(
                ['phone' => $user->phone],
                ['code' => $verificationCode]
            );

            $response['msg'] = __('validation.codeSent');
            $response["status"] = 200;
            $response["data"] = $verificationCode;

            return response()->json($response);
        }
        $response['msg'] = __('validation.user_not_found');

        return response()->json($response);
    }

    public function verifyUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required',
        ]);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        $verification = Verification::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if ($verification) {
            $user = Provider::where('phone', $request->phone)->first();

            $verification->delete(); // Remove the verification record

            $token = $user->createToken('token')->plainTextToken;
            $response['msg'] = __('validation.user_verified_successfully');
            $user['token'] = $token;
            $response["data"] = $user;
            $response["status"] = 200;

            return response()->json(
                $response);

        }
        $response['msg'] = __('validation.InvalidCode');

        return response()->json($response);
    }
    public function resetPassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8'
            ]);
            $response = [
                'status' => 401,
                'msg' => "",
                'data' => null
            ];
            if ($validator->fails()) {
                $firstError = $validator->errors()->first();
                $response['msg'] = $firstError;
                return response()->json($response);
            }

            $user = $request->user();
            $user->password = Hash::make($request->password);
            $user->save();
            $response['msg'] = __('validation.passwordReset');
            $response["status"] = 200;

            return response()->json(
                $response);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to reset password'], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'image' => 'nullable|exists:media,id',
        ]);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update user information if provided
        $userData = [];
        if ($request->has('name')) {
            $userData['name'] = $request->name;
        }
        if ($request->has('image')) {
            $userData['image'] =$request->image;
        }

        // Update user record
        $user->update($userData);

        // Get the current access token for the user
        $user['token'] = $request->bearerToken();
        $user['isOrganized'] = $user->isOrganized;


        if($user->image) {
            $media = Media::find($user->image);
            $filePath = "storage/$user->image/{$media->file_name}";
            // Use Laravel's asset function to generate the URL
            $fullUrl = asset("{$filePath}");
            $user['image'] = $fullUrl;

        }

        $response['msg'] ='User information updated successfully';
        $response["data"] = $user;
        $response["status"] = 200;


        // Return a success response
        return response()->json($response);
    }


    public function sendOTPChangePhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:255|unique:providers']);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }


            // Generate a new verification code
            $verificationCode = mt_rand(1000, 9999);

            // Store the verification code in the verification table
            $verification = Verification::updateOrCreate(
                ['phone' => $request->phone],
                ['code' => $verificationCode]
            );

            $response['msg'] = __('validation.codeSent');
            $response["status"] = 200;
            $response["data"] = $verificationCode;

            return response()->json($response);


    }
    public function verifyChangePhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required',
        ]);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        $verification = Verification::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if ($verification) {
            $user = Auth::user();
            $verification->delete();

            $userData = [];
            $userData['phone'] =$request->phone;
             // Update user record
             $user->update($userData);

            $user = Auth::user();
            $user['token'] = $request->bearerToken();
            $response['msg'] = __('validation.user_changed_successfully');
            $response["data"] = $user;
            $response["status"] = 200;


            return response()->json(
                $response);

        }
        $response['msg'] = __('validation.InvalidCode');

        return response()->json($response);
    }

    public function sendOTPChangeEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:providers',]);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }


        // Generate a new verification code
        $verificationCode = mt_rand(1000, 9999);

        // Store the verification code in the verification table
        $verification = Verification::updateOrCreate(
            ['phone' => $request->email],
            ['code' => $verificationCode]
        );

        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

        $response['msg'] = __('validation.codeSent');
        $response["status"] = 200;
        $response["data"] = $verificationCode;

        return response()->json($response);


    }
    public function verifyChangeEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:providers',
            'code' => 'required',
        ]);
        $response = [
            'status' => 401,
            'msg' => "",
            'data' => null
        ];
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            $response['msg'] = $firstError;
            return response()->json($response);
        }

        $verification = Verification::where('phone', $request->email)
            ->where('code', $request->code)
            ->first();

        if ($verification) {
            $user = Auth::user();
            $verification->delete();

            $userData = [];
            $userData['email'] =$request->email;
            // Update user record
            $user->update($userData);

            $user = Auth::user();
            $user['token'] = $request->bearerToken();
            $response['msg'] = __('validation.user_changed_successfully');
            $response["data"] = $user;
            $response["status"] = 200;


            return response()->json(
                $response);

        }
        $response['msg'] = __('validation.InvalidCode');

        return response()->json($response);
    }

    public function show(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Get the current access token for the user
        $user['token'] = $request->bearerToken();


        if($user->image) {
            $media = Media::find($user->image);
            $filePath = "storage/$user->image/{$media->file_name}";
            // Use Laravel's asset function to generate the URL
            $fullUrl = asset("{$filePath}");
            $user['image'] = $fullUrl;

        }

        // Return the user profile resource
        return response()->json([
            'status' => 200,
            'msg' =>  null,
            'data' => $user,


        ]);

    }

}
