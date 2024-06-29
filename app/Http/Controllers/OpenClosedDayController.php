<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Provider;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OpenClosedDay;
use App\Models\Playground;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OpenClosedDayController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'dates' => 'required|array',
            'dates.*' => 'date_format:Y-m-d',
            'is_open' => 'required|boolean',
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

        // Get existing open/closed days for the playground
        $existingDays = OpenClosedDay::whereIn('date', $request->dates)
            ->where('playground_id',  $request->playground_id)
            ->get();

        // If is_open is false, insert new records for dates that don't exist
        if (!$request->is_open) {
            $existingDates = $existingDays->pluck('date')->toArray();
            $newDates = array_diff($request->dates, $existingDates);

            $newDays = [];
            foreach ($newDates as $date) {
                $newDays[] = [
                    'user_id' => Auth::id(),
                    'date' => $date,
                    'is_open' => $request->is_open,
                    'playground_id' =>  $request->playground_id,
                ];
            }
            OpenClosedDay::insert($newDays);
            return response()->json([
                'status' => 200,
                'message' => 'days closed successfully',
                'data' => null,
            ]);
        }

        // If is_open is true, delete existing records
        OpenClosedDay::whereIn('id', $existingDays->pluck('id'))->delete();
        return response()->json([
            'status' => 200,
            'message' => 'days opened successfully',
            'data' => null,
        ]);


    }

    public function index(Request $request)
    {
        $language = $request->header('lang', 'en');
        $playgroundId = $request->input('playground_id');
        $currentDate = Carbon::now()->toDateString();
        $user = Provider::find(Auth::id());
        $providerId = Auth::id();
        $playgrounds = Playground::whereHas('place', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })->get();
        $playgroundsUser = $playgrounds->pluck('id')->toArray();

        // Query closed days
        $closedDaysQuery = OpenClosedDay::where('date', '>=', $currentDate)
            ->where('is_open', false);

        $closedDaysQuery->where('user_id',$providerId);

        // Filter by playground ID if provided
        if ($playgroundId) {
            $closedDaysQuery->where('playground_id', $playgroundId);
        }

        $closedDays = $closedDaysQuery->pluck('date')->toArray();

        // Query reservations for the closed days
        $reservationsQuery = Reservation::whereIn('playground_id', $playgroundsUser)
           -> where('reservation_date', '>=', $currentDate);

        // Get the date from the request
        $date = $request->input('date');


        // Filter by playground ID if provided
        if ($playgroundId) {
            $reservationsQuery->whereHas('playground', function ($query) use ($playgroundId) {
                $query->where('playground_id', $playgroundId);
            });
        }
        $reservationDates = $reservationsQuery->distinct()->pluck('reservation_date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        });

        if($date){
            $reservationsQuery->whereDate('reservation_date', $date);
        }


        $reservations = $reservationsQuery->get();

        $groupedReservations = [];
        foreach ($reservations as $reservation) {
            $date = Carbon::parse($reservation->reservation_date)->locale($language);

            // Format the date as required based on the language
            $formattedDate = $this->getFormattedDate($date, $language);

            // Add reservation to the corresponding group
            $groupedReservations[$formattedDate][] = new ReservationResource($reservation);

        }
        // Prepare the final response
        $response = [];
        foreach ($groupedReservations as $date => $reservations) {
            $response[] = [
                'date' => $date,
                'reservations' => $reservations
            ];
        }
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>[
                'closed_days' => $closedDays,
                'reservation_days'=>$reservationDates,
                'reservations' => $response
            ]
        ]);

    }
    private function getFormattedDate($date, $language)
    {
        $today = Carbon::today()->locale($language);
        if ($date->isSameDay($today)) {
            return $language === 'ar' ? 'اليوم' : 'Today';
        }
        return $date->locale($language)->isoFormat('dddd, Do MMMM');
    }

}
