@extends('layouts.teacher')

@php
    $data = array_fill(0, 12, 0);
        foreach($progressByMonth as $item){
            $data[$item->month - 1] = $item->total; // month 1–12, массив 0–11
        }
@endphp

@section('content-main')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{route('teacher.course.edit',['id'=>$course->id])}}">{{$course->topic}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Кантроль</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Ученики</h1>
                </div>
                <!-- End Col -->

                <div class="col-sm-6 col-md-5 col-lg-4">
                    <small class="text-cap">Ссылка для подключения к курсу:</small>

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
                    <i class="bi bi-people mb-4" style="font-size: 40px;"></i>

                    <span class="text-cap text-body">Все студенты</span>
                    <span class="d-block display-4 text-dark mb-2">{{$course->students->count()}}</span>

                    <!-- End Row -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="text-center">
                    <i class="bi-person-lines-fill mb-4" style="font-size: 40px;"></i>

                    <span class="text-cap text-body">Ученики</span>
                    <span class="d-block display-4 text-dark mb-2">{{$course->students->count()-$certificate}}</span>

                    <!-- End Row -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="text-center">
                    <i class="bi bi-award mb-4" style="font-size: 40px"></i>

                    <span class="text-cap text-body">Выпускники</span>
                    <span class="d-block display-4 text-dark mb-2">{{$certificate}}</span>


                    <!-- End Row -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Stats -->

        <div class="my-5">
        </div>

        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header card-header-content-sm-between">
                        <h4 class="card-header-title mb-2 mb-sm-0">Статистика выполнения курса</h4>

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
                            "labels": ["Янв", "Фев", "Март", "Апр", "Май", "Июнь", "Июль", "Авг", "Сен", "Окт", "Ноя", "Дек"],
                            "datasets": [{
                              "data": [{{ implode(',', $data) }}],
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
                                  "postfix": ""
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
                                "postfix": "exp",
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
                        <h4 class="card-header-title">Таблица лидеров
                            <i class="bi bi-award-fill text-warning" title="Лучший результат"></i>
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="list-group list-group-flush list-group-no-gutters">
                            <!-- Item -->

                            @foreach($course->students as $student)
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-soft-primary avatar-circle">
                                        @if(isset($student->photo) && $student->photo)
                                            <img id="editAvatarImgModal" class="avatar-img"
                                                 src="{{ asset('storage/' . $student->photo) }}"
                                                 alt="Фото профиля пользователя {{ $student->name }}">
                                        @else
                                            <span class="avatar-initials">{{ mb_substr($student->name, 0, 1) }}</span>

                                        @endif                                    </div>

                                    <div class="flex-grow-1 ms-2">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <span class="d-block">{{$student->name}}</span>
                                            </div>
                                            <!-- End Col -->

                                            <div class="col-auto">
                                                <h5>{{$student->pivot->exp}}exp</h5>
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->

        <div class="card mx-4 mt-7">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12 col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header-title">Все ученики</h5>
                        </div>
                    </div>

                    <div class="col-auto">
                        <!-- Filter -->
                        <form>
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend input-group-text">
                                    <i class="bi-search"></i>
                                </div>
                                <input id="datatableWithSearchInput" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                            </div>
                            <!-- End Search -->
                        </form>
                        <!-- End Filter -->
                    </div>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                   "order": [],
                   "search": "#datatableWithSearchInput",
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatableWithSearchPagination"
                 }'>
                    <thead class="thead-light">
                    <tr>
                        <th>Имя</th>
                        <th>Полученый опыт</th>
                        <th>Пройдено на</th>
                        <th>Дата поступление</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($course->students as $student)
                        <tr>
                            <td>
                                <a class="d-flex align-items-center" target="_blank" href="{{route('profile.edit',['id'=>$student->id])}}">
                                    <div class="avatar avatar-soft-primary avatar-circle">
                                        @if(isset($student->photo) && $student->photo)
                                            <img id="editAvatarImgModal" class="avatar-img"
                                                 src="{{ asset('storage/' . $student->photo) }}"
                                                 alt="Фото профиля пользователя {{ $student->name }}">
                                        @else
                                            <span class="avatar-initials">{{ mb_substr($student->name, 0, 1) }}</span>

                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <span class="d-block h5 text-inherit mb-0">{{$student->name}}</span>
                                        <span class="d-block fs-5 text-body">{{$student->email}}</span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <span class="d-block h5 mb-0">{{$student->pivot->exp}}</span>
                            </td>
                            <td>{{round(($student->pivot->complete / $course->step)*100,2)}}%</td>

                            <td>{{ $student->pivot->created_at }}</td>

                        </tr>
                    @endforeach






                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="d-flex justify-content-center justify-content-sm-end">
                    <nav id="datatableWithSearchPagination" aria-label="Activity pagination"></nav>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>

    </div>


@endsection

@section('script')
    <script>
        (function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            HSCore.components.HSDatatables.init('.js-datatable')
        })()
    </script>
@endsection
