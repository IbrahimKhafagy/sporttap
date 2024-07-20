<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playground;
use App\Models\Classification;
use App\Models\Place;
use App\Models\Player;
use App\Models\Image;

class PlaygroundController extends Controller
{
    public function index()
    {
        $playgrounds = Playground::all();
        $places = Place::all();
        return view('playgrounds.playgrounds', compact('playgrounds','places'));
    }



    public function create()
    {
        $playgrounds = Playground::all();
        $places = Place::all();
        return view('playgrounds.playgrounds', compact('playgrounds','places'));
    }


    public function store(Request $request)
    {
        // Validate the playground data
        $validatedData = $request->validate([
            'place_id' => 'nullable|integer|exists:places,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'classification' => 'nullable|integer',
            'player' => 'nullable|string|max:255',
            'images' => 'nullable|string|max:255',
            'price_per_60' => 'nullable|numeric',
            'price_per_90' => 'nullable|numeric',
            'price_per_120' => 'nullable|numeric',
            'price_per_180' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        try {
            Playground::create($validatedData);
            session()->flash('Add', 'تم اضافة المنتج بنجاح');
            return redirect()->route('admin.playgrounds.index')->with('success', 'Playground added successfully.');
        } catch (\Exception $e) {
            // Catch any exceptions and flash an error message
            session()->flash('error', 'فشل في إضافة المنتج: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }





    public function show(Playground $playground)
    {
//        $playgrounds = Playground::all();
//        $places = Place::all();
//        return view('playgrounds.playgrounds', compact('playgrounds','places'));
    }


    // Example controller method
    public function edit($id)
    {
        $playground = Playground::findOrFail($id);
        $places = Place::all();
        $name_ar_options = Playground::distinct()->pluck('name_ar'); // Example fetching of name_ar options
        $name_en_options = Playground::distinct()->pluck('name_en'); // Example fetching of name_en options
        $classifications = Classification::all();
        $players = Player::all();
        $images = Image::all(); // Assuming you have an Image model
        $price_per_60_options = [100, 200, 300]; // Example data
        $price_per_90_options = [150, 250, 350]; // Example data
        $price_per_120_options = [200, 300, 400]; // Example data
        $price_per_180_options = [250, 350, 450]; // Example data

        return view('playgrounds.edit_playgrounds', compact('playground', 'places', 'name_ar_options', 'name_en_options', 'classifications', 'players', 'images', 'price_per_60_options', 'price_per_90_options', 'price_per_120_options', 'price_per_180_options'));
    }

    public function update(Request $request,$id)
    {
        $places = Place::all();
        $validatedData = $request->validate([
            'place_id' => 'required|exists:places,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'classification' => 'nullable|exists:place_settings,id',
            'player' => 'nullable|exists:place_settings,id',
            'images' => 'nullable|string ',
            'is_active' => 'boolean',
            'price_per_60' => 'nullable|numeric',
            'price_per_90' => 'nullable|numeric',
            'price_per_120' => 'nullable|numeric',
            'price_per_180' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
        ]);

        // تحديث الحديقة باستخدام البيانات المدخلة
        $validatedData['is_active'] = $request->has('is_active') ? true : false;

        // Create the playground
        $playground = Playground::findOrFail($id);
        $playground->update($validatedData);

        // العودة إلى الصفحة السابقة
        return redirect()->route('admin.playgrounds.index')->with(compact('places'));
    }



    public function destroy(Playground $playground)
    {
        $playground->delete();

        return redirect()->route('admin.playgrounds.index')->with('success', 'Playground deleted successfully.');
    }

    public function reservations(Playground $playground)
    {
        $reservations = $playground->reservations; // Assuming a relationship is defined
        return view('admin.reservations.index', compact('playground', 'reservations'));
    }
}
