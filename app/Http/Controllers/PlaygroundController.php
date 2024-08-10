<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\PlaceSetting;
use App\Models\TempMedia;
use Illuminate\Http\Request;
use App\Models\Playground;
use App\Models\Classification;
use App\Models\Place;
use App\Models\Player;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;

class PlaygroundController extends Controller
{
    public function index()
    {
        $playgrounds=Playground::paginate(50);
        return view('admin.playgrounds.playgrounds',compact('playgrounds'));
    }

    public function getPlaygrounds(Request $request)
    {
        $column = $request->input('column', 'created_at');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $status = $request->input('status');
        $place = $request->input('place');
        $classification = $request->input('classification');
        $player = $request->input('player');

        $playgrounds = Playground::with(['place', 'classificationSetting', 'playerSetting'])
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
            ->when($place, function($query) use ($place) {
                return $query->whereHas('place', function($q) use ($place) {
                    $q->where('name', 'LIKE', "%$place%");
                });
            })
            ->when($classification, function($query) use ($classification) {
                return $query->whereHas('classificationSetting', function($q) use ($classification) {
                    $q->where('name', 'LIKE', "%$classification%");
                });
            })
            ->when($player, function($query) use ($player) {
                return $query->whereHas('playerSetting', function($q) use ($player) {
                    $q->where('name', 'LIKE', "%$player%");
                });
            })
            ->orderBy($column, $direction)
            ->paginate(50);
        foreach ($playgrounds as $playgroundOne) {
            if($playgroundOne->place) {
                if ($playgroundOne->place->logo) {
                    $id=$playgroundOne->place->logo;
                    $media = Media::find($id);

                    if ($media) {
                        $filePath = "storage/{$id}/{$media->file_name}";

                        // Append the file path to each user object
                        $playgroundOne->place->logo = asset($filePath);

                    }
                }

                if ($playgroundOne->place->images) {
                   $images=[];
                   foreach ($playgroundOne->place->images as $image) {
                       $media = Media::find($image);
                       if ($media) {
                           $filePath = "storage/{$image}/{$media->file_name}";
                           $images[] = asset($filePath);

                       }
                   }
                    $playgroundOne->place->images=$images;

                }

                if ($playgroundOne->images) {
                    $images=[];
                    foreach ($playgroundOne->images as $image) {
                        $media = Media::find($image);
                        if ($media) {
                            $filePath = "storage/{$image}/{$media->file_name}";
                            $images[] = asset("{$filePath}");

                        }
                    }
                    $playgroundOne->images=$images;

                }
            }
        }
        return response()->json(
            $playgrounds
        );
    }


    public function create()
    {
        $classification = PlaceSetting::where('type', 'classification')->
        where('is_active',true)->get();

        $players = PlaceSetting::where('type', 'players')->
        where('is_active',true)->get();

        $places=Place::all();

        return view('admin.playgrounds.add_playground', compact('classification','players','places'));
    }


    public function store(Request $request)
    {
        // Validate the playground data
        $validator = Validator::make($request->all(), [
            'place_id' => 'nullable|integer|exists:places,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'classification' => 'nullable|integer',
            'player' => 'nullable|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price_per_60' => 'nullable|numeric',
            'price_per_90' => 'nullable|numeric',
            'price_per_120' => 'nullable|numeric',
            'price_per_180' => 'nullable|numeric',
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
        // Initialize an array to hold media IDs
        $mediaIds = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = $file->getClientOriginalName();
                // Find or create an instance of TempMedia
                $yourModel = TempMedia::firstOrCreate(['name' => $fileName]);
                // Store the uploaded file in the 'images' collection
                $media = $yourModel->addMedia($file)->toMediaCollection('images');
                // Collect the media ID
                $mediaIds[] = $media->id;
            }
        }

        $playground = new Playground();
        $playground->place_id = $request->input('place_id');
        $playground->name_ar = $request->input('name_ar');
        $playground->name_en = $request->input('name_en');
        $playground->classification = $request->input('classification');
        $playground->player = $request->input('player');
        $playground->price_per_60 = $request->input('price_per_60');
        $playground->price_per_90 = $request->input('price_per_90');
        $playground->price_per_120 = $request->input('price_per_120');
        $playground->price_per_180 = $request->input('price_per_180');
        $playground->is_active = $request->input('is_active', false);
        $playground->images=$mediaIds;
        $playground->save();


        return response()->json([
            'status' => 200,
            'msg' => __('messages.playground_created'),
            'data' => null
        ]);
    }





    public function show(int $playground)
    {
        $playground = Playground::findOrFail($playground);
        $classification = PlaceSetting::where('type', 'classification')->
        where('is_active',true)->get();

        $players = PlaceSetting::where('type', 'players')->
        where('is_active',true)->get();

        $places=Place::all();
        if ($playground->images) {
            $images=[];
            foreach ($playground->images as $image) {
                $media = Media::find($image);
                if ($media) {
                    $filePath = "storage/{$image}/{$media->file_name}";
                    $images[] = asset("{$filePath}");

                }
            }
            $playground->images=$images;

        }

        return view('admin.playgrounds.edit_playground', compact('playground','classification','players','places'));
    }

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

        return view('admin.playgrounds.playgrounds', compact('playground', 'places', 'name_ar_options', 'name_en_options', 'classifications', 'players', 'images', 'price_per_60_options', 'price_per_90_options', 'price_per_120_options', 'price_per_180_options'));
    }
    // Example controller method


    public function update(Request $request, $id)
    {
        // Validate the playground data
        $validator = Validator::make($request->all(), [
            'place_id' => 'nullable|integer|exists:places,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'classification' => 'nullable|integer',
            'player' => 'nullable|string|max:255',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price_per_60' => 'nullable|numeric',
            'price_per_90' => 'nullable|numeric',
            'price_per_120' => 'nullable|numeric',
            'price_per_180' => 'nullable|numeric',
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

        $playground = Playground::find($id);
        if (!$playground) {
            $response['msg'] = 'Playground not found';
            return response()->json($response);
        }

        // Initialize an array to hold media IDs
        $mediaIds = $playground->images ?: [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = $file->getClientOriginalName();
                // Find or create an instance of TempMedia
                $yourModel = TempMedia::firstOrCreate(['name' => $fileName]);
                // Store the uploaded file in the 'images' collection
                $media = $yourModel->addMedia($file)->toMediaCollection('images');
                // Collect the media ID
                $mediaIds[] = $media->id;
            }
        }

        $playground->place_id = $request->input('place_id');
        $playground->name_ar = $request->input('name_ar');
        $playground->name_en = $request->input('name_en');
        $playground->classification = $request->input('classification');
        $playground->player = $request->input('player');
        $playground->price_per_60 = $request->input('price_per_60');
        $playground->price_per_90 = $request->input('price_per_90');
        $playground->price_per_120 = $request->input('price_per_120');
        $playground->price_per_180 = $request->input('price_per_180');
        $playground->is_active = $request->input('is_active', false);
        $playground->images = $mediaIds;
        $playground->save();

        return response()->json([
            'status' => 200,
            'msg' => __('messages.playground_update'),
            'data' => null
        ]);
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
