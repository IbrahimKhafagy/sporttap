<?php

namespace App\Http\Controllers;

use App\Models\Playground;
use Illuminate\Http\Request;

class PlaygroundController extends Controller
{
    public function index()
    {
        $playgrounds = Playground::get();
        return view('playgrounds', compact('playgrounds'));
        }

        public function create()
        {
            $playgrounds = Playground::get();
            return view('playgrounds', compact('playgrounds'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'classification' => 'nullable|exists:place_settings,id',
            'player' => 'nullable|exists:place_settings,id',
            'images' => 'nullable|json',
            'is_active' => 'boolean',
            'price_per_60' => 'nullable|numeric',
            'price_per_90' => 'nullable|numeric',
            'price_per_120' => 'nullable|numeric',
            'price_per_180' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
        ]);

        Playground::create($request->all());

        return redirect()->route('playgrounds.index')->with('success', 'Playground created successfully.');
    }

    public function show(Playground $playground)
    {
        return view('playgrounds', compact('playground'));
    }

    public function edit($id)
    {
        dd($id);
        // $playground = Playground::findOrFail($id);
        // return view('playgrounds.edit', compact('playground'));
    }

    public function update(Request $request, Playground $playground)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'classification' => 'nullable|exists:place_settings,id',
            'player' => 'nullable|exists:place_settings,id',
            'images' => 'nullable|json',
            'is_active' => 'boolean',
            'price_per_60' => 'nullable|numeric',
            'price_per_90' => 'nullable|numeric',
            'price_per_120' => 'nullable|numeric',
            'price_per_180' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
        ]);

        $playground->update($request->all());

        return redirect()->route('playgrounds.index')->with('success', 'Playground updated successfully.');
    }

    public function destroy($id)
    {
        $playground = Playground::findOrFail($id);
        $playground->delete();

        return redirect()->with('success', 'Playground deleted successfully.');
    }

    public function reservations(Playground $playground)
{
    $reservations = $playground->reservations; // Assuming a relationship is defined
    return view('reservations', compact('playground', 'reservations'));
}
}

