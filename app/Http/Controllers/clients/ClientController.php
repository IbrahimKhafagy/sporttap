<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{


    public function index()
    {
        $clients = User::paginate(50);
        return view('admin.clients.client', compact('clients'));
    }

    public function show($id)
    {
        $client = User::findOrFail($id);
        return view('admin.clients.pages-profile-settings', compact('client'));
    }
    public function getAllClient(Request $request)
    {
        $column = $request->input('column', 'created_at');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $status = $request->input('status');
        $phone = $request->input('phone');
        $sport_type = $request->input('sport_type');
        $age = $request->input('age');

        $clients = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%$search%")
                        ->orWhere('last_name', 'LIKE', "%$search%");
                });
            })
            ->when($phone, function ($query) use ($phone) {
                return $query->where('phone', 'like', "%$phone%");
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('is_active', $status);
            })
            ->when($sport_type, function ($query) use ($sport_type) {
                return $query->where('sport_type', $sport_type);
            })
            ->when($age, function ($query) use ($age) {
                return $query->where('age', $age);
            })
            ->orderBy($column, $direction)
            ->paginate(50);


        return response()->json(
            $clients
        );
    }

    public function updateMissingData(Request $request)
    {
        try {
            $request->validate([
                'level' => 'required',
                'age' => 'required',
                'gender' => 'required',
                'sport_type' => 'required',
            ]);

            // تحديث البيانات المفقودة
            $clients = User::user();
            $clients->level = $request->input('level');
            $clients->age = $request->input('age');
            $clients->gender = $request->input('gender');
            $clients->sport_type = $request->input('sport_type');
            $clients->save();

            return response()->json(['success' => true, 'message' => __('messages.data_updated')]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => __('messages.error_occurred')], 500);
        }
    }



    public function store(Request $request)
    {
        // التحقق من صحة البيانات الواردة
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'sport_type' => 'nullable|string|max:50',
            'gender' => 'nullable|string|max:10',
            'level' => 'nullable|string|max:50',
            'age' => 'nullable|string|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        // إنشاء مستخدم جديد باستخدام البيانات التي تم التحقق من صحتها
        $user = User::create($validated);

        // توجيه المستخدم إلى صفحة أخرى بعد الإضافة بنجاح
        return redirect('/admin/clients')->with('success', __('messages.client_added_successfully'));
    }







    public function edit($id)
{
    $client = User::findOrFail($id);
    return view('clients.edit', compact('client'));
}


    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        // العثور على العميل وتحديث بياناته
        $client = User::findOrFail($id);
        $client->first_name = $request->input('first_name');
        $client->last_name = $request->input('last_name');
        $client->phone = $request->input('phone');
        $client->save();

        // إعادة توجيه أو عرض رسالة نجاح
        return redirect()->back()->with('success', 'Client updated successfully');
    }




    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
    public function reservations(Client $client)
    {
        $reservations = $client->reservations; // Assuming a relationship is defined
        return view('admin.reservations.index', compact('client', 'reservations'));
    }
}


