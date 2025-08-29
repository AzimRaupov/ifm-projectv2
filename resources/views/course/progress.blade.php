@extends('layouts.app')

@section('head')
    <script src=
                "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js">
    </script>
    <script src=
                "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.umd.js">
    </script>
   @endsection
@section('content-main')
    <div class="content container-fluid">
        <div class="row justify-content-lg-center" style="max-width: 100%">

                <!-- Profile Cover -->
                <div class="profile-cover">
                    <div class="profile-cover-img-wrapper">
                        <img id="profileCoverImg" class="profile-cover-img" src="{{asset('assets/img/1920x400/img2.jpg')}}" alt="Image Description">

                        <!-- Custom File Cover -->
                        <div class="profile-cover-content profile-cover-uploader p-3">
                            <input type="file" class="js-file-attach profile-cover-uploader-input" id="profileCoverUplaoder" data-hs-file-attach-options='{
                            "textTarget": "#profileCoverImg",
                            "mode": "image",
                            "targetAttr": "src",
                            "allowTypes": [".png", ".jpeg", ".jpg"]
                         }'>

                        </div>
                        <!-- End Custom File Cover -->
                    </div>
                </div>

                <div class="text-center mb-5">
                    <!-- Avatar -->
                    <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="editAvatarUploaderModal">
                        <img id="editAvatarImgModal" class="avatar-img" src="{{$course->logo}}" alt="Image Description">

                        <input type="file" class="js-file-attach avatar-uploader-input" id="editAvatarUploaderModal" data-hs-file-attach-options='{
                          "textTarget": "#editAvatarImgModal",
                          "mode": "image",
                          "targetAttr": "src",

                          "allowTypes": [".png", ".jpeg", ".jpg"]
                       }'>


                    </label>
                    <!-- End Avatar -->

                    <h1 class="page-header-title">{{$course->topic}}</h1>


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

                </div>
                <!-- End Nav -->

                <div class="row">
                    <div class="col-lg-4">
                        <!-- Card -->
                        <div class="card card-body mb-3 mb-lg-5">
                            <h5>Прогресс курса</h5>

                            <!-- Progress -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{$complete}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-4">{{$complete}}%</span>

                            </div>
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Пройденые шаги</h4>                             <span>{{$course->step_student->sum('ex').'/'.$course->steps->sum('experience')}} ex</span>

                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            @php
                                $completedStepIds = $course->step_student->pluck('step_id')->toArray();
                            @endphp

                            <div class="card-body">
                                <ul class="list-unstyled list-py-2 text-dark mb-0">
                                    @foreach($course->steps as $step)
                                        @if(in_array($step->id, $completedStepIds))
                                    <li><a href="{{route('test.show')}}?id={{$step->id}}">{{$step->title}}</a></li>
                                        @endif
                                            @endforeach

                                     </ul>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <!-- End Card -->
                    </div>
                    <!-- End Col -->

                    <div class="col-lg-8">
                        <!-- Card -->
                        <div class="card card-centered mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Навыки</h4>

                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="contentActivityStreamDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="contentActivityStreamDropdown">
                                        <span class="dropdown-header">Settings</span>

                                        <a class="dropdown-item" href="#">
                                            <i class="bi-share-fill dropdown-item-icon"></i> Share connections
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi-info-circle dropdown-item-icon"></i> Suggest edits
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
                            <div class="card-body card-body-height" style="overflow: hidden; height: auto; display: flex; justify-content: center; align-items: center;">
                                <div>
                                    <canvas id="radarChart"></canvas>
                                </div>
                            </div>
                            <!-- End Body -->
                        </div>


                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <style>
        #radarChart {
            max-width: 650px;
            height: 450px;
        }

        @media (max-width: 768px) {
            #radarChart {
                max-width: 100%;
                height: 400px;
            }
        }

        @media (max-width: 480px) {
            #radarChart {
                height: 200px;
            }
        }

    </style>


    <div class="footer">
        <div class="row justify-content-between align-items-center">
            <div class="col">
                <p class="fs-6 mb-0">&copy; Front. <span class="d-none d-sm-inline-block">2022 Htmlstream.</span></p>
            </div>
            <!-- End Col -->

            <div class="col-auto">
                <div class="d-flex justify-content-end">
                    <!-- List Separator -->
                    <ul class="list-inline list-separator">
                        <li class="list-inline-item">
                            <a class="list-separator-link" href="#">FAQ</a>
                        </li>

                        <li class="list-inline-item">
                            <a class="list-separator-link" href="#">License</a>
                        </li>

                        <li class="list-inline-item">
                            <!-- Keyboard Shortcuts Toggle -->
                            <button class="btn btn-ghost-secondary btn btn-icon btn-ghost-secondary rounded-circle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKeyboardShortcuts" aria-controls="offcanvasKeyboardShortcuts">
                                <i class="bi-command"></i>
                            </button>
                            <!-- End Keyboard Shortcuts Toggle -->
                        </li>
                    </ul>
                    <!-- End List Separator -->
                </div>
            </div>

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
@endsection


@section('script')
    <script>
        $.ajax({
            url: "{{ route('api.get.skills') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            contentType: "application/json",
            data: JSON.stringify({
                id:{{$course->id}}
            }),
            success: function(skills) {
                console.log(skills);
                radar(skills);
            },
            error: function(xhr, status, error) {
                console.error("Ошибка:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
            }
        });
        function radar(skillsd) {

            let ctx =
                document.getElementById('radarChart').getContext('2d');
            let myRadarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: skillsd.skills,
                    datasets: [{
                        label: 'Полученые навыки',
                        data: skillsd.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(0,147,192)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scale: {
                        pointLabels: {
                            fontSize: 15,
                        },
                    }
                }
            });

        }
    </script>
@endsection
