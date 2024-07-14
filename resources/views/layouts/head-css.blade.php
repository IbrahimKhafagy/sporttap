@yield('css')
<!-- Layout config Js -->
<script src="{{ URL::asset('build/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('build/css/bootstrap.min.css') }}"  rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('css/app.min.css') }}"  rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ URL::asset('build/css/custom.min.css') }}"  rel="stylesheet" type="text/css" />
{{-- @yield('css') --}}
@if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset('build/css/app.min.rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/bootstrap.min.rtl.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('build/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/bootstrap.min.css') }}">
@endif



