<?php

namespace App\Http\Controllers\clints;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class clintController extends Controller
{


    public function index()
    {
        $clients = User::paginate(50);
        return view('admin.clients.client', compact('clients'));
    }
    public function getData(Request $request)
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

        $clients = User::with(['place', 'classificationSetting', 'playerSetting'])
            ->where(function($query) use ($search) {
                $query->where('name_ar', 'LIKE', "%$search%")
                    ->orWhere('name_en', 'LIKE', "%$search%");
            })
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($status !== 'all', function($query) use ($status) {
                return $query->where('is_active', $status);
            })
            ->when($phone, function($query) use ($phone) {
                return $query->whereHas('place', function($q) use ($phone) {
                    $q->where('name', 'LIKE', "%$phone%");
                });
            })
            ->when($sport_type, function($query) use ($sport_type) {
                return $query->whereHas('classificationSetting', function($q) use ($sport_type) {
                    $q->where('name', 'LIKE', "%$sport_type%");
                });
            })
            ->when($age, function($query) use ($age) {
                return $query->whereHas('playerSetting', function($q) use ($age) {
                    $q->where('name', 'LIKE', "%$age%");
                });
            })
            ->orderBy($column, $direction)
            ->paginate(50);

        return response()->json(
            $clients
        );
    }
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'sport_type' => 'required|string|max:50',
            'gender' => 'required|string|max:10',
            'level' => 'required|string|max:50',
            'check' => 'nullable|boolean',
            'age' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // dd($validatedData);
        User::create($validatedData);

        return redirect()->route('clients.index')->with('success', 'تمت إضافة العميل بنجاح!');
    }




    public function edit($id)
{
    $client = User::findOrFail($id);
    return view('clients.edit', compact('client'));
}


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:15',
            'sport_type' => 'sometimes|required|string|max:50',
            'gender' => 'sometimes|required|string|max:10',
            'level' => 'sometimes|required|string|max:50',
            'check' => 'sometimes|required|boolean',
            'age' => 'sometimes|required|integer',
            'is_active' => 'sometimes|required|boolean',
        ]);

        $user->update($validatedData);

        return response()->json($user, 200);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}


