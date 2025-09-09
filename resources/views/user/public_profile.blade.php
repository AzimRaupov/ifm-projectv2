@extends('layouts.app')


@section('content-main')

<div class="content container-fluid">
    <div class="row justify-content-lg-center" style="max-width: 100%">
        <div class="col-lg-10">
            <!-- Profile Cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper">
                    <img class="profile-cover-img" src="{{asset('assets/img/1920x400/img1.jpg')}}" alt="Image Description">
                </div>
            </div>



            <div class="text-center mb-5">
                <!-- Avatar -->
                <div class="avatar avatar-xxl avatar-circle profile-cover-avatar avatar-soft-primary">

                    @if(isset($user->photo) && $user->photo)
                        <img id="editAvatarImgModal" class="avatar-img"
                             src="{{ asset('storage/' . $user->photo) }}"
                             alt="Фото профиля пользователя {{ $user->name }}">
                    @else
                        <span class="avatar-initials">{{ mb_substr($user->name, 0, 1) }}</span>

                    @endif


                    <span class="avatar-status avatar-status-success"></span>
                </div>
                <!-- End Avatar -->

                <h1 class="page-header-title">{{$user->name}}</h1>

                <!-- List -->
                <ul class="list-inline list-px-2">

                    <li class="list-inline-item">
                        <i class="bi-mortarboard me-1"></i>
                        <span>Ученик</span>

                    </li>
                </ul>
                <!-- End List -->
            </div>
            <!-- End Profile Header -->

            <!-- Nav -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal mb-5">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="bi-chevron-left"></i>
              </a>
            </span>

                <span class="hs-nav-scroller-arrow-next" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="bi-chevron-right"></i>
              </a>
            </span>

                <ul class="nav nav-tabs align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="user-profile.html">Profile</a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link " href="user-profile-teams.html">Teams</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link " href="user-profile-projects.html">Projects <span class="badge bg-soft-dark text-dark rounded-circle ms-1">3</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link " href="user-profile-connections.html">Connections</a>--}}
{{--                    </li>--}}

{{--                    <li class="nav-item ms-auto">--}}
{{--                        <div class="d-flex gap-2">--}}
{{--                            <!-- Form Check -->--}}
{{--                            <div class="form-check form-check-switch">--}}
{{--                                <input class="form-check-input" type="checkbox" value="" id="connectCheckbox">--}}
{{--                                <label class="form-check-label btn btn-sm" for="connectCheckbox">--}}
{{--                      <span class="form-check-default">--}}
{{--                        <i class="bi-person-plus-fill"></i> Connect--}}
{{--                      </span>--}}
{{--                                    <span class="form-check-active">--}}
{{--                        <i class="bi-check-lg me-2"></i> Connected--}}
{{--                      </span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                            <!-- End Form Check -->--}}

{{--                            <a class="btn btn-icon btn-sm btn-white" href="#">--}}
{{--                                <i class="bi-list-ul me-1"></i>--}}
{{--                            </a>--}}

{{--                            <!-- Dropdown -->--}}
{{--                            <div class="dropdown nav-scroller-dropdown">--}}
{{--                                <button type="button" class="btn btn-white btn-icon btn-sm" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                    <i class="bi-three-dots-vertical"></i>--}}
{{--                                </button>--}}

{{--                                <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="profileDropdown">--}}
{{--                                    <span class="dropdown-header">Settings</span>--}}

{{--                                    <a class="dropdown-item" href="#">--}}
{{--                                        <i class="bi-share-fill dropdown-item-icon"></i> Share profile--}}
{{--                                    </a>--}}
{{--                                    <a class="dropdown-item" href="#">--}}
{{--                                        <i class="bi-slash-circle dropdown-item-icon"></i> Block page and profile--}}
{{--                                    </a>--}}
{{--                                    <a class="dropdown-item" href="#">--}}
{{--                                        <i class="bi-info-circle dropdown-item-icon"></i> Suggest edits--}}
{{--                                    </a>--}}

{{--                                    <div class="dropdown-divider"></div>--}}

{{--                                    <span class="dropdown-header">Feedback</span>--}}

