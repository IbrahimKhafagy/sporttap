@extends('layouts.master')
@section('title')
    @lang('messages.order_details')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet "type="text/css" />

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
        @endslot
        @slot('title')
            @lang('messages.order_details')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0"> @lang('messages.order_number')  :{{$reservation->id}}</h5>
                        <div class="flex-shrink-0">
                            <a href="apps-invoices-details" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> @lang('messages.invoice')</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">@lang('messages.reservation_details')</th>
                                <th scope="col">@lang('messages.price')</th>
                                <th scope="col">@lang('messages.num_of_tickets')</th>
                                <th scope="col" class="text-end">@lang('messages.total')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                            <img src="{{ $reservation->playground->image }}" alt="" class="img-fluid d-block">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fs-15">
                                                <a href="{{ url('events/' . $reservation->playground->id) }}" class="link-primary">
                                                    @if(app()->getLocale() === 'ar')
                                                        {{ $reservation->playground->name_ar }}
                                                    @else
                                                        {{ $reservation->playground->name_en }}
                                                    @endif
                                                </a>
                                            </h5>
                                            <p class="text-muted mb-0">@lang('messages.date'): <span class="fw-medium" id="event-datet" data-event-date="{{ $reservation->reservation_date }}"></span></p>
                                            <p class="text-muted mb-0">@lang('messages.time'): <span class="fw-medium" id="event-time" data-event-time="{{ $reservation->reservation_time }}"></span></p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $reservation->paid_amount }} @lang('messages.currency')</td>
                                <td>{{ $reservation->num_of_ticket }}</td>
                                <td class="fw-medium text-end">{{ $reservation->total }} @lang('messages.currency')</td>
                            </tr>
                            <tr class="border-top border-top-dashed">
                                <td colspan="3"></td>
                                <td colspan="2" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        <tr>
                                            <td>@lang('messages.subtotal'):</td>
                                            <td class="text-end">{{ $reservation->total }} @lang('messages.currency')</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('messages.wallet_balance') <span class="text-muted"></span> :</td>
                                            <td class="text-end">- {{ $reservation->used_wallet_balance }} @lang('messages.currency')</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @lang('messages.discount')
                                                <span class="text-muted">
                                                    ({{ optional($reservation->coupon)->coupon_code ?? __('messages.no_coupon') }})
                                                 </span> :
                                            </td>
                                            <td class="text-end">- {{ $reservation->discount }} @lang('messages.currency')</td>
                                        </tr>
                                        <tr class="border-top border-top-dashed">
                                            <th scope="row">@lang('messages.total_price') (@lang('messages.currency')) :</th>
                                            <th class="text-end">{{ $reservation->grand_total }} @lang('messages.currency')</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('messages.order_status')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-sm-8">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item border-0">
                                        <div class="accordion-header" id="headingOne">
                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 avatar-xs">
                                                        <div class="avatar-title bg-success rounded-circle shadow">
                                                            <i class="ri-shopping-bag-line"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="fs-15 mb-0 fw-semibold">
                                                            @lang('messages.order_created') -
                                                            <span class="fw-normal" id="event-date" data-created-at="{{ $reservation->created_at }}"></span>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body ms-2 ps-5 pt-0">
                                                <h6 class="mb-1">@lang('messages.order_and_ticket_booked_at')</h6>
                                                <p class="text-muted" id="event-date-time" data-created-time="{{ $reservation->created_at }}">
                                                    {{ $reservation->created_at->format('D, d M Y - h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="choices-publish-status-input" class="form-label">@lang('messages.status')</label>
                                    <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                                        <option value="paid" {{ $reservation->status == 'paid' ? 'selected' : '' }}>@lang('messages.paid') </option>
                                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>@lang('messages.pending') </option>
                                        <option value="payment_failed" {{ $reservation->status == 'payment_failed' ? 'selected' : '' }}>@lang('messages.payment_failed') </option>
                                        <option value="pending_payment" {{ $reservation->status == 'pending_payment' ? 'selected' : '' }}>@lang('messages.pending_payment')</option>
                                        <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}> @lang('messages.completed')</option>
                                        <option value="canceled" {{ $reservation->status == 'canceled' ? 'selected' : '' }}> @lang('messages.canceled')</option>
                                    </select>
                                </div>
                                <div class="text-end mb-3">
                                    <button type="submit" class="btn btn-primary w-sm" id="save-status-btn">@lang('messages.save')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-ticket-confirmation-outline align-middle me-1 text-muted"></i>@lang('messages.ticket_image') </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ URL::asset( 'storage/tickets/' . $reservation->barcode . '.png' )}}" alt="" class="img-fluid d-block">
                        <h5 class="fs-16 mt-2">
                            @if(app()->getLocale() === 'ar')
                                {{ $reservation->playground->name_ar }}
                            @else
                                {{ $reservation->playground->name_en }}
                            @endif
                        </h5>
                        <p class="text-muted mb-0">ID: {{ $reservation->id }}</p>
                        <p class="text-muted mb-0 payment-status">
                        @php
                            $statusMessages = [
                                'confirmed' => [
                                    'ar' => 'مؤكد',
                                    'en' => 'Confirmed'
                                ],
                                'pending' => [
                                    'ar' => 'معلق',
                                    'en' => 'Pending'
                                ],
                                'payment_failed' => [
                                    'ar' => 'فشل الدفع',
                                    'en' => 'Payment Failed'
                                ],
                                'pending_payment' => [
                                    'ar' => 'انتظار الدفع',
                                    'en' => 'Pending Payment'
                                ],
                                'refunded' => [
                                    'ar' => 'تمت استعادة المبلغ',
                                    'en' => 'Refunded'
                                ],
                                'completed' => [
                                    'ar' => 'مكتمل',
                                    'en' => 'Completed'
                                ],
                                'canceled' => [
                                    'ar' => 'ملغى',
                                    'en' => 'Canceled'
                                ],
                            ];

                            $locale = app()->getLocale();
                            $status = $statusMessages[$reservation->status][$locale] ?? $reservation->status;
                        @endphp

                        <p class="text-muted mb-0 payment-status">{{ $status }}</p>

                        </p>
                    </div>
                </div>
            </div>
            <!--end card-->

            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"> @lang('messages.client_data')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{  URL::asset('build/images/users/avatar-3.jpg') }}" alt="" class="avatar-sm rounded shadow">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $reservation->user->first_name . ' ' . $reservation->user->last_name }}</h6>
{{--                                    <p class="text-muted mb-0">{{$reservation->user->email}}</p>--}}
                                    <p class="text-muted mb-0">{{$reservation->user->phone}}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>@lang('messages.playground_address')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14" style="font-family: 'Tajawal',serif ">{{$reservation->playground->name_ar}}</li>
                        <li style="font-family: 'Tajawal',serif ">{{$reservation->playground->name_en}}</li>
                        <li style="font-family: 'Tajawal',serif ">{{$reservation->playground->address}}</li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> @lang('messages.payment_info') </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('messages.ticket_number'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{$reservation->barcode}}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0"> @lang('messages.payment_method'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">
                                {{ $reservation->is_plan ? __('messages.subscription_plan') : __('messages.online') }}
                            </h6>

                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0"> @lang('messages.subscription_plan'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{$reservation->is_plan ? $reservation->user->active_subscription->plan->name_ar :"-" }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('messages.total'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{$reservation->grand_total}}  @lang('messages.currency') </h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <script>
        window.ticketId = {{ $reservation->id }};
        window.csrfToken = '{{ csrf_token() }}';
    </script>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/admin/orderDetails.js') }}"></script>
@endsection
