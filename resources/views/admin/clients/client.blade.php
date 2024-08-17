@extends('layouts.master')
@section('title')
    @lang('messages.Client_menu')
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
                                <h5 class="card-title mb-0">@lang('messages.clients')</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-secondary add-btnt" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                    <i class="ri-add-line align-bottom me-1"></i>@lang('messages.add_client')
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
                                    <input type="text" class="form-control search" placeholder="@lang('messages.seearch')">
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

                                    <th class="sort" data-sort="first_name" onclick="sortByColumn('first_name')">@lang('messages.first_name')</th>
                                    <th class="sort" data-sort="last_name" onclick="sortByColumn('last_name')">@lang('messages.last_name')</th>
                                    <th class="sort" data-sort="phone" onclick="sortByColumn('phone')">@lang('messages.phone')</th>
                                    <th class="sort" data-sort="sport_type" onclick="sortByColumn('sport_type')">@lang('messages.sport_type')</th>
                                    <th class="sort" data-sort="gender" onclick="sortByColumn('gender')">@lang('messages.gender')</th>
                                    <th class="sort" data-sort="level" onclick="sortByColumn('level')">@lang('messages.level')</th>
                                    <th class="sort" data-sort="participants" onclick="sortByColumn('participants')">@lang('messages.creation_date')</th>

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
                                        @lang('messages.search_message', ['total' => $clients->total()])
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
        <!-- Modal -->
        <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel">@lang('messages.add_new_client')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.clients.store') }}" method="POST">
                            {{csrf_field()}}


                            <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <div class="col-6">
                                    <label for="first_name" class="form-label">@lang('messages.first_name')</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-6">
                                    <label for="last_name" class="form-label"> @lang('messages.last_name')</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <div class="col-6">
                                    <label for="phone" class="form-label">@lang('messages.phone')</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="col-6">
                                    <label for="sport_type" class="form-label">@lang('messages.sport_type')</label>
                                    <select class="form-select" id="sport_type" name="sport_type" >
                                        <option value="" disabled selected>@lang('messages.choose_sport_type')</option>
                                        <option value="Tennis">@lang('messages.tennis')</option>
                                        <option value="Padel">@lang('messages.padel')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <div class="col-6">
                                    <label for="gender" class="form-label">@lang('messages.gender')</label>
                                    <select class="form-select" id="gender" name="gender" >
                                        <option value="" disabled selected>@lang('messages.choose_gender')</option>
                                        <option value="male">@lang('messages.male')</option>
                                        <option value="female">@lang('messages.female')</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="level" class="form-label">@lang('messages.level')</label>
                                    <select class="form-select" id="level" name="level" >
                                        <option value="" disabled selected>@lang('messages.choose_level')</option>
                                        <option value="Junior">@lang('messages.junior')</option>
                                        <option value="Middle">@lang('messages.middle')</option>
                                        <option value="Advanced">@lang('messages.advanced')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                                <div class="col-6">
                                    <label for="age" class="form-label">@lang('messages.age')</label>
                                    <select class="form-select" id="age" name="age" >
                                        <option value="" disabled selected>@lang('messages.choose_age')</option>
                                        <option value="18-30">@lang('messages.age_18_30')</option>
                                        <option value="30-40">@lang('messages.age_30_40')</option>
                                        <option value="40-50">@lang('messages.age_40_50')</option>
                                        <option value="50+">@lang('messages.age_50_plus')</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="is_active" class="form-label">@lang('messages.status')</label>
                                    <select class="form-select" id="is_active" name="is_active" >
                                        <option value="" disabled selected>@lang('messages.choose_status')</option>
                                        <option value="1">@lang('messages.active')</option>
                                        <option value="0">@lang('messages.inactive')</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <!-- Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">@lang('messages.add_new_client')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.clients.store') }}" method="POST">
                         @csrf


                        <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                            <div class="col-6">
                                <label for="first_name" class="form-label">@lang('messages.first_name')</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-6">
                                <label for="last_name" class="form-label"> @lang('messages.last_name')</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>

                        <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                            <div class="col-6">
                                <label for="phone" class="form-label">@lang('messages.phone')</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-6">
                                <label for="sport_type" class="form-label">@lang('messages.sport_type')</label>
                                <select class="form-select" id="sport_type" name="sport_type" required>
                                    <option value="" disabled selected>@lang('messages.choose_sport_type')</option>
                                    <option value="Tennis">@lang('messages.tennis')</option>
                                    <option value="Padel">@lang('messages.padel')</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                            <div class="col-6">
                                <label for="gender" class="form-label">@lang('messages.gender')</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="" disabled selected>@lang('messages.choose_gender')</option>
                                    <option value="male">@lang('messages.male')</option>
                                    <option value="female">@lang('messages.female')</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="level" class="form-label">@lang('messages.level')</label>
                                <select class="form-select" id="level" name="level" required>
                                    <option value="" disabled selected>@lang('messages.choose_level')</option>
                                    <option value="Junior">@lang('messages.junior')</option>
                                    <option value="Middle">@lang('messages.middle')</option>
                                    <option value="Advanced">@lang('messages.advanced')</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3" style="font-family: 'Tajawal', sans-serif;">
                            <div class="col-6">
                                <label for="age" class="form-label">@lang('messages.age')</label>
                                <select class="form-select" id="age" name="age" required>
                                    <option value="" disabled selected>@lang('messages.choose_age')</option>
                                    <option value="18-30">@lang('messages.age_18_30')</option>
                                    <option value="30-40">@lang('messages.age_30_40')</option>
                                    <option value="40-50">@lang('messages.age_40_50')</option>
                                    <option value="50+">@lang('messages.age_50_plus')</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="is_active" class="form-label">@lang('messages.status')</label>
                                <select class="form-select" id="is_active" name="is_active" required>
                                    <option value="" disabled selected>@lang('messages.choose_status')</option>
                                    <option value="1">@lang('messages.active')</option>
                                    <option value="0">@lang('messages.inactive')</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

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

    <script src="{{ URL::asset('build/libs/multi.js/multi.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/js/admin/client.js') }}"></script>

    <script>
        window.languageSettings = {
            locale: "{{ app()->getLocale() }}",
            messages: @json(__('messages'))
        };
    </script>


@endsection
