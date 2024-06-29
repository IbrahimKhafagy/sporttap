<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Place;
use App\Models\Playground;
use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class PlaceController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // Validation rules for place data
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'desc_en' => 'required|string',
            'desc_ar' => 'required|string',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'services' => 'required|array',
            'services.*' => 'required|exists:services,id',
            'logo' => 'required|exists:media,id',
            'images' => 'required|array',
            'images.*' => 'required|exists:media,id',

            // Validation rules for playground data
            'playgrounds' => 'required|array',
            'playgrounds.*.name_ar' => 'required|string',
            'playgrounds.*.name_en' => 'required|string',
            'playgrounds.*.classification' => 'required|exists:place_settings,id',
            'playgrounds.*.player' => 'required|exists:place_settings,id',
            'playgrounds.*.images' => 'required|array',
            'playgrounds.*.images.*' => 'required|exists:media,id',
            'playground.*.price_per_60' => 'required|numeric',
            'playground.*.price_per_90' => 'required|numeric',
            'playground.*.price_per_120' => 'required|numeric',
            'playground.*.price_per_180' => 'required|numeric',

            // Validation rules for working hours data
            'working_hours' => 'required|array',
            'working_hours.*.day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'working_hours.*.is_open' => 'required',
            'working_hours.*.start_time' => 'nullable|date_format:H:i:s',
            'working_hours.*.end_time' => 'nullable|date_format:H:i:s',
        ]);
        Log::info('Incoming request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->header(),
            'body' => $request->all(),
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


        $providerId = Auth::id();



        // Create place
        $place = Place::create($request->only([
                'name_ar', 'name_en', 'desc_ar', 'desc_en', 'email', 'website',
                'phone', 'city_id', 'area_id', 'lat', 'lng',
                'address_details', 'services', 'social', 'pending', 'logo', 'images'
            ]) + ['provider_id' => $providerId]);

        // Create playgrounds
        $playgroundsData = $request->input('playgrounds');
        foreach ($playgroundsData as $playgroundData) {
            $playgroundData['place_id'] = $place->id;
            Playground::create($playgroundData);
        }

        // Create working hours
        $workingHoursData = $request->input('working_hours');
        foreach ($workingHoursData as $workingHourDataItem) {
            $workingHourDataItem['place_id'] = $place->id;
            if ($workingHourDataItem['is_open'] === false || strtolower($workingHourDataItem['is_open']) === 'false') {
                $workingHourDataItem['is_open'] = false;
            } else {
                $workingHourDataItem['is_open'] = true;
            }

            WorkingHour::create($workingHourDataItem);
        }

        return response()->json([
            'status' => 200,
            'msg' =>  __('validation.placeADDEd'),
            'data' =>null
        ]);


    }
    public function update(Request $request, $id)
    {

        // Get the validation rules dynamically based on the provided request data
        $validationRules = [

        ];
        $requestData = $request->all();

        // Add validation rules for fields that are present in the request
        if (isset($requestData['name_ar'])) {
            $validationRules['name_ar'] = 'required|string';
        }
        if (isset($requestData['name_en'])) {
            $validationRules['name_en'] = 'required|string';
        }
        if (isset($requestData['desc_ar'])) {
            $validationRules['desc_ar'] = 'required|string';
        }
        if (isset($requestData['desc_en'])) {
            $validationRules['desc_en'] = 'required|string';
        }
        if (isset($requestData['email'])) {
            $validationRules['email'] = 'required|email';
        }
        if (isset($requestData['website'])) {
            $validationRules['website'] = 'nullable|url';
        }
        if (isset($requestData['phone'])) {
            $validationRules['phone'] = 'required|string';
        }
        if (isset($requestData['city_id'])) {
            $validationRules['city_id'] = 'required|exists:cities,id';
        }
        if (isset($requestData['area_id'])) {
            $validationRules['area_id'] = 'required|exists:areas,id';
        }
        if (isset($requestData['lat'])) {
            $validationRules['lat'] = 'required|numeric';
        }
        if (isset($requestData['lng'])) {
            $validationRules['lng'] = 'required|numeric';
        }
        if (isset($requestData['address_details'])) {
            $validationRules['address_details'] = 'required|string';
        }
        if (isset($requestData['services'])) {
            $validationRules['services'] = 'required|array';
        }
        if (isset($requestData['social'])) {
            $validationRules['social'] = 'nullable|array';
        }
        if (isset($requestData['pending'])) {
            $validationRules['pending'] = 'required|string';
        }
        if (isset($requestData['logo'])) {
            $validationRules['logo'] = 'required|exists:media,id';
        }
        if (isset($requestData['images'])) {
            $validationRules['images'] = 'nullable|array';
        }
        if (isset($requestData['playgrounds'])) {
            $validationRules['playgrounds'] = 'required|array';
        }
        if (isset($requestData['playgrounds.*.name_ar'])) {
            $validationRules['playgrounds.*.name_ar'] = 'required|string';
        }
        if (isset($requestData['playgrounds.*.name_en'])) {
            $validationRules['playgrounds.*.name_en'] = 'required|string';
        }
        if (isset($requestData['playgrounds.*.classification'])) {
            $validationRules['playgrounds.*.classification'] = 'required|integer';
        }
        if (isset($requestData['playgrounds.*.player'])) {
            $validationRules['playgrounds.*.player'] = 'required|integer';
        }
        if (isset($requestData['playgrounds.*.images'])) {
            $validationRules['playgrounds.*.images'] = 'nullable|array';
        }
        if (isset($requestData['playgrounds.*.is_active'])) {
            $validationRules['playgrounds.*.is_active'] = 'required|boolean';
        }
        if (isset($requestData['working_hours'])) {
            $validationRules['working_hours'] = 'required|array';
        }
        if (isset($requestData['working_hours.*.day'])) {
            $validationRules['working_hours.*.day'] = 'required|string';
        }
        if (isset($requestData['working_hours.*.is_open'])) {
            $validationRules['working_hours.*.is_open'] = 'required|boolean';
        }
        if (isset($requestData['working_hours.*.start_time'])) {
            $validationRules['working_hours.*.start_time'] = 'required|string';
        }
        if (isset($requestData['working_hours.*.end_time'])) {
            $validationRules['working_hours.*.end_time'] = 'required|string';
        }

        // Validate the request data
        $validator = Validator::make($requestData, $validationRules);

        // Check if validation fails
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


        try {
            // Find the Place model by ID
            $place = Place::findOrFail($id);

            // Update the Place model with the provided data
            $place->update($request->only([
                'name_ar', 'name_en', 'desc_ar', 'desc_en', 'email', 'website',
                'phone', 'city_id', 'area_id', 'lat', 'lng',
                'address_details', 'services', 'social', 'pending', 'logo', 'images'
            ]));

            // Update or create related playgrounds
            if ($request->has('playgrounds')) {
                $playgroundsData = $request->input('playgrounds');
                foreach ($playgroundsData as $playgroundData) {
                    $playground = Playground::find($playgroundData['id']);
                    if ($playground) {
                        $playground->update($playgroundData);
                    } else {
                        $place->playgrounds()->create($playgroundData);
                    }
                }
            }

            // Update or create related working hours
            if ($request->has('working_hours')) {


                // Update each working hour
                foreach ($request->input('working_hours') as $workingHourData) {
                    $workingHour = WorkingHour::findOrFail($workingHourData['id']);

                    $workingHour->update([
                        'is_open' => $workingHourData['is_open'],
                        'start_time' => $workingHourData['is_open']? $workingHourData['start_time']=="null" ? null : $workingHourData['start_time']:null,
                        'end_time' => $workingHourData['is_open'] ?$workingHourData['end_time']==="null" ? null : $workingHourData['end_time']:null,
                    ]);

                }

            }
            // Return a success response
            return response()->json([
                'status' => 200,
                'msg' => 'Place updated successfully',
                'data' =>null
            ]);
        } catch (\Exception $e) {
            // Return error response if model not found or any other exception occurs
            return response()->json([
                'status' => 401,
                'msg' =>  $e->getMessage(),
                'data' =>null
            ]);
        }
    }
    public function storePlayground(Request $request)
    {

        // Validate the request data
        $validator = Validator::make($request->all(), [

            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'classification' => 'required|exists:place_settings,id',
            'player' => 'required|exists:place_settings,id',
            'images' => 'required|array',
            'images.*' => 'required|exists:media,id',
            'price_per_60' => 'required|numeric',
            'price_per_90' => 'required|numeric',
            'price_per_120' => 'required|numeric',
            'price_per_180' => 'required|numeric',
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


        $providerId = Auth::id();

        try {
            // Create a new playground
            $playground = new Playground();
            $playground->name_ar = $request->input('name_ar');
            $playground->name_en = $request->input('name_en');
            $playground->classification = $request->input('classification');
            $playground->player = $request->input('player');
            $playground->price_per_60 = $request->input('price_per_60');
            $playground->price_per_90 = $request->input('price_per_90');
            $playground->price_per_120 = $request->input('price_per_120');
            $playground->price_per_180 = $request->input('price_per_180');

            $playground->images = $request->input('images');

            $providerPlace=Place::where('provider_id',$providerId)->first();

            // Set other fields here

            // Get the authenticated user's places and check if the provided place_id belongs to the user
            if (!$providerPlace) {
                return response()->json([
                    'status' => 403,
                    'msg' => 'you do not have place',
                    'data' =>null
                ]);
            }

            // Associate the playground with the place
            $playground->place_id = $providerPlace->id;

            // Save the playground
            $playground->save();

            // Return a success response
            return response()->json([
                'status' => 200,
                'msg' => 'Playground created successfully',
                'data' =>null
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'status' => 401,
                'msg' => $e->getMessage(),
                'data' =>null
            ]);
        }
    }

    public function providerPlaces(Request $request)
    {
        // Assuming the authenticated user is the provider
        $providerId = auth()->id();

        // Fetch places for the provider
        $place = Place::where('provider_id', $providerId)
            ->with('playgrounds', 'workingHours')
            ->get()->first();
        if($place){

            $imagesPlace = array_map(function ($image) {
                if ($image) {
                    $media = Media::find($image);
                    $filePath = "storage/$image/$media->file_name";
                    return  asset("{$filePath}");
                }
                return [];
            },  $place->images);


            $place["imagesUrl"]=$imagesPlace;

            $media = Media::find( $place->logo);
            $filePath = "storage/$place->logo/$media->file_name";
            $place["logoUrl"]=  asset("{$filePath}");

            $playgrounds = $place->playgrounds;


            if($playgrounds){
                foreach ($playgrounds as $playground) {
                    $images = array_map(function ($image) {
                        if ($image) {
                            $media = Media::find($image);
                            $filePath = "storage/$image/$media->file_name";
                            return asset($filePath);
                        }
                        return [];
                    }, $playground->images);
                    $playground["imagesUrl"]=$images;


                }
            }}

        // Return response using PlaceResource
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>$place
        ]);
    }

    public function index()
    {
        $places  = Place::get();
        return view('places', compact('places'));
    }


    public function show($id)
    {
        $place = Place::findOrFail($id);
        return view('places', compact('place'));
    }

}
