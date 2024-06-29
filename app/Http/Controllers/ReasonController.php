<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReasonController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'type' => 'required|in:cancel,refund', // Ensure type is either "cancel" or "refund"
            'is_active' => 'required|boolean',

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
        // Validate incoming request data
        $validatedData = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'type' => 'required|in:cancel,refund', // Ensure type is either "cancel" or "refund"
            'is_active' => 'required|boolean',
        ]);

        // Create and store the new reason
        $reason = Reason::create($validatedData);

        return response()->json(['reason' => $reason], 201);
    }

    public function reasons(Request $request)
    {

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:cancel,refund',

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


        // Retrieve active reasons based on the type from the request
        $reasons = Reason::where('type', $request->type)
            ->where('is_active', true)
            ->get();
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => $this->convertReasonsToLanguage($reasons,$request->header("lang"))
        ]);
    }


    private function convertReasonsToLanguage($reasons, $lang)
    {
        return $reasons->map(function ($reason) use ($lang) {
            return [
                'id' => $reason->id,
                'name' => $lang === 'ar' ? $reason->name_ar : $reason->name_en,
                'type' => $reason->type,
                'is_active' => $reason->is_active,
            ];
        });
    }
}
