@extends('layouts.master')
@section('title')
    @lang('messages.reservations')
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
                            <h5 class="card-title mb-0">@lang('messages.reservations')</h5>
                        </div>
                    </div>

                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button id="exportButton"  type="button" class="btn btn-info"><i class="ri-file-excel-2-line align-bottom me-1"></i>
                                @lang('messages.download_excel') </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom-dashed border-bottom">
                <form>
                    <div class="row g-3">
                        <div class="col-xl-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="@lang('messages.search_placeholder')">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div>
                                <select class="form-control" id="eventsWithTickets">
                                    <option value="">@lang('messages.select_playground') </option>
                                    @if (app()->getLocale() == 'ar')
                                        @foreach ($playgroundsWithReservations as $event)
                                            <option value="{{ $event->id }}">{{ $event->name_ar }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($playgroundsWithReservations as $event)
                                            <option value="{{ $event->id }}">{{ $event->name_en }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xl-5">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="">
                                        <input type="text" class="form-control flatpickr-input" id="datepicker-range" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder=" @lang('messages.date')" readonly="readonly">
                                    </div>
                                </div>


                                <!--end col-->
                                <div class="col-sm-4">
                                    <div>
                                        <select class="form-control" data-plugin="choices" data-choices data-choices-search-false id="idStatus">
                                            <option value="">@lang('messages.status')</option>
                                            <option value="all" selected>@lang('messages.all')</option>
                                            <option value="partial_payment">@lang('messages.partial_payment')</option>
                                            <option value="pending_payment">@lang('messages.pending_payment')</option>
                                            <option value="confirmed">@lang('messages.confirmed')</option>
                                            <option value="refunded">@lang('messages.refunded')</option>
                                            <option value="payment_failed">@lang('messages.payment_failed')</option>
                                            <option value="completed">@lang('messages.completed')</option>
                                            <option value="cancelled">@lang('messages.cancelled')</option>

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

                                    <th class="sort" data-sort="id" onclick="sortByColumn('id')">@lang('messages.reservation_number')</th>
                                    <th class="sort" data-sort="email">@lang('messages.client_name')</th>
                                    <th class="sort" data-sort="phone">@lang('messages.phone_number')</th>
                                    <th class="sort" data-sort="name_ar">@lang('messages.venue')</th>
                                    <th class="sort" data-sort="match_time" onclick="sortByColumn('match_time')">@lang('messages.reservation_duration')</th>
                                    <th class="sort" data-sort="type">@lang('messages.match_type')</th>
                                    <th class="sort" data-sort="paid_amount" onclick="sortByColumn('paid_amount')">@lang('messages.paid_amount')</th>
                                    <th class="sort" data-sort="grand_total" onclick="sortByColumn('grand_total')">@lang('messages.total_amount')</th>
                                    <th class="sort" data-sort="reservation_date" onclick="sortByColumn('reservation_date')">@lang('messages.reservation_date')</th>
                                    <th class="sort" data-sort="reservation_time" onclick="sortByColumn('reservation_time')">@lang('messages.reservation_time')</th>
                                    <th class="sort" data-sort="status">@lang('messages.status')</th>
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
                                <h5 class="mt-2">@lang('messages.no_results_found')</h5>
                                <p class="text-muted mb-0">
                                    @lang('messages.no_results_message', ['total' => $reservations->total()])
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
                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" autocomplete="off">
                                <div class="modal-body">
                                    <input type="hidden" id="id-field" />

                                    <div class="mb-3" id="modal-id" style="display: none;">
                                        <label for="id-field1" class="form-label">ID</label>
                                        <input type="text" id="id-field1" class="form-control" placeholder="ID" readonly />
                                    </div>

                                    <div class="mb-3">
                                        <label for="customername-field" class="form-label">@lang('messages.customer_name')</label>
                                        <input type="text" id="customername-field" class="form-control" placeholder="@lang('messages.enter_name')" />
                                        <div class="invalid-feedback">@lang('messages.enter_customer_name')</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email-field" class="form-label">@lang('messages.email')</label>
                                        <input type="email" id="email-field" class="form-control" placeholder="@lang('messages.enter_email')" />
                                        <div class="invalid-feedback">@lang('messages.enter_email')</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone-field" class="form-label">@lang('messages.phone_number')</label>
                                        <div class="input-group" data-input-flag>
                                            <button class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="flag img" height="20" class="country-flagimg rounded"><span class="ms-2 country-codeno">+ 966</span></button>
                                            <input type="text" class="form-control rounded-end flag-input" value="" placeholder="@lang('messages.enter_phone_number')" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="phone-field" />
                                            <div class="dropdown-menu w-100">
                                                <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">@lang('messages.enter_phone_number')</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="date-field" class="form-label">@lang('messages.password') </label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" name="password" placeholder="@lang('translation.EnterPassword')" id="password-input" >
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="invalid-feedback">@lang('messages.enter_password')</div>
                                    </div>

                                    <div>
                                        <label for="status-field" class="form-label"> @lang('messages.account_status')</label>
                                        <select class="form-control" data-choices data-choices-search-false name="status-field" id="status-field" >
                                            <option value="">@lang('messages.status')</option>
                                            <option value="1">@lang('messages.active')</option>
                                            <option value="0">@lang('messages.inactive')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('messages.cancel')</button>
                                        <button type="submit" class="btn btn-primary" id="add-btn">@lang('messages.add_customer')</button>
                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                    </lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>@lang('messages.confirmation_title')</h4>
                                        <p class="text-muted mx-4 mb-0">@lang('messages.confirmation_message')</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">@lang('messages.close')</button>
                                    <button type="button" class="btn w-sm btn-danger " id="delete-record">>@lang('messages.delete_record')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal -->
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

<script src="{{ URL::asset('build/js/admin/reservations.js') }}"></script>
<script src="{{ URL::asset('build/libs/multi.js/multi.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-input-spin.init.js') }}"></script>
<script src="{{URL::asset('build/js/pages/flag-input.init.js')}}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
    window.languageSettings = {
        locale: "{{ app()->getLocale() }}",
        messages: @json(__('messages'))
    };
</script>


@endsection
