@extends('layouts.master')
@section('title')
    @lang('messages.Playground_menu')
@endsection
@section('content')

    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title arabic-font" id="addPlaygroundModalLabel">@lang('messages.edit_playground')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.playgrounds.update', $playground->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="hidden" name="id" value="{{ $playground->id }}">
                                    <label for="place_id" class="form-label english-font">@lang('messages.place_id')</label>
                                    <select class="form-control english-font @error('place_id') is-invalid @enderror" id="place_id" name="place_id" required>
                                        <option value="" disabled selected>اختر مكان</option>
                                        @foreach ($places as $place)
                                            <option value="{{ $place->id }}" {{ old('id', $playground->id) == $place->id }}>
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
                                    <input type="text" class="form-control english-font @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $playground->name_ar) }}" required>
                                    @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label for="name_en" class="form-label english-font">@lang('messages.name_en')</label>
                                    <input type="text" class="form-control english-font @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $playground->name_en) }}" required>
                                    @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label for="classification" class="form-label english-font">@lang('messages.classification')</label>
                                    <select class="form-control english-font @error('classification') is-invalid @enderror" id="classification" name="classification">
                                        <option value="" disabled selected>اختر التصنيف</option>
                                        @foreach ($classifications as $classification)
                                            <option value="{{ $classification->id }}" {{ old('classification', $playground->classification) == $classification->id ? 'selected' : '' }}>
                                                {{ $classification->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('classification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label for="player" class="form-label english-font">@lang('messages.player')</label>
                                    <input type="text" class="form-control english-font @error('player') is-invalid @enderror" id="player" name="player" value="{{ old('player', $playground->player) }}" required>
                                    @error('player')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="col-md-6">
                                    <label for="images" class="form-label english-font">@lang('messages.image')</label>
                                    <input type="file" class="form-control english-font @error('images') is-invalid @enderror" id="images" name="images">
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price_per_60" class="form-label english-font">@lang('messages.price_per_60')</label>
                                    <input type="number" class="form-control english-font @error('price_per_60') is-invalid @enderror" id="price_per_60" name="price_per_60" value="{{ old('price_per_60', $playground->price_per_60) }}" step="0.01">
                                    @error('price_per_60')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price_per_90" class="form-label english-font">@lang('messages.price_per_90')</label>
                                    <input type="number" class="form-control english-font @error('price_per_90') is-invalid @enderror" id="price_per_90" name="price_per_90" value="{{ old('price_per_90', $playground->price_per_90) }}" step="0.01">
                                    @error('price_per_90')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price_per_120" class="form-label english-font">@lang('messages.price_per_120')</label>
                                    <input type="number" class="form-control english-font @error('price_per_120') is-invalid @enderror" id="price_per_120" name="price_per_120" value="{{ old('price_per_120', $playground->price_per_120) }}" step="0.01">
                                    @error('price_per_120')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price_per_180" class="form-label english-font">@lang('messages.price_per_180')</label>
                                    <input type="number" class="form-control english-font @error('price_per_180') is-invalid @enderror" id="price_per_180" name="price_per_180" value="{{ old('price_per_180', $playground->price_per_180) }}" step="0.01">
                                    @error('price_per_180')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                    <div class="col-md-6">
                                        <label for="is_active" class="form-label english-font">@lang('messages.is_active')</label>
                                        <input type="checkbox" id="is_active" name="is_active" {{ old('is_active', $playground->is_active) ? 'checked' : '' }}>
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-primary english-font">@lang('messages.save')</button>
                </form>


            </div>
        </div>
    </div>

        </div>
    </div>

@endsection
