@extends('layouts.app')


@extends('layouts.master')
@section('title')
    @lang('messages.Playground_menu')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container">
    <h1>الأماكن</h1>
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">@lang('messages.ID')</th>
                <th scope="col">@lang('messages.name_ar')</th>
                <th scope="col">@lang('messages.name_en')</th>
                <th scope="col">@lang('messages.image')</th>
                <th scope="col">@lang('messages.email')</th>
                <th scope="col">@lang('messages.phone')</th>
                <th scope="col">@lang('messages.status')</th>
                <th scope="col">@lang('messages.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($places as $place)
                <tr>
                    <td>{{ $place->id }}</td>
                    <td>{{ $place->name_ar }}</td>
                    <td>{{ $place->name_en }}</td>
                    <td>
                        @if($place->logoMedia)
                            <img src="{{ $place->logoMedia->url }}" alt="Logo" style="width:50px; height:auto;">
                        @else
                            <img src="/path/to/default/image.png" alt="No Logo" style="width:50px; height:auto;">
                        @endif
                    </td>
                    <td>{{ $place->email }}</td>
                    <td>{{ $place->phone }}</td>

                    <td>{{ $place->status }}</td>
                    <td>
                        <a href="/places'/{{ $place->id}}" class="btn btn-primary">@lang('messages.view')</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
