<?php


namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Media;
use App\Models\PlaceSetting;
use App\Models\TempMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{

    // store media
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|mimes:jpeg,jpg,png,mp4|max:2048', // Validate each file in the array
        ]);
        Log::info('Incoming request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->header(),
            'body' => $request->all(),
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $mediaIds = [];

        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();

            // Find or create an instance of YourModel
            $yourModel = TempMedia::firstOrCreate(['name' => $fileName]);

            // Store the uploaded file in the 'images' collection
            $media = $yourModel->addMedia($file)->toMediaCollection('images');

            // Store the ID of the stored media
            $mediaIds[] = $media->id;
        }

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => $mediaIds, // Return the array of media IDs
        ]);
    }

    // store country
    public function storeCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
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

        $country = Country::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'is_active' => $request->input('is_active', true),
        ]);

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => $country
        ]);
    }

    // store City
    public function storeCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'country_id' => 'required|exists:countries,id',
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

        $city = City::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'country_id' => $request->input('country_id'),
            'is_active' => $request->input('is_active', true),
        ]);
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => new CityResource ($city)
        ]);
    }

    // store Area
    public function storeArea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'city_id' => 'required|exists:cities,id',
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
        $area = Area::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'city_id' => $request->input('city_id'),
            'is_active' => $request->input('is_active', true),
        ]);

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => new CityResource ($area)
        ]);
    }

    public function getCities($country_id)
    {

        $cities = City::where('country_id', $country_id)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>  CityResource::collection($cities)
        ]);
    }

    public function getAreas($city_id)
    {

        $cities = Area::where('city_id', $city_id)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>  CityResource::collection($cities)
        ]);
    }

    public function placeSetting ()
    {
        $classification = PlaceSetting::where('type', 'classification')->
        where('is_active',true)->get();

        $players = PlaceSetting::where('type', 'players')->
        where('is_active',true)->get();

        $classification= CityResource::collection($classification);
        $players= CityResource::collection($players);

        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => [
                'classification' =>$classification,
                'players'=>$players
            ]
        ]);
    }
}
