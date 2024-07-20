@extends('layouts.master')
@section('title')
@lang('translation.customers')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet "type="text/css" />

@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">

                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">الملاعب</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                            <button type="button" class="btn btn-success add-btnt" onclick="window.location.href='/playgrounds/create'">
                                <i class="ri-add-line align-bottom me-1"></i> اضافة ملعب جديد
                            </button>

                            {{--                            <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i>--}}
{{--                                Import</button>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom-dashed border-bottom">
                <form>
                    <div class="row g-3">
                        <div class="col-xl-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="البحث عن ملعب، بالاسم عربي او بالاسم انجليزي ،أو شيء ما...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xl-6">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="">
                                        <input type="text" class="form-control flatpickr-input" id="datepicker-range" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="آختر التاريخ" readonly="readonly">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-sm-4">
                                    <div>
                                        <select class="form-control" data-plugin="choices" data-choices data-choices-search-false id="idStatus">
                                            <option value="">الحالة</option>
                                            <option value="all" selected>الكل</option>
                                            <option value="1">نشط</option>
                                            <option value="0">غير نشط</option>
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-sm-4">
                                    <div>
                                        <button type="button" class="btn btn-primary w-100" onclick="performSearch();"> <i class="ri-equalizer-fill me-2 align-bottom"></i>تصفية</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>

                                    <th class="sort" data-sort="name">اللوجو</th>
                                    <th class="sort" data-sort="name_ar" onclick="sortByColumn('name_ar')">الاسم عربي </th>
                                    <th class="sort" data-sort="name_en" onclick="sortByColumn('name_en')">الاسم انجليزي</th>
                                    <th class="sort" data-sort="classification" onclick="sortByColumn('classification')">التصنيف </th>
                                    <th class="sort" data-sort="player" onclick="sortByColumn('player')"> نوع الملعب</th>
                                    <th class="sort" data-sort="price" onclick="sortByColumn('price')"> السعر</th>
                                    <th class="sort" data-sort="participants" onclick="sortByColumn('participants')"> تاريخ الانشاء</th>

                                    <th class="sort" data-sort="status">الحالة</th>
                                    <th class="sort" data-sort="action">اجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all" id="tableBody">

                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">عذرا! لم يتم العثور على أي نتائج</h5>
                                <p class="text-muted mb-0">لقد قمنا بالبحث في أكثر من  {{$playgrounds->total()}}  ملعب، ولم نجد أي ملاعب يتناسبون مع بحثك.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                السابق
                            </a>
                            <ul class="pagination listjs-pagination mb-0">5</ul>
                            <a class="page-item pagination-next" href="#">
                                التالي
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>

<!--ecommerce-customer init js -->
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Include Choices JavaScript (latest) -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<!-- Or versioned -->
<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>

<script src="{{ URL::asset('build/js/admin/playgrounds.js') }}"></script>
<script src="{{ URL::asset('build/libs/multi.js/multi.min.js') }}"></script>

<script>
    window.languageSettings = {
        locale: "{{ app()->getLocale() }}",
        messages: @json(__('messages'))
    };
</script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>


@endsection
