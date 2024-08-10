@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('content')
    <div class="position-relative mx-n4 mt-n4" style="height: 100px;">
        <div class="profile-wid-bg profile-setting-img" style="height: 100px;">
            <img src="{{ URL::asset('build/images/profile-bg.jpg') }}" class="profile-wid-img" alt="" >
            <div class="overlay-content">

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow"
                                alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body shadow">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{$client->first_name ." ".$client->last_name}}</h5>
                        <p class="text-muted mb-0">محترف</p>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-5">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">استكمال الحساب   </h5>
                        </div>
                        <div class="flex-shrink-0">
                            <a  href="#showModal" data-bs-toggle="modal" class="badge bg-light text-primary fs-12" >
                                <i
                                    class="ri-edit-box-line align-bottom me-1"></i> تعديل</a>
                        </div>
                    </div>
                    <div class="progress animated-progress custom-progress progress-label">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="label">70%</div>
                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="d-flex align-items-center mb-4">--}}
{{--                        <div class="flex-grow-1">--}}
{{--                            <h5 class="card-title mb-0">Portfolio</h5>--}}
{{--                        </div>--}}
{{--                        <div class="flex-shrink-0">--}}
{{--                            <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i--}}
{{--                                    class="ri-add-fill align-bottom me-1"></i> Add</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3 d-flex">--}}
{{--                        <div class="avatar-xs d-block flex-shrink-0 me-3">--}}
{{--                            <span class="avatar-title rounded-circle fs-16 bg-body text-body shadow">--}}
{{--                                <i class="ri-github-fill"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <input type="email" class="form-control" id="gitUsername" placeholder="Username"--}}
{{--                            value="@daveadame">--}}
{{--                    </div>--}}
{{--                    <div class="mb-3 d-flex">--}}
{{--                        <div class="avatar-xs d-block flex-shrink-0 me-3">--}}
{{--                            <span class="avatar-title rounded-circle fs-16 bg-primary shadow">--}}
{{--                                <i class="ri-global-fill"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com"--}}
{{--                            value="www.velzon.com">--}}
{{--                    </div>--}}
{{--                    <div class="mb-3 d-flex">--}}
{{--                        <div class="avatar-xs d-block flex-shrink-0 me-3">--}}
{{--                            <span class="avatar-title rounded-circle fs-16 bg-success shadow">--}}
{{--                                <i class="ri-dribbble-fill"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <input type="text" class="form-control" id="dribbleName" placeholder="Username"--}}
{{--                            value="@dave_adame">--}}
{{--                    </div>--}}
{{--                    <div class="d-flex">--}}
{{--                        <div class="avatar-xs d-block flex-shrink-0 me-3">--}}
{{--                            <span class="avatar-title rounded-circle fs-16 bg-danger shadow">--}}
{{--                                <i class="ri-pinterest-fill"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <input type="text" class="form-control" id="pinterestName" placeholder="Username"--}}
{{--                            value="Advance Dave">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                البيانات الشخصية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                               تغيير كلمة المرور
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab">
                                <i class="far fa-envelope"></i>
                               الحجوزات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i>
                               المباريات
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label">الاسم الاول
                                                </label>
                                            <input type="text" class="form-control" id="firstnameInput"
                                                placeholder="Enter your firstname" value="{{$client->first_name}}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">الاسم الاخير
                                                </label>
                                            <input type="text" class="form-control" id="lastnameInput"
                                                placeholder="Enter your lastname" value="{{$client->last_name}}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">رقم الجوال
                                                </label>
                                            <input type="text" class="form-control" id="phonenumberInput"
                                                placeholder="Enter your phone number" value="{{$client->phone}}">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary">تحديث</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row g-2">

                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New
                                                Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>

                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="experience" role="tabpanel">
                            <form>
                                <div id="newlink">
                                    <div id="1">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="jobTitle" class="form-label">Job
                                                        Title</label>
                                                    <input type="text" class="form-control" id="jobTitle"
                                                        placeholder="Job title" value="Lead Designer / Developer">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="companyName" class="form-label">Company
                                                        Name</label>
                                                    <input type="text" class="form-control" id="companyName"
                                                        placeholder="Company name" value="Themesbrand">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="experienceYear" class="form-label">Experience
                                                        Years</label>
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <select class="form-control" data-choices
                                                                data-choices-search-false name="experienceYear"
                                                                id="experienceYear">
                                                                <option value="">Select years</option>
                                                                <option value="Choice 1">2001</option>
                                                                <option value="Choice 2">2002</option>
                                                                <option value="Choice 3">2003</option>
                                                                <option value="Choice 4">2004</option>
                                                                <option value="Choice 5">2005</option>
                                                                <option value="Choice 6">2006</option>
                                                                <option value="Choice 7">2007</option>
                                                                <option value="Choice 8">2008</option>
                                                                <option value="Choice 9">2009</option>
                                                                <option value="Choice 10">2010</option>
                                                                <option value="Choice 11">2011</option>
                                                                <option value="Choice 12">2012</option>
                                                                <option value="Choice 13">2013</option>
                                                                <option value="Choice 14">2014</option>
                                                                <option value="Choice 15">2015</option>
                                                                <option value="Choice 16">2016</option>
                                                                <option value="Choice 17" selected>2017
                                                                </option>
                                                                <option value="Choice 18">2018</option>
                                                                <option value="Choice 19">2019</option>
                                                                <option value="Choice 20">2020</option>
                                                                <option value="Choice 21">2021</option>
                                                                <option value="Choice 22">2022</option>
                                                            </select>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-auto align-self-center">
                                                            to
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-5">
                                                            <select class="form-control" data-choices
                                                                data-choices-search-false name="choices-single-default2">
                                                                <option value="">Select years</option>
                                                                <option value="Choice 1">2001</option>
                                                                <option value="Choice 2">2002</option>
                                                                <option value="Choice 3">2003</option>
                                                                <option value="Choice 4">2004</option>
                                                                <option value="Choice 5">2005</option>
                                                                <option value="Choice 6">2006</option>
                                                                <option value="Choice 7">2007</option>
                                                                <option value="Choice 8">2008</option>
                                                                <option value="Choice 9">2009</option>
                                                                <option value="Choice 10">2010</option>
                                                                <option value="Choice 11">2011</option>
                                                                <option value="Choice 12">2012</option>
                                                                <option value="Choice 13">2013</option>
                                                                <option value="Choice 14">2014</option>
                                                                <option value="Choice 15">2015</option>
                                                                <option value="Choice 16">2016</option>
                                                                <option value="Choice 17">2017</option>
                                                                <option value="Choice 18">2018</option>
                                                                <option value="Choice 19">2019</option>
                                                                <option value="Choice 20" selected>2020
                                                                </option>
                                                                <option value="Choice 21">2021</option>
                                                                <option value="Choice 22">2022</option>
                                                            </select>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="jobDescription" class="form-label">Job
                                                        Description</label>
                                                    <textarea class="form-control" id="jobDescription" rows="3"
                                                        placeholder="Enter description">You always want to make sure that your fonts work well together and try to limit the number of fonts you use to three or less. Experiment and play around with the fonts that you already have in the software you're working with reputable font websites. </textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="hstack gap-2 justify-content-end">
                                                <a class="btn btn-success" href="javascript:deleteEl(1)">Delete</a>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                                <div id="newForm" style="display: none;">

                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="javascript:new_link()" class="btn btn-primary">Add
                                            New</a>
                                    </div>
                                </div>
                                <!--end col-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-4 pb-2">
                                <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Two-factor Authentication</h6>
                                        <p class="text-muted">Two-factor authentication is an enhanced
                                            security meansur. Once enabled, you'll be required to give
                                            two types of identification when you log into Google
                                            Authentication and SMS are Supported.</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Enable Two-facor
                                            Authentication</a>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Secondary Verification</h6>
                                        <p class="text-muted">The first factor is a password and the
                                            second commonly includes a text with a code sent to your
                                            smartphone, or biometrics using your fingerprint, face, or
                                            retina.</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Set
                                            up secondary method</a>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0 mt-2">
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Backup Codes</h6>
                                        <p class="text-muted mb-sm-0">A backup code is automatically
                                            generated for you when you turn on two-factor authentication
                                            through your iOS or Android Twitter app. You can also
                                            generate a backup code on twitter.com.</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Generate backup
                                            codes</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h5 class="card-title text-decoration-underline mb-3">Application
                                    Notifications:</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex">
                                        <div class="flex-grow-1">
                                            <label for="directMessage" class="form-check-label fs-14">Direct
                                                messages</label>
                                            <p class="text-muted">Messages from people you follow</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="directMessage" checked />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="desktopNotification">
                                                Show desktop notifications
                                            </label>
                                            <p class="text-muted">Choose the option you want as your
                                                default setting. Block a site: Next to "Not allowed to
                                                send notifications," click Add.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="desktopNotification" checked />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="emailNotification">
                                                Show email notifications
                                            </label>
                                            <p class="text-muted"> Under Settings, choose Notifications.
                                                Under Select an account, choose the account to enable
                                                notifications for. </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="emailNotification" />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="chatNotification">
                                                Show chat notifications
                                            </label>
                                            <p class="text-muted">To prevent duplicate mobile
                                                notifications from the Gmail and Chat apps, in settings,
                                                turn off Chat notifications.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="chatNotification" />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="purchaesNotification">
                                                Show purchase notifications
                                            </label>
                                            <p class="text-muted">Get real-time purchase alerts to
                                                protect yourself from fraudulent charges.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="purchaesNotification" />
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="card-title text-decoration-underline mb-3">Delete This
                                    Account:</h5>
                                <p class="text-muted">Go to the Data & Privacy section of your profile
                                    Account. Scroll to "Your data & privacy options." Delete your
                                    Profile Account. Follow the instructions to delete your account :
                                </p>
                                <div>
                                    <input type="password" class="form-control" id="passwordInput"
                                        placeholder="Enter your password" value="make@321654987" style="max-width: 265px;">
                                </div>
                                <div class="hstack gap-2 mt-3">
                                    <a href="javascript:void(0);" class="btn btn-soft-danger">Close &
                                        Delete This Account</a>
                                    <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
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
                                                <label for="customername-field" class="form-label">اسم العميل</label>
                                                <input type="text" id="customername-field" class="form-control" placeholder="أدخل الاسم"  />
                                                <div class="invalid-feedback">أدخل اسم العميل.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email-field" class="form-label">البريد الالكتروني</label>
                                                <input type="email" id="email-field" class="form-control" placeholder="ادخل البريد الالكتروني"  />
                                                <div class="invalid-feedback">ادخل البريد الالكتروني</div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="phone-field" class="form-label">رقم الجوال</label>
                                                <div class="input-group" data-input-flag>
                                                    <button class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="flag img" height="20" class="country-flagimg rounded"><span class="ms-2 country-codeno">+ 966</span></button>
                                                    <input type="text" class="form-control rounded-end flag-input" value="" placeholder="ادخل رقم الجوال" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="phone-field" />
                                                    <div class="dropdown-menu w-100">
                                                        <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">من فضلك ادخل رقم الجوال.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="date-field" class="form-label">كلمة المرور</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" name="password" placeholder="@lang('translation.EnterPassword')" id="password-input" >
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                                <div class="invalid-feedback">من فضلك ادخل كلمة المرور.</div>
                                            </div>

                                            <div>
                                                <label for="status-field" class="form-label">حالة الحساب</label>
                                                <select class="form-control" data-choices data-choices-search-false name="status-field" id="status-field" >
                                                    <option value="">الحالة</option>
                                                    <option value="1" >نشط</option>
                                                    <option value="0">غير نشط</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">الغاء</button>
                                                <button type="submit" class="btn btn-primary" id="add-btn">Add Customer</button>
                                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--end tab-pane-->
                    </div>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
