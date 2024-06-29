<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\ContactMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactusController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',]);
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

        // Create a new contactus instance
        $contactus = new ContactMessages();
        $contactus->provider_id = $request->user()->id; // Assuming authenticated user
        $contactus->title = $request->title;
        $contactus->message = $request->message;
        $contactus->status = 'pending'; // Set the initial status

        // Save the contactus request
        $contactus->save();

        // Return a success response
        return response()->json([
            'status' => 200,
            'msg' => __('validation.Contact us request submitted successfully'),
            'data' => null
        ]);
    }
}
