<?php

namespace App\Http\Controllers\clints;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Console\View\Components\Alert;

class clintController extends Controller
{


    public function index()
    {
        $clients = User::all();
        return view('clients', compact('clients'));
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


