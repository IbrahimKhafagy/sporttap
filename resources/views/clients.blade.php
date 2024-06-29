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
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">@lang('messages.Client_menu')</h4>
            </div>
            <div class="card-header align-items-center d-flex">
                <h3 class="card-title mb-0 flex-grow-1 text-left">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        @lang('messages.add_client')
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
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->first_name }}</td>
                                    <td>{{ $client->last_name }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->sport_type }}</td>
                                    <td>{{ $client->gender }}</td>
                                    <td>{{ $client->level }}</td>
                                    <td>{{ $client->age }}</td>
                                    <td>{{ $client->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <a href="" class="btn btn-primary">تعديل</a>
                                        <form action="" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                            <input type="checkbox" id="check" name="check">
                        </div>
                        <div class="col-md-6">
                            <label for="age" class="form-label english-font">@lang('messages.age')</label>
                            <input type="number" class="form-control english-font" id="age" name="age" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="is_active" class="form-label english-font">@lang('messages.is_active')</label>
                            <input type="checkbox" id="is_active" name="is_active">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary english-font">@lang('messages.save')</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
