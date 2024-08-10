@extends('layouts.master')
@section('title')
    @lang('messages.edit_playground')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <form action="" id="edit-playground-form" autocomplete="off" class="needs-validation">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">
                                @lang('messages.field_label_ar')
                            </label>
                            <input type="hidden" class="form-control" id="formAction" name="formAction">
                            <input type="hidden" class="form-control" id="product-id-input" value="{{ $playground->id }}">
                            <input type="text" class="form-control" value="{{ $playground->name_ar }}" id="product-title-input" placeholder="@lang('messages.enter_field_name')" required>
                            <div class="invalid-feedback" >@lang('messages.enter_field_name_ar')</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="product-title-input-en">
                                @lang('messages.field_label_en')
                            </label>
                            <input type="text" class="form-control" id="product-title-input-en" value="{{ $playground->name_en }}" placeholder="@lang('messages.enter_field_name')" required>
                            <div class="invalid-feedback">@lang('messages.enter_field_name_en')</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('messages.event_image')</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="fs-14 mb-1">@lang('messages.event_image')</h5>
                            <p class="text-muted">@lang('messages.edit_add_image')</p>
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute top-100 start-100 translate-middle">
                                        <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" id="product-image-input" type="file" accept="image/png, image/gif, image/jpeg" multiple>
                                    </div>
                                </div>
                                <div id="image-preview-container" class="d-flex flex-wrap mt-3">
                                    @if (isset( $playground->images) && count( $playground->images) > 0)
                                        @foreach ( $playground->images as $imageUrl)
                                            <img src="{{ $imageUrl }}" class="img-thumbnail" style="max-width: 100px; margin: 5px;">
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">@lang('messages.save')</button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('messages.general_information')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price60-input">@lang('messages.price_per_60_minutes')</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text">@lang('messages.currency')</span>
                                        <input type="text" class="form-control" id="product-price60-input" value="{{ $playground->price_per_60 }}" placeholder="@lang('messages.enter_price')" required>
                                        <div class="invalid-feedback">@lang('messages.please_enter_price')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price90-input">@lang('messages.price_per_90_minutes')</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text">@lang('messages.currency')</span>
                                        <input type="text" class="form-control" id="product-price90-input" value="{{ $playground->price_per_90 }}" placeholder="@lang('messages.enter_price')" required>
                                        <div class="invalid-feedback">@lang('messages.please_enter_price')</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price120-input">@lang('messages.price_per_120_minutes')</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text">@lang('messages.currency')</span>
                                        <input type="text" class="form-control" id="product-price120-input" value="{{ $playground->price_per_120 }}" placeholder="@lang('messages.enter_price')" required>
                                        <div class="invalid-feedback">@lang('messages.please_enter_price')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price180-input">@lang('messages.price_per_180_minutes')</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text">@lang('messages.currency')</span>
                                        <input type="text" class="form-control" id="product-price180-input" value="{{ $playground->price_per_180 }}" placeholder="@lang('messages.enter_price')" required>
                                        <div class="invalid-feedback">@lang('messages.please_enter_price')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-visibility-input" class="form-label">@lang('messages.classification')</label>
                            <select class="form-select" id="choices-publish-visibility-input" data-choices data-choices-search-false>
                                @foreach($classification as $item)
                                    <option value="{{ $item->id }}" @if($playground->classification == $item->id) selected @endif>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $item->name_ar }}
                                        @else
                                            {{ $item->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="choices-players-visibility-input" class="form-label">@lang('messages.player_type')</label>
                            <select class="form-select" id="choices-players-visibility-input" data-choices data-choices-search-false>
                                @foreach($players as $item)
                                    <option value="{{ $item->id }}" @if($playground->player == $item->id) selected @endif>
                                        {{ app()->getLocale() == 'ar' ? $item->name_ar : $item->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">@lang('messages.status')</label>
                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                                <option value="0" @if(!$playground->is_active) selected @endif>@lang('messages.inactive')</option>
                                <option value="1" @if($playground->is_active) selected @endif>@lang('messages.active')</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('messages.service_provider')</h5>
                        <button type="button" class="btn btn-primary">@lang('messages.add_new')</button>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <label for="choices-publish-visibility-input" class="form-label">@lang('messages.select_service_provider')</label>
                            <select class="form-select" id="choices-places-visibility-input" data-choices data-choices-search-true>

                                @foreach($places as $item)
                                    <option value="{{ $item->id }}">
                                        @if(app()->getLocale() == 'ar')
                                            {{ $item->name_ar }}
                                        @else
                                            {{ $item->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- end card -->

                <!-- end card -->

                <!-- end card -->

            </div>
        </div>
        <!-- end row -->
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Or versioned -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>

    <script src="{{ URL::asset('build/js/admin/editPlayground.js') }}"></script>


    <script src="{{ URL::asset('/build/js/app.js') }}"></script>
@endsection
