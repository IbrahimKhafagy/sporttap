<!-- resources/views/clients/edit.blade.php -->
@extends('layouts.master')

@section('title')
@lang('messages.Client_menu')
@endsection

@section('content')
<div class="container">

    <div class="card">
            <h2>@lang('messages.edit_client')</h2>

        <style>
            .small-input {
                width: 50%; /* يمكنك تعديل هذه النسبة لتتناسب مع احتياجاتك */
            }
        </style>
            <form action="{{route('admin.users.update')}}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                <div class="form-group col-md-4">
                    <label for="first_name">@lang('messages.first_name')</label>
                    <input type="text" name="first_name" class="form-control small-input" value="{{ old('first_name', $client->first_name) }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="last_name">@lang('messages.last_name')</label>
                    <input type="text" name="last_name" class="form-control small-input" value="{{ old('last_name', $client->last_name) }}">
                </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-4">
                        <label for="phone">@lang('messages.phone')</label>
                        <input type="text" name="phone" class="form-control small-input" value="{{ old('phone', $client->phone) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="sport_type">@lang('messages.sport_type')</label>
                        <input type="text" name="sport_type" class="form-control small-input" value="{{ old('sport_type', $client->sport_type) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group col-md-4">
                        <label for="gender">@lang('messages.gender')</label>
                        <input type="text" name="gender" class="form-control small-input" value="{{ old('gender', $client->gender) }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="level">@lang('messages.level')</label>
                        <input type="text" name="level" class="form-control small-input" value="{{ old('level', $client->level) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group col-md-4">
                        <label for="age">@lang('messages.age')</label>
                        <input type="number" name="age" class="form-control small-input" value="{{ old('age', $client->age) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="is_active">@lang('messages.is_active')</label>
                        <select name="is_active" class="form-control small-input">
                            <option value="1" {{ old('is_active', $client->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $client->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <button type="submit" class="btn btn-primary col-md-3" style="text-left">@lang('messages.update')</button>
                </div>
            </form>
    </div>

</div>
@endsection
