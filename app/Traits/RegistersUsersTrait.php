<?php
namespace App\Traits;


use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponsesTrait;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

trait RegistersUsersTrait
{
    use ApiResponsesTrait;

    public function register(RegisterRequest $request)
    {
        $user = $this->saveOrUpdate($request->validated());

        return $this->registrationSuccessResponse($user);
    }




    protected function saveOrUpdate(array $data)
    {
        return User::updateOrCreate($data);
    }

    protected function registrationSuccessResponse($user)
    {
        $responseData = [
            'data' => new UserResource($user),
            'message' => __('messages.success_register'),
            'code' => 200,
        ];

        return response()->json($responseData, 201);
    }
}
?>

