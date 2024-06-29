<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'media_id' => 'nullable|exists:media,id',
            'is_active' => 'nullable|boolean',
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


        $service = Service::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'media_id' => $request->input('media_id'),
            'is_active' => $request->input('is_active', true),
        ]);

        return response()->json(['service' => $service], 201);
    }

    public function getActiveServices()
    {
        $services = Service::where('is_active', true)->get();

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => ServiceResource::collection($services)
            ]);
    }
}
