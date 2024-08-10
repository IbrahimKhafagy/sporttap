<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::paginate(50);
        return view('admin.services.services', compact('service'));
    }

    public function getAllServices(Request $request)
    {
        $column = $request->input('column', 'created_at');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $status = $request->input('status');


        $services = Service::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name_ar', 'LIKE', "%$search%")
                        ->orWhere('name_en', 'LIKE', "%$search%");
                });
            })

            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('is_active', $status);
            })
            ->orderBy($column, $direction)
            ->paginate(50);


            foreach ($services as $service) {
                $media = Media::find($service->media_id);
                if ($media) {
                    $filePath = "storage/{$service->media_id}/{$media->file_name}";
                    $service->image= asset("{$filePath}");

                }
            }



        return response()->json(
            $services
        );
    }
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
