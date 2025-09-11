@extends('layouts.teacher')


@section('head')
    <script src="{{asset('js/main.js')}}" ></script>
@endsection

@section('new')
    new HSFileAttach('.js-file-attach');

    new HSAddField('.js-add-field');

@endsection

@section('content-main')
    <div class="content container-fluid">
        <div class="row justify-content-lg-center">
            <div class="col-lg-10">
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
                            <label class="profile-cover-uploader-label btn btn-sm btn-white" for="profileCoverUplaoder">
                                <i class="bi-camera-fill"></i>
                                <span class="d-none d-sm-inline-block ms-1">Upload header</span>
                            </label>
                        </div>
                        <!-- End Custom File Cover -->
                    </div>
                </div>

                <form action="{{route('teacher.course.update')}}" class="course-update" method="post" enctype="multipart/form-data">
                    <button type="submit">dfsds</button>
                    <input type="hidden" name="id" value="{{$course->id}}">
                    <div class="text-center mb-5">
                    <!-- Avatar -->
                    <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="editAvatarUploaderModal">
                        @if(Str::startsWith($course->logo, 'course'))
                            <img id="editAvatarImgModal" class="avatar-img" src="{{ asset('storage/' . $course->logo) }}" alt="Image Description">
                        @else
                            <img id="editAvatarImgModal" class="avatar-img" src="{{ $course->logo }}" alt="Image Description">
                        @endif

                        <input type="file" class="js-file-attach avatar-uploader-input" name="logo-course" id="editAvatarUploaderModal" data-hs-file-attach-options='{
                          "textTarget": "#editAvatarImgModal",
                          "mode": "image",
                          "targetAttr": "src",
                          "allowTypes": [".png", ".jpeg", ".jpg"]
                       }'>

                        <span class="avatar-uploader-trigger">
                <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
              </span>
                    </label>
                    <!-- End Avatar -->

                        <h1 class="page-header-title">
                            <input type="text" name="topic" value="{{$course->topic}}">
                        </h1>

                    <!-- List -->
                    <ul class="list-inline list-px-2">
                        <li class="list-inline-item">
                            <i class="bi-building me-1"></i>
                            <span>Pixeel Ltd.</span>
                        </li>

                        <li class="list-inline-item">
                            <i class="bi-geo-alt me-1"></i>
                            <a href="#">London,</a>
                            <a href="#">UK</a>
                        </li>

                        <li class="list-inline-item">
                            <i class="bi-calendar-week me-1"></i>
                            <span>Joined March 2013</span>
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
                            <a class="nav-link active disabled" href="#">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Teams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Projects <span class="badge bg-soft-dark text-dark rounded-circle ms-1">3</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Connections</a>
                        </li>

                        <li class="nav-item ms-auto">
                            <div class="d-flex gap-2">
                                <a class="btn btn-primary btn-sm" onclick="save_all_cheng()">
                                    <i class="bi-save me-1"></i> Сохранить изменение
                                </a>

                                <a class="btn btn-white btn-icon btn-sm" href="#">
                                    <i class="bi-list-ul me-1"></i>
                                </a>

                                <!-- Dropdown -->
                                <div class="dropdown nav-scroller-dropdown">
                                    <button type="button" class="btn btn-white btn-icon btn-sm" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="profileDropdown">
                                        <span class="dropdown-header">Settings</span>

                                        <a class="dropdown-item" href="#">
                                            <i class="bi-share-fill dropdown-item-icon"></i> Share profile
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi-slash-circle dropdown-item-icon"></i> Block page and profile
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi-info-circle dropdown-item-icon"></i> Suggest edits
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <span class="dropdown-header">Feedback</span>

                                        <a class="dropdown-item" href="#">
                                            <i class="bi-flag dropdown-item-icon"></i> Report
                                        </a>
                                    </div>
                                </div>
                                <!-- End Dropdown -->
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- End Nav -->

                <div class="row">
                    <div class="col-lg-4">
                        <!-- Card -->
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Навыки</h4>
                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="card-body">
                                <div id="links_content">
                                    <div class="js-add-field row mb-4"
                                         data-hs-add-field-options='{
        "template": "#addEmailFieldTemplate",
        "container": "#addEmailFieldContainer",
        "defaultCreated": 0,
        "limit": 20
      }'>

                                        <div class="col-sm-9">

                                            <div id="addEmailFieldContainer">
                                                @foreach($course->skills as $skill)
                                                <div style>

                                                    <input type="text" class="js-input-mask form-control"
                                                           value="{{$skill->skill}}"
                                                           name="skills[]"
                                                           placeholder="Навык"
                                                           aria-label="Навык">
                                                </div>
                                                @endforeach
                                            </div>

                                            <a href="javascript:;" class="js-create-field form-link">
                                                <i class="bi-plus-circle me-1"></i> Добавть сылку
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Add Phone Input Field -->
                                    <div id="addEmailFieldTemplate" style="display: none;">

                                        <input type="text" class="js-input-mask form-control" name="skills[]" placeholder="Видите навык" aria-label="Видите навык">


                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card card-lg mb-3 mb-lg-5">
                            <!-- Body -->
                            <div class="card-body text-center">
                                <div class="mb-4">
                                    <img class="avatar avatar-xl avatar-4x3" src="{{asset('assets/svg/illustrations/oc-unlock.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                                    <img class="avatar avatar-xl avatar-4x3" src="{{asset('assets/svg/illustrations-light/oc-unlock.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">
                                </div>

                                <div class="mb-3">
                                    <h3>2-step verification</h3>
                                    <p>Protect your account now and enable 2-step verification in the settings.</p>
                                </div>

                                <a class="btn btn-primary" href="account-settings.html#twoStepVerificationSection">Enable now</a>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- End Col -->

                    <div class="col-lg-8">
                        <!-- Card -->
                        <div class="card card-centered mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Activity stream</h4>

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
                            <div class="card-body card-body-height">
                                <img class="avatar avatar-xxl mb-3" src="{{asset('assets/svg/illustrations/oc-error.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xxl mb-3" src="{{asset('assets/svg/illustrations-light/oc-error.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">
                                <p class="card-text">No data to show</p>
                                <a class="btn btn-white btn-sm" href="user-profile-my-profile.html#">Start your Activity</a>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card card-centered mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Projects</h4>

                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="projectReportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="projectReportDropdown">
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
                            <div class="card-body card-body-height card-body-centered">
                                <img class="avatar avatar-xxl mb-3" src="{{asset('assets/svg/illustrations/oc-error.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xxl mb-3" src="{{asset('assets/svg/illustrations-light/oc-error.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">
                                <p class="card-text">No data to show</p>
                                <a class="btn btn-white btn-sm" href="projects.html">Start your Projects</a>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- End Col -->
                </div>
                </form>
                <!-- End Row -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->

    <!-- Footer -->

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
        function save_all_cheng(){
            let form=document.querySelector('.course-update');
            submitFormAsync(form).then(response => {
                if (response.success) {
                    showSuccessToast('Изменения сохранены!')
                } else {
                  showErrorToast('Что-то пошло не так.');
                 }
            });
        }
    </script>

@endsection
