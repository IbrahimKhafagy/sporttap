<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Media;
use App\Models\Service;
use App\Models\TempMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                    $service->image= asset((string)($filePath));

                }
            }



        return response()->json(
            $services
        );
    }
    public function edit(Service $service)
    {
        return response()->json([
            'id' => $service->id,
            'name_ar' => $service->name_ar,
            'name_en' => $service->name_en,
            'media_id' => $service->media_id,
            'is_active' => $service->is_active,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'media_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $service = Service::find($id);

        if (!$service) {
            return redirect()->route('admin.services.index')->with('error', 'Service not found!');
        }

        if ($request->hasFile('media_id')) {
            $file = $request->file('media_id');
            $fileName = $file->getClientOriginalName();

            $tempMedia = Media::firstOrCreate(['name' => $fileName]);

            $media = $tempMedia->addMedia($file)->toMediaCollection('media_id');

            $service->media_id = $media->id;
        }

        $service->name_ar = $request->input('name_ar');
        $service->name_en = $request->input('name_en');
        $service->is_active = $request->input('is_active', false);
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'media_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $mediaIds = [];

        if ($request->hasFile('media_id')) {
            foreach ($request->file('media_id') as $file) {
                $fileName = $file->getClientOriginalName();
                // Assuming TempMedia is the model used to handle media files
                $yourModel = Media::firstOrCreate(['name' => $fileName]);
                $media = $yourModel->addMedia($file)->toMediaCollection('media_id');
                $mediaIds[] = $media->id;
            }
        }

        $service = new Service();
        $service->name_ar = $request->input('name_ar');
        $service->name_en = $request->input('name_en');
        $service->is_active = $request->input('is_active', true);
        $service->media_id = json_encode($mediaIds); // Assuming media_ids is stored as JSON
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Service create successfully!');

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
