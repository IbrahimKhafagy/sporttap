@extends('layouts.master')
@section('title')
    @lang('messages.Playground_menu')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1 text-center">@lang('messages.Playground_menu')</h4>
                    </div>
                    <div class="card-header align-items-center d-flex">
                        <h3 class="card-title mb-0 flex-grow-1 text-left">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlaygroundModal">
                                @lang('messages.add_playground')
                            </button>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">@lang('messages.ID')</th>
                                            <th scope="col">@lang('messages.name_ar')</th>
                                            <th scope="col">@lang('messages.name_en')</th>
                                            <th scope="col">@lang('messages.image')</th>
                                            <th scope="col">@lang('messages.classification')</th>
                                            <th scope="col">@lang('messages.player')</th>
                                            <th scope="col">@lang('messages.price_per_60')</th>
                                            <th scope="col">@lang('messages.is_active')</th>
                                            <th scope="col">@lang('messages.actions')</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                        @foreach($playgrounds as $playground)
                                            <tr>
                                                <td>{{ $playground->id }}</td>
                                                <td>{{ $playground->name_ar }}</td>
                                                <td>{{ $playground->name_en }}</td>
                                                <td>{{ $playground->image}}</td>
                                                <td>{{ $playground->classification }}</td>
                                                <td>{{ $playground->player }}</td>
                                                <td>{{ $playground->price_per_60 }}</td>
                                                <td>{{ $playground->is_active ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    <a href="/playgrounds/{{ $playground->id }}/edit" class="btn btn-primary">@lang('messages.edit')</a>
                                                    <form action="/playgrounds/{{ $playground->id }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">@lang('messages.delete')</button>
                                                    </form>
                                                    <a href="/playgrounds/{{ $playground->id }}/reservations" class="btn btn-info">@lang('reservations')</a>
                                                    {{-- <a href="/reservations?playground_id={{ $playground->id }}" class="btn btn-info">@lang('messages.view_reservations')</a> --}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addPlaygroundModal" tabindex="-1" aria-labelledby="addPlaygroundModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title arabic-font" id="addPlaygroundModalLabel">@lang('messages.add_playground')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form href="playgrounds" method="POST" id="addPlaygroundForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="place_id" class="form-label english-font">@lang('messages.place_id')</label>
                                    <input type="number" class="form-control english-font" id="place_id" name="place_id" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name_ar" class="form-label english-font">@lang('messages.name_ar')</label>
                                    <input type="text" class="form-control english-font" id="name_ar" name="name_ar" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name_en" class="form-label english-font">@lang('messages.name_en')</label>
                                    <input type="text" class="form-control english-font" id="name_en" name="name_en" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="classification" class="form-label english-font">@lang('messages.classification')</label>
                                    <input type="number" class="form-control english-font" id="classification" name="classification">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="player" class="form-label english-font">@lang('messages.player')</label>
                                    <input type="number" class="form-control english-font" id="player" name="player">
                                </div>
                                <div class="col-md-6">
                                    <label for="images" class="form-label english-font">@lang('messages.images')</label>
                                    <input type="text" class="form-control english-font" id="images" name="images">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="price_per_60" class="form-label english-font">@lang('messages.price_per_60')</label>
                                    <input type="number" class="form-control english-font" id="price_per_60" name="price_per_60">
                                </div>
                                <div class="col-md-6">
                                    <label for="is_active" class="form-label english-font">@lang('messages.is_active')</label>
                                    <input type="checkbox" id="is_active" name="is_active">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary english-font">@lang('messages.save')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
