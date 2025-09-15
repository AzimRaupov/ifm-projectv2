@extends('layouts.app')


@section('title')
    Прогресс панель
@endsection

@section('content-main')
    @if($courses->isEmpty())

        <div class="content container-fluid">
            <div class="row justify-content-sm-center text-center py-10">
                <div class="col-sm-7 col-md-5">
                    <img class="img-fluid mb-5" src="{{asset('assets/svg/illustrations/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="img-fluid mb-5" src="{{asset('assets/svg/illustrations-light/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">

                    <h1>Здравствуй, ты ещё не создал курс!</h1>
                    <p>Нажми на кнопку, чтобы создать курс.</p>

                    <a class="btn btn-primary" href="{{route('course.create')}}">Создайте первый курс</a>
                </div>
            </div>
        </div>
    @else
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">Прогресс панель</h1>
                </div>
                <!-- End Col -->

                <div class="col-auto">
                    <a class="btn btn-primary"  onclick="newCourse()" data-bs-toggle="modal" >
                        <i class="bi-person-plus-fill me-1"></i> Новый курс
                    </a>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row">
            @foreach($courses as $course)
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="{{route('course.progress',['id'=>$course->id])}}">
                    <div class="card-body">
                        <h6 class="card-subtitle">{{$course->topic}}</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <h2 class="card-title text-inherit">{{$course->complete}}%</h2>
                            </div>
                            <!-- End Col -->

                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem;">
                                    <canvas class="js-chart" data-hs-chartjs-options='{
        "type": "line",
        "data": {
            "labels": {{ json_encode($course->progress->pluck("date")->toArray()) }},
            "datasets": [{
                "label": "Прагресс",
                "data": {{ json_encode($course->progress->pluck("colum")->toArray()) }},
                "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                "borderColor": "#377dff",
                "borderWidth": 2,
                "pointRadius": 0,
                "pointHoverRadius": 0
            }]
        },
        "options": {
            "scales": {
                "y": {
                    "display": false
                },
                "x": {
                    "display": false
                }
            },
            "hover": {
                "mode": "nearest",
                "intersect": false
            },
            "plugins": {
                "tooltip": {
                    "postfix": "ex",
                    "hasIndicator": true,
                    "intersect": false
                }
            }
        }
    }'></canvas>
                                </div>                                <!-- End Chart -->
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                        <span class="badge {{$course->pr>=0 ? "bg-soft-success text-success" : "bg-soft-danger text-danger"}}">
                <i class="bi-graph-{{$course->pr>=0 ? "up" : "down"}}"></i> {{$course->pr}}%
              </span>
                        <span class="text-body fs-6 ms-1">Дата {{$course->created_at->format('d.m.Y')}}</span>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            @endforeach

        </div>
        <!-- End Stats -->

        <div class="row">
            <div class="col-lg-5 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">Курсы</h4>

                        <!-- Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="reportsOverviewDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-three-dots-vertical"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="reportsOverviewDropdown2">
                                <span class="dropdown-header">Settings</span>

                                <a class="dropdown-item" href="#">
                                    <i class="bi-share-fill dropdown-item-icon"></i> Share chart
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi-download dropdown-item-icon"></i> Download
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi-alt dropdown-item-icon"></i> Connect other apps
                                </a>

                                <div class="dropdown-divider"></div>

                                <span class="dropdown-header">Feedback</span>

                                <a class="dropdown-item" href="#">
                                    <i class="bi-chat-left-dots dropdown-item-icon"></i> Report
                                </a>
                            </div>
                        </div>
                        <!-- End Dropdown -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">

                        <ul class="list-group list-group-flush list-group-no-gutters">


                            @foreach($courses as $course)
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img class="avatar avatar-xs avatar-4x3" src="{{$course->logo}}" alt="Image Description">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="mb-0">{{$course->topic}}</h5>
                                            </div>
                                            <!-- End Col -->

                                            <div class="col-auto">
                                                <a class="btn btn-primary btn-sm" href="{{route('show',['id'=>$course->id])}}" title="Launch importer" target="_blank">
                                                    Продолжит <span class="d-none d-sm-inline-block">курс</span>
                                                    <i class="bi-box-arrow-up-right ms-1"></i>
                                                </a>
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-lg-7 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header card-header-content-sm-between">
                        <h4 class="card-header-title mb-2 mb-sm-0">Ежемесячные прогресс</h4>

                        <!-- Nav -->
                        <ul class="nav nav-segment nav-fill" id="expensesTab" role="tablist">
                            <li class="nav-item" data-bs-toggle="chart-bar" data-datasets="thisWeek" data-trigger="click" data-action="toggle">
                                <a class="nav-link active" href="javascript:;" data-bs-toggle="tab">Это неделя</a>
                            </li>
                            <li class="nav-item" data-bs-toggle="chart-bar" data-datasets="lastWeek" data-trigger="click" data-action="toggle">
                                <a class="nav-link" href="javascript:;" data-bs-toggle="tab">Прошедшая неделя</a>
                            </li>
                        </ul>
                        <!-- End Nav -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <span class="h1 mb-0">35%</span>
                                    <span class="text-success ms-2">
                      <i class="bi-graph-up"></i> 25.3%
                    </span>
                                </div>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm-auto align-self-sm-end">
                                <div class="row fs-6 text-body">
                                    <div class="col-auto">
                                        <span class="legend-indicator bg-primary"></span> New
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-auto">
                                        <span class="legend-indicator"></span> Overdue
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Row -->
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                        <!-- Bar Chart -->
                        <div class="chartjs-custom">
                            <canvas id="updatingBarChart" style="height: 20rem;" data-hs-chartjs-options='{
                          "type": "bar",
                          "data": {
                            "labels": ["May 1", "May 2", "May 3", "May 4", "May 5", "May 6", "May 7", "May 8", "May 9", "May 10"],
                            "datasets": [{
                              "data": [200, 300, 290, 350, 150, 350, 300, 100, 125, 220],
                              "backgroundColor": "#377dff",
                              "hoverBackgroundColor": "#377dff",
                              "borderColor": "#377dff",
                              "maxBarThickness": "10"
                            },
                            {
                              "data": [150, 230, 382, 204, 169, 290, 300, 100, 300, 225, 120],
                              "backgroundColor": "#e7eaf3",
                              "borderColor": "#e7eaf3",
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
                                  "fontSize": 12,
                                  "fontColor":  "#97a4af",
                                  "fontFamily": "Open Sans, sans-serif",
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
                                  "fontSize": 12,
                                  "fontColor":  "#97a4af",
                                  "fontFamily": "Open Sans, sans-serif",
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
            <!-- End Col -->
        </div>


    </div>
    @endif

@endsection




