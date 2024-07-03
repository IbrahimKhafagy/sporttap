@extends('layouts.master-without-nav')

@section('title')
    @lang('messages.project')
@endsection

@section('content')
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index" class="d-inline-block auth-logo">
                                    <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="20">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">@lang('auth.welcome_back')</h5>
                                    <p class="text-muted">@lang('auth.sign_in_to_continue')</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="p-2 mt-4" dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
                                    {{-- <body > --}}
                                    <form method="POST" action="{{ route('admin.login')}}" class="{{ app()->getLocale() === 'ar' ?  'rtl arabic-font' : 'ltr english-font' }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="email" class="form-label">@lang('auth.email')</label>
                                            <input type="email" class="form-control" id="email" name="email"  placeholder="@lang('auth.email')" required>
                                        </div>

                                        <div class="mb-3">

                                            <label for="password" class="form-label">@lang('auth.password')</label>
                                            <input type="password" class="form-control" id="password" name="password"  placeholder="@lang('auth.password')" required>
                                        </div>

                                        <div class="form-check">
                                            <div class="float-end">
                                                <a href="{{ route('admin.password.request') }}" class="text-muted" >@lang('auth.forgot_password')</a>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">@lang('auth.log_in')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        @include('layouts.footer')
        <!-- end auth page content -->

        <!-- footer -->
@endsection
