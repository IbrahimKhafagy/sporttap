<!-- resources/views/reservations/index.blade.php -->

@extends('layouts.master')

@section('title')
    @lang('messages.reservations_for') {{ $playground->name_en }}
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('messages.reservations_for') {{ $playground->name_en }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">@lang('messages.reservation_id')</th>
                                <th scope="col">@lang('messages.user_id')</th>
                                <th scope="col">@lang('messages.reservation_date')</th>
                                <th scope="col">@lang('messages.reservation_time')</th>
                                <th scope="col">@lang('messages.match_time')</th>
                                <th scope="col">@lang('messages.type')</th>
                                <th scope="col">@lang('messages.total_price')</th>
                                <th scope="col">@lang('messages.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->user_id }}</td>
                                    <td>{{ $reservation->reservation_date }}</td>
                                    <td>{{ $reservation->reservation_time }}</td>
                                    <td>{{ $reservation->match_time }}</td>
                                    <td>{{ $reservation->type }}</td>
                                    <td>{{ $reservation->total_price }}</td>
                                    <td>{{ $reservation->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