{{--                                    <a class="dropdown-item" href="#">--}}
{{--                                        <i class="bi-flag dropdown-item-icon"></i> Report--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- End Dropdown -->--}}
{{--                        </div>--}}
{{--                    </li>--}}
                </ul>
            </div>
            <!-- End Nav -->

            <div class="row">

                <div class="col-lg-12">
                    <div class="d-grid gap-3 gap-lg-5">
                        <!-- Card -->
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Лента активности</h4>


                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body card-body-height" style="height: 19rem;">
                                <div>

                                    <!-- Header -->
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <!-- Matrix Chart -->
                                        <div class="chartjs-matrix-custom mb-3" style="min-width: 100%; width: 700px;">
                                            <canvas class="js-chart-matrix" style='min-height: 150px;' data-hs-chartjs-options='{
              "options": {
                "matrixBackgroundColord": {
                   "color": "#377dff",
                   "accent": 50,
                   "additionToValue": 2
                },
                "matrixLegend": {
                  "container": "#matrixLegend"
                }
              }
            }'></canvas>
                                        </div>
                                        <!-- End Matrix Chart -->

                                        <!-- Matrix Legend -->
                                        <ul id="matrixLegend" class="mb-0"></ul>
                                        <!-- End Matrix Legend -->
                                    </div>
                                    <!-- End Body -->

                                    <hr class="my-0">

                                    <!-- End Row -->
                                </div>
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->
                            <div class="card-footer">
                                <a class="link link-collapse" data-bs-toggle="collapse" href="#collapseActivitySection" role="button" aria-expanded="false" aria-controls="collapseActivitySection">
                                    <span class="link-collapse-default">View more</span>
                                    <span class="link-collapse-active">View less</span>
                                </a>
                            </div>
                            <!-- End Footer -->
                        </div>
                        <!-- End Card -->

                        <div class="row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <!-- Card -->
                                <div class="card h-100">
                                    <!-- Header -->
                                    <div class="card-header">
                                        <h4 class="card-header-title">Connections</h4>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <ul class="list-unstyled list-py-3 mb-0">
                                            <!-- Item -->
                                            <li>
                                                <div class="d-flex align-items-center">
                                                    <a class="d-flex align-items-center me-2" href="#">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                                                                <span class="avatar-initials">R</span>
                                                                <span class="avatar-status avatar-sm-status avatar-status-warning"></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="text-hover-primary mb-0">Rachel Doe</h5>
                                                            <span class="fs-6 text-body">25 connections</span>
                                                        </div>
                                                    </a>
                                                    <div class="ms-auto">
                                                        <!-- Form Check -->
                                                        <div class="form-check form-check-switch">
                                                            <input class="form-check-input" type="checkbox" value="" id="connectionsCheckbox1" checked="">
                                                            <label class="form-check-label btn-icon btn-xs rounded-circle" for="connectionsCheckbox1">
                                    <span class="form-check-default">
                                      <i class="bi-person-plus-fill"></i>
                                    </span>
                                                                <span class="form-check-active">
                                      <i class="bi-check-lg"></i>
                                    </span>
                                                            </label>
                                                        </div>
                                                        <!-- End Form Check -->
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <div class="d-flex align-items-center">
                                                    <a class="d-flex align-items-center me-2" href="#">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm avatar-circle">
                                                                <img class="avatar-img" src="assets/img/160x160/img8.jpg" alt="Image Description">
                                                                <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="text-hover-primary mb-0">Isabella Finley</h5>
                                                            <span class="fs-6 text-body">79 connections</span>
                                                        </div>
                                                    </a>
                                                    <div class="ms-auto">
                                                        <!-- Form Check -->
                                                        <div class="form-check form-check-switch">
                                                            <input class="form-check-input" type="checkbox" value="" id="connectionsCheckbox2">
                                                            <label class="form-check-label btn-icon btn-xs rounded-circle" for="connectionsCheckbox2">
                                    <span class="form-check-default">
                                      <i class="bi-person-plus-fill"></i>
                                    </span>
                                                                <span class="form-check-active">
                                      <i class="bi-check-lg"></i>
                                    </span>
                                                            </label>
                                                        </div>
                                                        <!-- End Form Check -->
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <div class="d-flex align-items-center">
                                                    <a class="d-flex align-items-center me-2" href="#">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm avatar-circle">
                                                                <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                                                                <span class="avatar-status avatar-sm-status avatar-status-warning"></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="text-hover-primary mb-0">David Harrison</h5>
                                                            <span class="fs-6 text-body">0 connections</span>
                                                        </div>
                                                    </a>
                                                    <div class="ms-auto">
                                                        <!-- Form Check -->
                                                        <div class="form-check form-check-switch">
                                                            <input class="form-check-input" type="checkbox" value="" id="connectionsCheckbox3" checked="">
                                                            <label class="form-check-label btn-icon btn-xs rounded-circle" for="connectionsCheckbox3">
                                    <span class="form-check-default">
                                      <i class="bi-person-plus-fill"></i>
                                    </span>
                                                                <span class="form-check-active">
                                      <i class="bi-check-lg"></i>
                                    </span>
                                                            </label>
                                                        </div>
                                                        <!-- End Form Check -->
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <div class="d-flex align-items-center">
                                                    <a class="d-flex align-items-center me-2" href="#">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm avatar-circle">
                                                                <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                                                                <span class="avatar-status avatar-sm-status avatar-status-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="text-hover-primary mb-0">Costa Quinn</h5>
                                                            <span class="fs-6 text-body">9 connections</span>
                                                        </div>
                                                    </a>
                                                    <div class="ms-auto">
                                                        <!-- Form Check -->
                                                        <div class="form-check form-check-switch">
                                                            <input class="form-check-input" type="checkbox" value="" id="connectionsCheckbox4">
                                                            <label class="form-check-label btn-icon btn-xs rounded-circle" for="connectionsCheckbox4">
                                    <span class="form-check-default">
                                      <i class="bi-person-plus-fill"></i>
                                    </span>
                                                                <span class="form-check-active">
                                      <i class="bi-check-lg"></i>
                                    </span>
                                                            </label>
                                                        </div>
                                                        <!-- End Form Check -->
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- End Item -->
                                        </ul>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <a class="card-footer text-center" href="user-profile-connections.html">
                                        View all connections <i class="bi-chevron-right"></i>
                                    </a>
                                    <!-- End Footer -->
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col-sm-6">
                                <!-- Card -->
                                <div class="card h-100">
                                    <!-- Header -->
                                    <div class="card-header">
                                        <h4 class="card-header-title">Teams</h4>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Body -->
                                    <div class="card-body">
                                        <ul class="nav nav-pills card-nav card-nav-vertical nav-pills">
                                            <!-- Item -->
                                            <li>
                                                <a class="nav-link" href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi-people-fill nav-icon text-dark"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <span class="d-block text-dark">#digitalmarketing</span>
                                                            <small class="d-block text-muted">8 members</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <a class="nav-link" href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi-people-fill nav-icon text-dark"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <span class="d-block text-dark">#ethereum</span>
                                                            <small class="d-block text-muted">14 members</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <a class="nav-link" href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi-people-fill nav-icon text-dark"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <span class="d-block text-dark">#conference</span>
                                                            <small class="d-block text-muted">3 members</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <a class="nav-link" href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi-people-fill nav-icon text-dark"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <span class="d-block text-dark">#supportteam</span>
                                                            <small class="d-block text-muted">3 members</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- End Item -->

                                            <!-- Item -->
                                            <li>
                                                <a class="nav-link" href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi-people-fill nav-icon text-dark"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <span class="d-block text-dark">#invoices</span>
                                                            <small class="d-block text-muted">3 members</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- End Item -->
                                        </ul>
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <a class="card-footer text-center" href="user-profile-teams.html">
                                        View all teams <i class="bi-chevron-right"></i>
                                    </a>
                                    <!-- End Footer -->
                                </div>
                                <!-- End Card -->
                            </div>
                        </div>
                        <!-- End Row -->

                        <!-- Card -->
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Курсы</h4>

                                <!-- Dropdown -->
                                <div class="dropdowm">
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="projectReportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>

                                </div>
                                <!-- End Dropdown -->
                            </div>
                            <!-- End Header -->

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Курс</th>
                                        <th style="width: 40%;">Пройдено</th>
                                        <th class="table-text-end">Hours spent</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($user->courses as $course)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                               <span class="avatar avatar-xs avatar-soft-dark avatar-circle">
                              <img src="{{$course->logo}}" class="avatar-img" alt="">
                               </span>
                                                <div class="ms-3">
                                                    <h5 class="mb-0">{{$course->topic}}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $totalSteps = $course->step ?? 0;
                                                    $completed  = $course->pivot->complete ?? 0;
                                                    $percent    = $totalSteps > 0 ? round(($completed / $totalSteps) * 100, 2) : 0;
                                                @endphp
                                                <span class="me-3">{{ $percent }}%</span>
                                                <div class="progress table-progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="table-text-end">4:25</td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->

                            <!-- Footer -->
                            <a class="card-footer text-center" href="projects.html">
                                View all projects <i class="bi-chevron-right"></i>
                            </a>
                            <!-- End Footer -->
                        </div>
                        <!-- End Card -->
                    </div>

                    <!-- Sticky Block End Point -->
                    <div id="stickyBlockEndPoint"></div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>

