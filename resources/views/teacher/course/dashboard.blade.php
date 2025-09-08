@extends('layouts.teacher')

@section('content-main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Referrals</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Ученики</h1>
                </div>
                <!-- End Col -->

                <div class="col-sm-6 col-md-5 col-lg-4">
                    <small class="text-cap">Цылка для подключение к курсу:</small>

                    <!-- Input Group -->
                    <div class="input-group">
                        <input id="referralCode" type="text" class="form-control" readonly="" value="{{route('course.subscribe',['id'=>$course->id])}}">
                        <div class="input-group-append">
                            <a class="js-clipboard btn btn-white" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="right" title="Copy to clipboard" data-hs-clipboard-options='{
                    "type": "tooltip",
                    "successText": "Copied!",
                    "contentTarget": "#referralCode",
                    "classChangeTarget": "#referralCodeIcon",
                    "defaultClass": "bi-clipboard",
                    "successClass": "bi-check"
                   }'>
                                <i id="referralCodeIcon" class="bi-clipboard"></i>
                            </a>
                        </div>
                    </div>
                    <!-- End Input Group -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row col-lg-divider">
            <div class="col-lg-4">
                <!-- Card -->
                <div class="text-center">
                    <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations/oc-megaphone.svg')}}" alt="Image Description" data-hs-theme-appearance="default" style="min-height: 6rem;">
                    <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations-light/oc-megaphone.svg')}}" alt="Image Description" data-hs-theme-appearance="dark" style="min-height: 6rem;">
                    <span class="text-cap text-body">Number of referrals</span>
                    <span class="d-block display-4 text-dark mb-2">150</span>

                    <div class="row col-divider">
                        <div class="col text-end">
                <span class="d-block fw-semibold text-success">
                  <i class="bi-graph-up"></i> 12%
                </span>
                            <span class="d-block">change</span>
                        </div>
                        <!-- End Col -->

                        <div class="col text-start">
                            <span class="d-block fw-semibold text-dark">25</span>
                            <span class="d-block">last week</span>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="text-center">
                    <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations/oc-money-profits.svg')}}" alt="Image Description" data-hs-theme-appearance="default" style="min-height: 6rem;">
                    <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations-light/oc-money-profits.svg')}}" alt="Image Description" data-hs-theme-appearance="dark" style="min-height: 6rem;">
                    <span class="text-cap text-body">Amount earned</span>
                    <span class="d-block display-4 text-dark mb-2">$7,253.00</span>

                    <div class="row col-divider">
                        <div class="col text-end">
                <span class="d-block fw-semibold text-success">
                  <i class="bi-graph-up"></i> 5.6%
                </span>
                            <span class="d-block">change</span>
                        </div>
                        <!-- End Col -->

                        <div class="col text-start">
                            <span class="d-block fw-semibold text-dark">$582.00</span>
                            <span class="d-block">last week</span>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="text-center">
                    <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations/oc-growing.svg')}}" alt="Image Description" data-hs-theme-appearance="default" style="min-height: 6rem;">
                    <img class="avatar avatar-xl avatar-4x3 mb-4" src="{{asset('assets/svg/illustrations-light/oc-growing.svg')}}" alt="Image Description" data-hs-theme-appearance="dark" style="min-height: 6rem;">
                    <span class="text-cap text-body">Referral completed</span>
                    <span class="d-block display-4 text-dark mb-2">25</span>

                    <div class="row col-divider">
                        <div class="col text-end">
                <span class="d-block fw-semibold text-danger">
                  <i class="bi-graph-down"></i> 2.3%
                </span>
                            <span class="d-block">change</span>
                        </div>
                        <!-- End Col -->

                        <div class="col text-start">
                            <span class="d-block fw-semibold text-dark">7</span>
                            <span class="d-block">last week</span>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Stats -->

        <div class="my-5">
            <p class="text-muted"><i class="bi-exclamation-octagon"></i> Last referral: August 25, 2020.</p>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header card-header-content-sm-between">
                        <h4 class="card-header-title mb-2 mb-sm-0">Total sales earnings</h4>

                        <!-- Daterangepicker -->
                        <button id="js-daterangepicker-predefined" class="btn btn-ghost-secondary btn-sm dropdown-toggle">
                            <i class="tio-date-range"></i>
                            <span class="js-daterangepicker-predefined-preview ms-1"></span>
                        </button>
                        <!-- End Daterangepicker -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Bar Chart -->
                        <div class="chartjs-custom">
                            <canvas id="referrals" class="js-chart" style="height: 15rem;" data-hs-chartjs-options='{
                          "type": "bar",
                          "data": {
                            "labels": ["Jan", "Feb", "March", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            "datasets": [{
                              "data": [200, 300, 290, 350, 150, 350, 300, 100, 125, 220, 390, 220],
                              "backgroundColor": "#377dff",
                              "hoverBackgroundColor": "#377dff",
                              "borderColor": "#377dff",
                              "maxBarThickness": "10"
                            }]
                          },
                          "options": {
                            "scales": {
                              "y": {
                                "grid": {
                                  "color": "#e7eaf3",
                                  "drawBorder": false,
                                  "zeroLineColor": "#e7eaf3"
                                },
                                "ticks": {
                                  "beginAtZero": true,
                                  "stepSize": 100,
                                  "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                  "padding": 10,
                                  "postfix": "$"
                                }
                              },
                              "x": {
                                "grid": {
                                  "display": false,
                                  "drawBorder": false
                                },
                                "ticks": {
                                  "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                  "padding": 5
                                },
                                "categoryPercentage": 0.5,
                                "maxBarThickness": "10"
                              }
                            },
                            "cornerRadius": 2,
                            "plugins": {
                              "tooltip": {
                                "prefix": "$",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false
                              }
                            },
                            "hover": {
                              "mode": "nearest",
                              "intersect": true
                            }
                          }
                        }'></canvas>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">Таблитца лидеров <i class="bi-patch-check-fill text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="This report is based on 100% of sessions."></i></h4>
                        <a class="btn btn-ghost-secondary btn-sm" href="#">View all</a>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="list-group list-group-flush list-group-no-gutters">
                            <!-- Item -->

                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img class="avatar avatar-xss avatar-circle" src="{{asset('assets/vendor/flag-icon-css/flags/1x1/us.svg')}}" alt="Flag">
                                    </div>

                                    <div class="flex-grow-1 ms-2">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <span class="d-block">United States</span>
                                            </div>
                                            <!-- End Col -->

                                            <div class="col-auto">
                                                <h5>$4,302.00</h5>
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Item -->


                        </div>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <h4 class="card-header-title">Referral users</h4>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                   "order": [],
                   "info": {
                     "totalQty": "#datatableWithPaginationInfoTotalQty"
                   },
                   "entries": "#datatableEntries",
                   "pageLength": 15,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatablePagination"
                 }'>
                    <thead class="thead-light">
                    <tr>
                        <th>Студенты</th>
                        <th>Профил</th>
                        <th>Опыт</th>
                        <th>Пройдено</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($course->students as $student)
                    <tr>
                        <td>
                            <a class="d-flex align-items-center" href="user-profile.html">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-soft-info avatar-circle">
                                        <span class="avatar-initials">B</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <span class="d-block h5 text-inherit mb-0">{{$student->name}}</span>
                                    <span class="d-block fs-6 text-body">{{$student->email}}</span>
                                </div>
                            </a>
                        </td>
                        <td>89340</td>
                        <td>
                            <div class="input-group input-group-sm input-group-merge table-input-group">
                                <input id="referralsKeyCode12" type="text" class="form-control" readonly="" value="https://htmlstream.com/wer9n8x">
                                <a class="js-clipboard input-group-append input-group-text" href="javascript:;" data-bs-toggle="tooltip" title="Copy to clipboard" data-hs-clipboard-options='{
                        "type": "tooltip",
                        "successText": "Copied!",
                        "contentTarget": "#referralsKeyCode12",
                        "classChangeTarget": "#referralsKeyCodeIcon12",
                        "defaultClass": "bi-clipboard",
                        "successClass": "bi-check"
                       }'>
                                    <i id="referralsKeyCodeIcon12" class="bi-clipboard"></i>
                                </a>
                            </div>
                        </td>
                        <td>39</td>
                        <td>$20.00</td>
                    </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">Showing:</span>

                            <!-- Select -->
                            <div class="tom-select-custom">
                                <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }'>
                                    <option value="10">10</option>
                                    <option value="15" selected="">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <!-- End Select -->

                            <span class="text-secondary me-2">of</span>

                            <!-- Pagination Quantity -->
                            <span id="datatableWithPaginationInfoTotalQty"></span>
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>


@endsection
