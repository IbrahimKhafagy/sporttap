@extends('layouts.master')
@section('title')
@lang('messages.Client_menu')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col">

<div class="row">

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'تمت الإضافة بنجاح',
            text: '{{ session('success') }}',
        });
    </script>
@endif

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">@lang('messages.Clients')</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <button
                                    type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#addUserModal"
                                    ><i
                                        class="ri-add-line align-bottom me-1"></i> @lang('messages.add_client')</button>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    <th scope="col">@lang('messages.first_name')</th>
                                    <th scope="col">@lang('messages.last_name')</th>
                                    <th scope="col">@lang('messages.phone')</th>
                                    <th scope="col">@lang('messages.sport_type')</th>
                                    <th scope="col">@lang('messages.gender')</th>
                                    <th scope="col">@lang('messages.level')</th>
                                    <th scope="col">@lang('messages.age')</th>
                                    <th scope="col">@lang('messages.is_active')</th>
                                    <th scope="col">@lang('messages.actions')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    <td>{{ $client->first_name }}</td>
                                    <td>{{ $client->last_name }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->sport_type }}</td>
                                    <td>{{ $client->gender }}</td>
                                    <td>{{ $client->level }}</td>
                                    <td>{{ $client->age }}</td>
                                    <td>{{ $client->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        {{-- <div class="col-xl-3 col-lg-4 col-sm-6">
                                            <i class="ri-pencil-fill fs-16"></i> --}}
                                        </div>
                                        <a href="{{ route('clients.edit', ['client' => $client->id]) }}" class="btn btn-primary"><i class="ri-pencil-fill"></i></a>
                                        <form action="" method="POST" style="display: inline;">
                                            @csrf

                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                    orders for you search.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="javascript:void(0);">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title arabic-font" id="addUserModalLabel">@lang('messages.add_client')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label english-font">@lang('messages.first_name')</label>
                            <input type="text" class="form-control english-font" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label english-font">@lang('messages.last_name')</label>
                            <input type="text" class="form-control english-font" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label english-font">@lang('messages.phone')</label>
                            <input type="text" class="form-control english-font" id="phone" name="phone" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sport_type" class="form-label english-font">@lang('messages.sport_type')</label>
                            <input type="text" class="form-control english-font" id="sport_type" name="sport_type" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gender" class="form-label english-font">@lang('messages.gender')</label>
                            <select class="form-control english-font" id="gender" name="gender" required>
                                <option value="male">@lang('messages.male')</option>
                                <option value="female">@lang('messages.female')</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="level" class="form-label english-font">@lang('messages.level')</label>
                            <input type="text" class="form-control english-font" id="level" name="level" required>
                        </div>
                    </div>
                    <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="check" class="form-label english-font">@lang('messages.check')</label>
                                <!-- أضف حقل مخفي لضمان إرسال القيمة false -->
                                <input type="hidden" name="check" value="0">
                                <input type="checkbox" id="check" name="check" value="1">
                            </div>

                        <div class="col-md-6">
                            <label for="age" class="form-label english-font">@lang('messages.age')</label>
                            <input type="number" class="form-control english-font" id="age" name="age" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="is_active" class="form-label english-font">@lang('messages.is_active')</label>
                            <!-- أضف حقل مخفي لضمان إرسال القيمة false -->
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary english-font" id="saveUserBtn">@lang('messages.save')</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
