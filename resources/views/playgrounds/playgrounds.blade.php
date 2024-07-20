@extends('layouts.master')
@section('title')
    @lang('messages.Playground_menu')
@endsection
@section('content')
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 text-center">@lang('messages.Playground_menu')</h4>
                </div>
                <div class="card-header align-items-center d-flex">
                    <h3 class="card-title mb-0 flex-grow-1 text-left">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addPlaygroundModal">
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
                                    <th scope="col">@lang('messages.price_per_90')</th>
                                    <th scope="col">@lang('messages.price_per_120')</th>
                                    <th scope="col">@lang('messages.price_per_180')</th>
                                    <th scope="col">@lang('messages.is_active')</th>
                                    <th scope="col">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($playgrounds as $playground)
                                    <tr>
                                        <td>{{ $playground->id }}</td>
                                        <td>{{ $playground->name_ar }}</td>
                                        <td>{{ $playground->name_en }}</td>
                                        <td>{{ $playground->image }}</td>
                                        <td>{{ $playground->classification }}</td>
                                        <td>{{ $playground->player }}</td>
                                        <td>{{ $playground->price_per_60 }}</td>
                                        <td>{{ $playground->price_per_90 }}</td>
                                        <td>{{ $playground->price_per_120 }}</td>
                                        <td>{{ $playground->price_per_180 }}</td>
                                        <td>{{ $playground->is_active ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('admin.playgrounds.edit', $playground->id) }}"
                                               class="btn btn-primary">@lang('messages.edit')</a>
                                            <a href="{{ route('admin.playgrounds.reservations', $playground->id) }}"
                                               class="btn btn-info">@lang('messages.reservations')</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addPlaygroundModal" tabindex="-1" aria-labelledby="addPlaygroundModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title arabic-font" id="addPlaygroundModalLabel">@lang('messages.add_playground')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.playgrounds.store') }}" method="POST" id="addPlaygroundForm">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="place_id" class="form-label english-font">@lang('messages.place_id')</label>
                                            <select class="form-control english-font @error('place_id') is-invalid @enderror" id="place_id" name="place_id">
                                                <option value="" disabled selected></option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->id }}">
                                                        {{ $place->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('place_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="name_ar" class="form-label english-font">@lang('messages.name_ar')</label>
                                            <input type="text" class="form-control english-font @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="" required>
                                            @error('name_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="name_en" class="form-label english-font">@lang('messages.name_en')</label>
                                            <input type="text" class="form-control english-font @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="" required>
                                            @error('name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="classification" class="form-label english-font">@lang('messages.classification')</label>
                                            <input type="text" class="form-control english-font @error('classification') is-invalid @enderror" id="classification" name="classification" value="">
                                            @error('classification')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="player" class="form-label english-font">@lang('messages.player')</label>
                                            <input type="text" class="form-control english-font @error('player') is-invalid @enderror" id="player" name="player" value="">
                                            @error('player')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="images" class="form-label english-font">@lang('messages.image')</label>
                                            <input type="text" class="form-control english-font @error('images') is-invalid @enderror" id="images" name="images" value="">
                                            @error('images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="price_per_60" class="form-label english-font">@lang('messages.price_per_60')</label>
                                            <input type="text" class="form-control english-font @error('price_per_60') is-invalid @enderror" id="price_per_60" name="price_per_60" value="">
                                            @error('price_per_60')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="price_per_90" class="form-label english-font">@lang('messages.price_per_90')</label>
                                            <input type="text" class="form-control english-font @error('price_per_90') is-invalid @enderror" id="price_per_90" name="price_per_90" value="">
                                            @error('price_per_90')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="price_per_120" class="form-label english-font">@lang('messages.price_per_120')</label>
                                            <input type="text" class="form-control english-font @error('price_per_120') is-invalid @enderror" id="price_per_120" name="price_per_120" value="">
                                            @error('price_per_120')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="price_per_180" class="form-label english-font">@lang('messages.price_per_180')</label>
                                            <input type="text" class="form-control english-font @error('price_per_180') is-invalid @enderror" id="price_per_180" name="price_per_180" value="">
                                            @error('price_per_180')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="is_active" class="form-label english-font">@lang('messages.is_active')</label>
                                            <input type="checkbox" id="is_active" name="is_active" >
                                        </div>

                                        <button type="submit" class="btn btn-primary english-font">@lang('messages.save')</button>
                                    </div>
                                </form>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
