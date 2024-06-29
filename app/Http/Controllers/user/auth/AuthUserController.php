<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyRequest;
use App\Models\Media;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\Verification;
use App\Traits\ApiResponsesTrait;
use App\Traits\RegistersUsersTrait;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request; // Import the Request class
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    use RegistersUsersTrait;
    use ApiResponsesTrait;


    public function login(LoginRequest $request)
    {
        $phoneNumber = $request->input('phone');

        $code = rand(1000, 9999);
        UserVerification::updateOrCreate(
            ["phone" => $phoneNumber],
            ["code" => $code]
        );
        return $this->successResponse($code, __('messages.Verification_code_sent'), 200);
    }


    public function verify(VerifyRequest $request)
    {
        $phoneNumber = $request->input('phone');
        $code = $request->input('code');


        $verification = UserVerification::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if($verification){

            $user = User::where('phone', $verification->phone)->first();


            $isUserComplete=1;

            if (!$user) {

                $isUserComplete=0;
                $user= new User();
                $user->phone= $verification->phone;
                $user->is_active=1;
                $user->save();

            }
            else {
                foreach ($user->getAttributes() as $key => $value) {
                    if (is_null($value) && $key !="remember_token") {
                        $isUserComplete = 0;
                        break;
                    }
                }
            }
            $token = $user->createToken('token')->plainTextToken;

            UserVerification::where('phone', $phoneNumber)->delete();
            $user = User::where('phone', $verification->phone)->first();

            $user= new UserResource($user);
            $user['token'] = $token;



            return $this->successResponse($user, $isUserComplete==1 ? __('messages.verify_completed') : __('messages.complete_data'), $isUserComplete==1?200:201);

        }else{
            return $this->errorResponse(__('messages.uncorrect_code'), 401);
        }
    }

    public function update(Request $request,  $id)
    {
        // Validate incoming request data

        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone,' . $id,
            'country_code' => 'nullable|string',
            'sport_type' => 'nullable|in:Tennis,Padel',
            'gender' => 'nullable|in:male,female',
            'level' => 'nullable|in:junior,middle,advanced',
            'check' => 'nullable|string',
            'age' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return $this->errorResponse( $firstError, 401);

        }

        $validatedData = $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'sport_type' => 'nullable|in:Tennis,Padel',
            'gender' => 'nullable|in:male,female',
            'level' => 'nullable|in:junior,middle,advanced',
            'check' => 'nullable|string',
            'age' => 'nullable|string',
            // Add validation rules for other fields if needed
        ]);
        $user = User::where('id', $id)->first();

        // Fill the user model with validated data
        $user->fill($validatedData);

        // Save the user
        $user->save();
        $user['token'] = $request->bearerToken();
        $user= new UserResource($user);
        return $this->successResponse( $user,"تم تحديث البيانات بنجاح", 401);

    }

    public function show(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Get the current access token for the user


        if($user->image) {
            $media = Media::find($user->image);
            $filePath = "storage/$user->image/{$media->file_name}";
            // Use Laravel's asset function to generate the URL
            $fullUrl = asset("{$filePath}");
            $user['image'] = $fullUrl;

        }
        $user=new UserResource($user);
        $user['token'] = $request->bearerToken();
        $isUserComplete=1;
        foreach ($user->getAttributes() as $key => $value) {
            if (is_null($value) && $key !="remember_token") {
                $isUserComplete = 0;
                break;
            }
        }
        return  $this->successResponse($user,"",$isUserComplete==1?200:201);



    }


}
