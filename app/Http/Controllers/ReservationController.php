<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationDetailsResource;
use App\Http\Resources\ReservationResource;
use App\Models\Notification;
use App\Models\Place;
use App\Models\Player;
use App\Models\Playground;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'playground_id' => 'required|exists:playgrounds,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
            'match_time' => 'required|numeric',
            'type' => 'required|in:special,competitive,friendly',
            'coupon' => 'nullable|string',
            'payment_type' => 'required|in:all,part',
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

        $fees=1;

        // Check for existing reservations
        $existingReservation = Reservation::where('playground_id', $request->input('playground_id'))
            ->where('reservation_date',$request->input('reservation_date'))
            ->where('reservation_time', $request->input('reservation_time'))
            ->first();

        if ($existingReservation) {
            // Return response using PlaceResource
            return response()->json([
                'status' => 400,
                'msg' => 'A reservation already exists for the specified time.',
                'data' =>null
            ]);

        }
        $playground = Playground::findOrFail($request->input('playground_id'));
        $priceField = "price_per_{$request->input('match_time')}";

        // Calculate grand total based on selected match time
        $totalPrice = $playground->$priceField;

        $paidAmount=0.0;
        $discountId=10;
        $discount=0.0;
        $priceOnePlayer= $totalPrice/4 + ($fees/4);
        if($request->input('coupon') === 'DISCOUNT10'){
            $discount= ($totalPrice*$discountId/100);
            $priceOnePlayer= $priceOnePlayer- ($priceOnePlayer*$discountId/100);


        }


        if ($request->input('type') === 'special') {
            if ($request->input('payment_type') === 'part') {
                $paidAmount = ($totalPrice-$discount )/ 4;
                $paidAmount = $paidAmount + ($fees/4);
            }
            else if ($request->input('payment_type') === 'all') {
                $paidAmount = $totalPrice-$discount;
                $paidAmount = $paidAmount + $fees;
            }
        }
        else if ($request->input('type') === 'competitive' || $request->input('type') === 'friendly') {
            $paidAmount = ($totalPrice-$discount )/ 4;
            $paidAmount = $paidAmount + ($fees/4);
            // Get the players data from the request
            $players = $request->input('players');

            // Check the length of players
            if (count($players) === 1) {

                $paidAmount=$paidAmount*2;
            }


        }


        $grandTotal=$totalPrice+$fees-$discount;




        // get user_id
        $user_id=1;
        $levelId=2;


        // Store reservation
        // Create the reservation
        $reservation = Reservation::create([
            'playground_id' => $request->input('playground_id'),
            'reservation_date' => $request->input('reservation_date'),
            'reservation_time' => $request->input('reservation_time'),
            'match_time' => $request->input('match_time'),
            'type' => $request->input('type'),
            'coupon' => $request->input('coupon'),
            'payment_type' => $request->input('payment_type'),
            'user_id' => $user_id,
            'grand_total' => $grandTotal,
            'paid_amount' => $paidAmount,
            'total_price' => $totalPrice,
            'discount' => $discount,
            'fees' => $fees,
            'status' => 'confirmed',
            'level_id' => $levelId,


            // Add other fields as needed
        ]);

        $playground=Playground::where('id',$request->input('playground_id'))->first();

        $player = new Player([
            'user_id' => $user_id,
            'group' => 'A',
            "amount"=> $priceOnePlayer,
            "payment"=> "paid"

        ]);
        // Associate the player with the reservation
        $reservation->players()->save($player);


        // Handle player creation if present in the request
        if ($request->has('players')) {
            foreach ($request->input('players') as $playerData) {
                // Create player associated with the reservation
                $player = new Player($playerData);
                $player->reservation_id = $reservation->id;
                $player->amount = $priceOnePlayer;

                if($request->input('payment_type')=='all'){
                    $player->payment = 'paid';

                }
                $player->save();
            }
        }
        $place=Place::where('id',$playground->place_id)->first();

        $notification = Notification::create([
            'title_ar' => 'حجز جديد',
            'title_en' =>'new reservation',
            'msg_ar' => 'لديك حجز جديد على ملعب:'.$playground->name_ar,
            'msg_en' => 'You have a new booking at playground:'.$playground->name_en,
            'user_id' => $place->provider_id,
            'reservation_id' => $reservation->id,
            'type' => 'provider',
        ]);

        // Return response using PlaceResource
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>$reservation
        ]);
    }

    public function getProviderReservations(Request $request)
    {
        // Retrieve the logged-in provider's ID
        $providerId = Auth::id();
        $language = $request->header('lang', 'en');
        $type = $request->input('type');

        $place = Place::where('provider_id', $providerId)->orderBy('id', 'asc')->first();
        $playgrounds = $place->playgrounds;
        $playgroundIds = $playgrounds->pluck('id');



        // Fetch reservations related to playgrounds associated with places owned by the provider
        $reservations = Reservation::whereHas('playground.place', function ($query) use ( $type) {

            if ($type === 'pending') {
                $query->where('reservations.status', 'confirmed')
                    ->whereRaw('reservations.paid_amount != reservations.grand_total')
                    ->whereDate('reservations.reservation_date', '>=', now()->toDateString());

            } elseif ($type === 'confirmed') {
                $query->where('reservations.status', 'confirmed')
                    ->whereRaw('reservations.paid_amount = reservations.grand_total')
                    ->whereDate('reservations.reservation_date', '>=', now()->toDateString());
            } elseif ($type === 'finished') {
                $query->where('reservations.status', '!=', 'confirmed')
                    ->orwhere('reservations.reservation_date', '<', now()->toDateString());



            }
        })->orderBy('reservations.reservation_date');

        $reservations = $reservations->whereIn('playground_id', $playgroundIds)->get();



        // Group reservations by formatted date
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

        // Return response with reservations data
        return response()->json([
            'status' => 200,
            'msg' => 'Reservations fetched successfully.',
            'data' => $response
        ]);
    }

    public function show($id)
    {
        try {

            // Retrieve the reservation based on the provided ID and the user ID
            $reservation = Reservation::where('id', $id)
                ->first();

            // Return the reservation data
            return response()->json([
                'status' => 200,
                'message' => 'Reservation details retrieved successfully',
                'data' => new ReservationDetailsResource($reservation),
            ]);
        } catch (ModelNotFoundException $exception) {
            // Handle not found exception
            return response()->json([
                'status' => 404,
                'message' => 'Reservation not found',
                'data' => null,
            ]);
        } catch (\Exception $exception) {
            // Handle other exceptions
            return response()->json([
                'status' => 500,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }
    public function updateReservation(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:cancel,paid,refund',
            'reason_id' => 'required_if:status,cancel,refund',
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


        // Find the reservation by ID
        $reservation = Reservation::findOrFail($id);

        // Check if the requested status is valid for cancelation
        if ($request->status === 'cancel' || $request->status === 'refund') {
            // Check if the reason ID is provided for cancelation or refund

            // Update the reservation with the provided status and reason ID
            $reservation->update([
                'status' => $request->status==='cancel' ? 'cancelled' : 'refunded',
                'reason_id' => $request->reason_id ?? null, // If reason_id is not provided, set it to null
            ]);

        } else if ($request->status === 'paid') {

            // Update the reservation with the provided status and reason ID
            $reservation->update([
                'paid_amount' => $reservation->grand_total, // If reason_id is not provided, set it to null
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Reservation status updated successfully',
            'data' => null,
        ]);
    }
    public function getProviderStats()
    {
        $providerId = Auth::id();
        $place = Place::where('provider_id', $providerId)->orderBy('id', 'asc')->first();


        $playgrounds = $place->playgrounds;

        $playgroundIds = $playgrounds->pluck('id');


        // Fetch reservations for these playgrounds
        $reservations = Reservation::whereIn('playground_id', $playgroundIds)->get();





//
//        // Get the number of distinct clients who made reservations
        $numDistinctClients = $reservations->groupBy('user_id')->count();
//
//        // Get the total profit
        $totalProfit = $reservations->sum('paid_amount');


        // Group reservations by day of the week and calculate total profit for each group
        foreach ($reservations as $reservation) {
            // Calculate profit for the reservation (replace this with your actual profit calculation logic)
            $profit = $reservation->grand_total - $reservation->fees;

            // Get the day of the week and name of the day
            $date = Carbon::parse($reservation->reservation_date);
            $dayOfWeek = $date->dayOfWeek;
            $dayName = $date->englishDayOfWeek; // or use ->format('l') for full day name

            // Add profit and day name to the corresponding day of the week in the profitByDayOfWeek array
            if (!isset($profitByDayOfWeek[$dayOfWeek])) {
                $profitByDayOfWeek[$dayOfWeek] = [
                    'day_name' => $dayName,
                    'profit' => $profit,
                ];
            } else {
                $profitByDayOfWeek[$dayOfWeek]['profit'] += $profit;
            }
        }

        // Fill in missing days with profit 0
        for ($i = 1; $i <= 7; $i++) {
            if (!isset($profitByDayOfWeek[$i])) {
                $date = Carbon::now()->startOfWeek()->addDays($i - 1);
                $dayName = $date->englishDayOfWeek; // or use ->format('l') for full day name
                $profitByDayOfWeek[$i] = [
                    'day_name' => $dayName,
                    'profit' => 0,
                ];
            }
        }

        // Sort the array by day of the week
        ksort($profitByDayOfWeek);

        return response()->json([
            'status' => 200,
            'message' => null,
            'data' => [
                'num_reservations' => $reservations->count(),
                'num_playgrounds' => $playgrounds->count(),
                'num_distinct_clients' => $numDistinctClients,
                'total_profit' => $totalProfit,
                'profitByDayOfWeek'=>array_values($profitByDayOfWeek)

            ],
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
