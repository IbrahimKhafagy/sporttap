<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo_sport.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/small_logo.png') }}" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo_sport.png') }}" alt="" height="35">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu"></div>
            <ul class="navbar-nav text-center" id="navbar-nav">
                <li class="menu-title">
                    <span>@lang('messages.menu')</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="home" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="mdi mdi-home-outline"></i> <span>@lang('messages.dashboards')</span>
                    </a>
                </li>
                 <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a href="Clients" class="nav-link">
                    <i class="mdi mdi-account-outline"></i> <span>@lang('messages.Clients')</span>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPlaces" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPlaces">
                        <i class="bx bxs-edit-location"></i> <span>@lang('messages.Places')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPlaces">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="playgrounds" class="nav-link">
                                    <i class="bx bx-football"></i> <span>@lang('messages.playgrounds')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="places" class="nav-link">
                                    <i class="bx bx-football"></i> <span>@lang('messages.places')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