@endsection

@section('script')
    <script>
        function view_profile(user_g){
            console.log(user_g);

                var data = [];
            var start = moment().subtract(200, 'days').startOf('day');
            var end = moment().add(164, 'days').startOf('day'); // 30 дней в будущем

            var dt = start.clone();  // копия, чтобы не мутировать start

            while(dt <= end) {
                let found = user_g.action.find(a => a.date === dt.format('YYYY-MM-DD'));

                data.push({
                    x: dt.format('YYYY-MM-DD'),        // для оси X
                    y: dt.format('e'),                 // ISO день недели
                    d: dt.format('YYYY-MM-DD'),        // для tooltip
                    v: found ? (found.minutes / 60)*5 : 0 // часы (из минут)
                });

                dt = dt.add(1, 'day');
                }
                console.log(data);
            HSCore.components.HSChartMatrixJS.init(document.querySelector('.js-chart-matrix'), {
                data: {
                    datasets: [{
                        label: 'Commits',
                        data: data,
                        width(c) {
                            const a = c.chart.chartArea || {};
                            return (a.right - a.left) / 70;
                        },
                        height(c) {
                            const a = c.chart.chartArea || {};
                            return (a.bottom - a.top) / 7;
                        }
                    }]
                },
                options: {
                    aspectRatio: 5,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function() { return '';},
                                label: function(item) {
                                    var v = item.dataset.data[item.dataIndex]; // исправлено здесь

                                    if (v.v.toFixed() > 0) {
                                        return '<span class="fw-semibold">' + v.v.toFixed()/5 + ' hours</span> on ' + v.d;
                                    }  else {
                                        return '<span class="fw-semibold">No time</span> on ' + v.d;
                                    }
                                }

                            }
                        },
                    },
                    scales: {
                        y: {
                            type: 'time',

                            offset: true,
                            time: {
                                unit: 'day',
                                round: 'day',
                                isoWeekday: 1,
                                parser: 'i',
                                displayFormats: {
                                    day: 'iiiiii'
                                }
                            },
                            reverse: true,
                            ticks: {
                                font: {
                                    size: 12,
                                },
                                maxTicksLimit: 5,
                                color: "rgba(22, 52, 90, 0.5)",
                                maxRotation: 0,
                                autoSkip: true
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                                tickLength: 0
                            }
                        },
                        x: {
                            type: 'time',
                            position: 'bottom',
                            offset: true,
                            time: {
                                unit: 'week',
                                round: 'week',
                                isoWeekday: 1,
                                displayFormats: {
                                    week: 'MMM dd'
                                }
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                },
                                maxTicksLimit: 5,
                                color: "rgba(22, 52, 90, 0.5)",
                                maxRotation: 0,
                                autoSkip: true
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                                tickLength: 0,
                            }
                        }
                    }
                }
            })

        }
    </script>
@endsection
