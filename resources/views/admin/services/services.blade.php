@extends('layouts.master')
@section('title')
    @lang('messages.service')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" >

@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">@lang('messages.service')</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-secondary add-btnt" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                    <i class="ri-add-line align-bottom me-1"></i>@lang('messages.add_service')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom-dashed border-bottom">
                    <form>
                        <div class="row g-3">
                            <div class="col-xl-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="@lang('messages.seeaarch')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-6">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <div class="">
                                            <input type="text" class="form-control flatpickr-input" id="datepicker-range" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="@lang('messages.date')" readonly="readonly">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-sm-4">
                                        <div>
                                            <select class="form-control" data-plugin="choices" data-choices data-choices-search-false id="idStatus">
                                                <option value="">@lang('messages.status')</option>
                                                <option value="all" selected>@lang('messages.all')</option>
                                                <option value="1">@lang('messages.active')</option>
                                                <option value="0">@lang('messages.inactive') </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-sm-4">
                                        <div>
                                            <button type="button" class="btn btn-primary w-100" onclick="performSearch();"> <i class="ri-equalizer-fill me-2 align-bottom"></i>@lang('messages.filtering')</button>
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
                                    <th class="sort" data-sort="logo">@lang('messages.logo')</th>
                                    <th class="sort" data-sort="name_ar" onclick="sortByColumn('name_ar')">@lang('messages.name_ar')</th>
                                    <th class="sort" data-sort="name_en" onclick="sortByColumn('name_en')">@lang('messages.name_en')</th>
                                    <th class="sort" data-sort="created_at" onclick="sortByColumn('created_at')">@lang('messages.creation_date')</th>
                                    <th class="sort" data-sort="status">@lang('messages.is_active')</th>
                                    <th class="sort" data-sort="action">@lang('messages.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all" id="tableBody">

                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('messages.no_results')</h5>
                                    <p class="text-muted mb-0">
                                        @lang('messages.search_message', ['total' => $service->total()])
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    @lang('messages.previous')
                                </a>
                                <ul class="pagination listjs-pagination mb-0">5</ul>
                                <a class="page-item pagination-next" href="#">
                                    @lang('messages.next')
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!--end col-->

        <!--start edit Service Modal-->
        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="font-family: 'Tajawal', sans-serif;">
                        <h5 class="modal-title" id="editServiceModalLabel">@lang('messages.update_services')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editServiceForm" action="{{ route('admin.services.update', 'id') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="serviceId" name="id">
                            <div class="mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <label for="name_ar" class="form-label">@lang('messages.name_ar')</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                            </div>
                            <div class="mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <label for="name_en" class="form-label">@lang('messages.name_en')</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" required>
                            </div>
                            <div class="mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <label for="media_id" class="form-label">@lang('messages.service_image')</label>
                                <input type="file" class="form-control" id="media_id" name="media_id" accept="image/*">
                            </div>

                            <div class="mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <label for="is_active" class="form-label">@lang('messages.status')</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1">@lang('messages.active')</option>
                                    <option value="0">@lang('messages.inactive')</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end edit Service Modal-->

        <!--start add Service Modal-->
        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addServiceModalLabel">@lang('messages.add_service')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin/services" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name_ar" class="form-label">@lang('messages.name_ar')</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                            </div>
                            <div class="mb-3">
                                <label for="name_en" class="form-label">@lang('messages.name_en')</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" required>
                            </div>
                            <div class="mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <label for="media_id" class="form-label">@lang('messages.service_image')</label>
                                <input type="file" class="form-control" id="media_id" name="image" accept="image/*">
                            </div>

                            <div class="mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <label for="is_active" class="form-label">@lang('messages.status')</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="" disabled selected>@lang('messages.choose_status')</option>
                                    <option value="1">@lang('messages.active')</option>
                                    <option value="0">@lang('messages.inactive')</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.cancel')</button>
                            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end add Service Modal-->
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
    <script src="{{ URL::asset('build/js/admin/services.js') }}"></script>
    <script src="{{ URL::asset('build/libs/multi.js/multi.min.js') }}"></script>

    <script>
        window.languageSettings = {
            locale: "{{ app()->getLocale() }}",
            messages: @json(__('messages'))
        };
    </script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editServiceModal = document.getElementById('editServiceModal');
            editServiceModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                // جلب البيانات من الـ<a>
                var serviceId = button.getAttribute('data-id');
                var nameAr = button.getAttribute('data-name_ar');
                var nameEn = button.getAttribute('data-name_en');
                var isActive = button.getAttribute('data-is_active');
                var mediaId = button.getAttribute('data-media_id');

                var modal = this;
                modal.querySelector('#serviceId').value = serviceId;
                modal.querySelector('#name_ar').value = nameAr;
                modal.querySelector('#name_en').value = nameEn;
                modal.querySelector('#is_active').value = isActive;
                modal.querySelector('#media_id').value = mediaId;
            });

            document.getElementById('editServiceForm').addEventListener('submit', function(e) {
                var form = this;
                var serviceId = document.getElementById('serviceId').value;
                form.action = form.action.replace('id', serviceId);
            });
        });
    </script>

@endsection

