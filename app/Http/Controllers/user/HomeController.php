<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MatchResource;
use App\Http\Resources\PlaygroundUserResource;
use App\Http\Resources\SliderResource;
use App\Models\Place;
use App\Models\Playground;
use App\Models\Reservation;
use App\Models\Slider;
use Illuminate\Http\Request;
use Carbon\Carbon;


class HomeController extends Controller
{

    public function getHome(Request $request)
    {
        // Get active sliders
        $sliders = Slider::where('is_active', true)->get();

        // Get next matches from reservations table
        $nextMatches = Reservation::where(function ($query) {
            $query->where('type', 'competitive')
                ->orWhere('type', 'friendly');
        })
            ->where('status', 'confirmed')
            ->where('reservation_date', '>=', now()->toDateString())
            ->with(['players', 'playground'])
            ->withCount('players')
            ->take(6) // Limit the number of results to 6
            ->get();

// Filter the reservations based on players_count
        $nextMatches = $nextMatches->filter(function ($reservation) {
            return $reservation->players_count < 4;
        });

        $formattedMatches = MatchResource::collection($nextMatches);

        $lat = $request->input("lat")? $request->input("lat") : 21.422510;
        $lng =  $request->input("lng")? $request->input("lng") : 39.826168;

        $nearestPlaygrounds = Place::with('playgrounds')
            ->selectRaw("
       *,
        (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance
    ", [$lat, $lng, $lat])
            ->orderBy('distance')
            ->take(10)
            ->get();
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' => [
                'sliders' => SliderResource::collection($sliders),
                'next_matches' => $formattedMatches,
                'nearest_playgrounds'=> PlaygroundUserResource::collection($nearestPlaygrounds)
            ]]);


    }
}
