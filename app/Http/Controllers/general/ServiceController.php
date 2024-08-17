<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }




    // في ملف التعديل (مثل: UpdateServiceController.php)
    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'media_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // إذا تم رفع صورة جديدة
        if ($request->hasFile('media_id')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($service->media_id && Storage::disk('public')->exists($service->media_id)) {
                Storage::disk('public')->delete($service->media_id);
            }

            // حفظ الصورة الجديدة
            $path = $request->file('media_id')->store('services', 'public');
            $validatedData['media_id'] = $path;
        }

        $service->update($validatedData);

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

        // إنشاء الخدمة الجديدة
        $service = Service::create($validatedData);

        if ($request->hasFile('media_id')) {
            // حفظ الملف و الحصول على المسار
            $path = $request->file('media_id')->store('services', 'public');

            // تحديث حقل media_path في جدول services
            $service->update(['media_path' => $path]);
        }

        // إذا كنت ترغب في معالجة مجموعة من الخدمات، يجب أن يتم ذلك بشكل منفصل
        // (هذا ليس عادةً ما يتم في طريقة `store`، لكن سأوفر مثالاً على ذلك إذا لزم الأمر)

        return redirect()->route('admin.services.index')->with('success', 'Service added successfully!');
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
