@extends('layouts.master')
@section('title')
    @lang('translation.create-product')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet "type="text/css" />

@endsection
@section('content')

    <form id="create-playground-form" autocomplete="off" class="needs-validation" >
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input"> اسم الملعب بالعربي</label>
                                <input type="hidden" class="form-control" id="formAction" name="formAction" >
                                <input type="text" class="form-control d-none" id="product-id-input">
                                <input type="text" class="form-control" id="product-title-input"  placeholder="ادخل اسم الملعب" required>
                                <div class="invalid-feedback">ادخل اسم الملعب بالعربي</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input"> اسم الملعب بالانجليزي</label>
                                <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                <input type="text" class="form-control d-none" id="product-id-input">
                                <input type="text" class="form-control" id="product-title-input-en"  placeholder="ادخل اسم الملعب" required>
                                <div class="invalid-feedback">ادخل اسم الملعب بالانجليزي</div>
                            </div>
                        </div>

                </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">صورة الفعالية</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="fs-14 mb-1">صورةة الفعالية</h5>
                            <p class="text-muted">اضف او عدل في صورة الفعالية</p>
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
                                <div id="image-preview-container" class="d-flex flex-wrap mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">حفظ</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">معلومات عامة</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price-input">سعر 60 دقيقة</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text" id="product-price-addon">ر.س</span>
                                        <input type="text" class="form-control"  id="product-price60-input" placeholder="ادخل السعر " aria-label="Price" aria-describedby="product-price-addon" required>
                                        <div class="invalid-feedback">من فضلك داخل السعر </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price-input">سعر 90 دقيقة</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text" id="product-price90-addon">ر.س</span>
                                        <input type="text" class="form-control"  id="product-price90-input" placeholder="ادخل السعر " aria-label="Price" aria-describedby="product-price-addon" required>
                                        <div class="invalid-feedback">من فضلك داخل السعر </div>
                                    </div>

                                </div>
                            </div>

                            <!-- end col -->
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price-input">سعر 120 دقيقة</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text" id="product-price-addon">ر.س</span>
                                        <input type="text" class="form-control"  id="product-price120-input" placeholder="ادخل السعر " aria-label="Price" aria-describedby="product-price-addon" required>
                                        <div class="invalid-feedback">من فضلك داخل السعر </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product-price-input">سعر 180 دقيقة</label>
                                    <div class="input-group has-validation mb-3">
                                        <span class="input-group-text" id="product-price-addon">ر.س</span>
                                        <input type="text" class="form-control"  id="product-price180-input" placeholder="ادخل السعر " aria-label="Price" aria-describedby="product-price-addon" required>
                                        <div class="invalid-feedback">من فضلك داخل السعر </div>
                                    </div>

                                </div>
                            </div>

                            <!-- end col -->
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-visibility-input" class="form-label">التصنيف</label>
                            <select class="form-select" id="choices-publish-visibility-input" data-choices data-choices-search-false>

                            @foreach($classification as $item)
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

                        <div class="mb-3">
                            <label for="choices-publish-visibility-input" class="form-label">نوع الملعب</label>
                            <select class="form-select" id="choices-players-visibility-input" data-choices data-choices-search-false>

                                @foreach($players as $item)
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

                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">الحالة</label>

                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                                <option value="1" >نشط</option>
                                <option value="0"  >غير نشط</option>
                            </select>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">مزود الخدمة ( اسم المكان )</h5>
                        <button type="button" class="btn btn-primary">اضافة جديد</button>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <label for="choices-publish-visibility-input" class="form-label">اختر مزود الخدمة</label>
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

    <script src="{{ URL::asset('build/js/admin/addPlayground.js') }}"></script>


    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
