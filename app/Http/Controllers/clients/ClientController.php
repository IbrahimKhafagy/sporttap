<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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


