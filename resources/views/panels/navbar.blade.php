<!-- Top Navbar -->

<nav class="hk-navbar navbar navbar-expand-xl shadow navbar-light fixed-top">
    <div class="container-fluid">
    <!-- Start Nav -->
    <div class="nav-start-wrap">
        <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle d-xl-none"><span class="icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span></button>
        <ul class="nav nav-light">
            <li class="nav-item dropdown d-none d-md-block">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><small>Perusahaan</small><br><span class="fw-bold text-primary">{{$perusahaan->nama}}</span></a>
                <div class="dropdown-menu">
                    @if(role('owner'))
                    <a class="dropdown-item" href="{{route('perusahaan.index')}}">Profil Perusahaan</a>
                    @endif
                    <a class="dropdown-item" href="{{$perusahaan->website}}">Website</a>
                </div>
            </li>
        </ul>
        <a href="{{$perusahaan->website}}" class="text-primary d-block d-md-none">{!! icons('globe') !!} <small>Company Site</small></a>
    </div>

    <!-- /Start Nav -->
    <div class="nav-end-wrap">
        <ul class="navbar-nav flex-row">
            @if(role('admin') || role('owner'))
            <li class="nav-item d-none d-md-block">
                <a href="{{route('calculate-presensi')}}" class="btn btn-gradient-info btn-calculate-presensi px-4 py-2 me-2 fw-bold">{!! icons('git-pull') !!} HITUNG PRESENSI</a>
            </li>
            @endif
            <li class="nav-item d-none d-md-block">
                {{-- CLOCK --}}
                <div class="clock-container bg-primary text-white p-2 me-2 fw-bold">
                    <div class="clock-col">
                        <p class="clock-timer">
                            {!! icons('clock') !!} <span class="clock-day"></span>
                        </p>
                    </div>
                    <div class="clock-col">
                        <p class="clock-hours clock-timer">
                        </p>

                    </div>
                    <div class="clock-col">
                        <p class="clock-minutes clock-timer">
                        </p>

                    </div>
                    <div class="clock-col">
                        <p class="clock-seconds clock-timer">
                        </p>
                    </div>
                </div>
                {{-- END CLOCK --}}
            </li>
            @if(role('owner'))
            <li class="nav-item d-none d-md-block">
                <div class="btn-group dropdown me-2">
                    <button type="button" class="btn btn-flush-dark flush-outline-hover dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user-circle me-2"></i> Management User
                    </button>
                    <div class="dropdown-menu dropdown-bordered">
                        <a class="dropdown-item" href="{{route('users.direksi.index')}}"><i class="dropdown-icon las la-user"></i></i><span>DIRUT</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('users.hrd.index')}}"><i class="dropdown-icon las la-user"></i><span>BUK</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('users.manager.index')}}"><i class="dropdown-icon las la-user"></i></i><span>PIC</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('users.finance.index')}}"><i class="dropdown-icon las la-user"></i></i><span>Finance</span></a>
                    </div>
                </div>
            </li>
            @endif
            <li class="nav-item">
                <div class="dropdown dropdown-notifications">
                    <a href="#" class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover dropdown-toggle no-caret" data-bs-toggle="dropdown" data-dropdown-animation role="button" aria-haspopup="true" aria-expanded="false"><span class="icon"><span class="position-relative"><i class="far fa-bell"></i><span class="badge badge-danger badge-indicator position-top-end-overflow-1"></span></span></span></a>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <h6 class="dropdown-header px-4 fs-6">Notifications<a href="#" class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"><span class="icon"><span class="feather-icon"><i data-feather="settings"></i></span></span></a>
                        </h6>
                        <div data-simplebar class="dropdown-body  p-2">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-head">
                                        <div class="avatar avatar-rounded avatar-sm">
                                            <img src="{{asset('/')}}dist/img/businessman.png" alt="user" class="avatar-img">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Morgan Freeman accepted your invitation to join the team</div>
                                            <div class="notifications-info">
                                                <span class="badge badge-soft-success">Collaboration</span>
                                                <div class="notifications-time">Today, 10:14 PM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-head">
                                        <div class="avatar  avatar-icon avatar-sm avatar-success avatar-rounded">
                                            <span class="initial-wrap">
                                                <span class="feather-icon"><i data-feather="inbox"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">New message received from Alan Rickman</div>
                                            <div class="notifications-info">
                                                <div class="notifications-time">Today, 7:51 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-head">
                                        <div class="avatar  avatar-icon avatar-sm avatar-pink avatar-rounded">
                                            <span class="initial-wrap">
                                                <span class="feather-icon"><i data-feather="clock"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">You have a follow up with Jampack Head on Friday, Dec 19 at 9:30 am</div>
                                            <div class="notifications-info">
                                                <div class="notifications-time">Yesterday, 9:25 PM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-head">
                                        <div class="avatar avatar-sm avatar-rounded">
                                            <img src="{{asset('/')}}dist/img/avatar3.jpg" alt="user" class="avatar-img">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Application of Sarah Williams is waiting for your approval</div>
                                            <div class="notifications-info">
                                                <div class="notifications-time">Today 10:14 PM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-head">
                                        <div class="avatar avatar-sm avatar-rounded">
                                            <img src="{{asset('/')}}dist/img/avatar10.jpg" alt="user" class="avatar-img">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Winston Churchil shared a document with you</div>
                                            <div class="notifications-info">
                                                <span class="badge badge-soft-violet">File Manager</span>
                                                <div class="notifications-time">2 Oct, 2021</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-head">
                                        <div class="avatar  avatar-icon avatar-sm avatar-danger avatar-rounded">
                                            <span class="initial-wrap">
                                                <span class="feather-icon"><i data-feather="calendar"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Last 2 days left for the project to be completed</div>
                                            <div class="notifications-info">
                                                <span class="badge badge-soft-orange">Updates</span>
                                                <div class="notifications-time">14 Sep, 2021</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer"><a href="#"><u>View all notifications</u></a></div>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <div class="dropdown mx-2">
                    <a class=" dropdown-toggle no-caret" href="#" role="button" data-bs-display="static" data-bs-toggle="dropdown" data-dropdown-animation data-bs-auto-close="outside" aria-expanded="false">
                        <div class="avatar avatar-rounded avatar-xs">
                            <img src="{{asset('/')}}dist/img/businessman.png" alt="user" class="avatar-img">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="p-2">
                            <div class="media">
                                <div class="media-head me-2 d-flex align-items-center">
                                    <div class="avatar avatar-primary avatar-sm avatar-rounded">
                                        <span class="initial-wrap">{{roleFormat()}}</span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="dropdown">
                                        <a href="#" class="d-block link-dark fw-medium" >{{auth()->user()->name}} <span class="badge badge-sm badge-soft-green">{{auth()->user()->nip}}</span></a>
                                    </div>
                                    <div class="fs-7">{{auth()->user()->email}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('password.index')}}">Akun</a>
                        <a class="dropdown-item" href="{{route('password.index')}}">Ubah Password</a>
                        <a class="dropdown-item" href="{{url('logout')}}"><span class="me-2">Sing Out</span></a>

                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- /End Nav -->
    </div>
</nav>
<!-- /Top Navbar -->
