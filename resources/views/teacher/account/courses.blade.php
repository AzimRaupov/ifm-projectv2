@extends('layouts.teacher')



@section('content-main')
    <!-- Content -->
    <div class="content container-fluid">
        <div class="row justify-content-lg-center">
            <div class="col-lg-10">
                <!-- Profile Cover -->
                <div class="profile-cover">
                    <div class="profile-cover-img-wrapper">
                        <img class="profile-cover-img" src="{{asset('assets/img/1920x400/img1.jpg')}}" alt="Image Description">
                    </div>
                </div>

                <!-- Profile Header -->
                <div class="text-center mb-5">
                    <!-- Avatar -->
                    <div class="avatar avatar-xxl avatar-soft-primary avatar-circle profile-cover-avatar">
                        @if(isset($user->photo) && $user->photo)
                            <img id="editAvatarImgModal" class="avatar-img"
                                 src="{{ asset('storage/' . $user->photo) }}"
                                 alt="Фото профиля пользователя {{ $user->name }}">
                        @else
                            <span class="avatar-initials">{{ mb_substr($user->name, 0, 1) }}</span>

                        @endif
                        <span class="avatar-status avatar-status-success"></span>
                    </div>


                    <h1 class="page-header-title">{{$user->name}}</h1>

                    <!-- List -->
                    <ul class="list-inline list-px-2">
                        <li class="list-inline-item">
                            <i class="bi-person-badge me-1"></i>
                            <span>Учитель</span>
                        </li>
                    </ul>

                </div>

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
                            <a class="nav-link" href="{{route('profile.edit',['id'=>$user->id])}}">Профиль</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('profile.courses',['id'=>$user->id])}}">Курсы</a>
                        </li>


                    </ul>
                </div>
                <!-- End Nav -->

                <!-- Filter -->
                <div class="row align-items-center mb-5">
                    <div class="col">
                        <h3 class="mb-0">{{$courses->count()}} Курса</h3>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                        <!-- Nav -->
                        <ul class="nav nav-segment" id="projectsTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="grid-tab" data-bs-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="true" title="Column view">
                                    <i class="bi-grid"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false" title="List view">
                                    <i class="bi-view-list"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- End Nav -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Filter -->

                <!-- Tab Content -->
                <div class="tab-content" id="projectsTabContent">
                    <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                        <div class="row row-cols-1 row-cols-md-2">

                            @foreach($courses as $course)
                                <div class="col mb-3 mb-lg-5">
                                    <!-- Card -->
                                    <div class="card card-hover-shadow text-center h-100">
                                        <div class="card-progress-wrap">
                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->
                                        </div>

                                        <!-- Body -->
                                        <div class="card-body">

                                            <div class="d-flex justify-content-center mb-2">
                                                <!-- Avatar -->
                                                <img class="avatar avatar-lg" src="{{$course->logo}}" alt="Image Description">
                                            </div>

                                            <div class="mb-4">
                                                <h2 class="mb-1">{{$course->topic}}</h2>
                                            </div>

                                            <small class="card-subtitle">Участники</small>

                                            <div class="d-flex justify-content-center">
                                                <!-- Avatar Group -->
                                                <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                    @foreach($course->students as $student)
                                                        <a class="avatar avatar-soft-primary" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $student->name }}">
                                                            @if(isset($student->photo) && $student->photo)
                                                                <img class="avatar-img" src="{{ asset('storage/' . $student->photo) }}" alt="Фото профиля пользователя {{ $student->name }}">
                                                            @else
                                                                <span class="avatar-initials">{{ mb_substr($student->name, 0, 1) }}</span>
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                </div>
                                                <!-- End Avatar Group -->
                                            </div>

                                            <a class="stretched-link" href="{{route('course.subscribe',['id'=>$course->id])}}"></a>
                                        </div>
                                        <!-- End Body -->

                                        <!-- Footer -->
                                        <div class="card-footer">
                                            <!-- Stats -->
                                            <div class="row col-divider">
                                                <div class="col">
                                                    <span class="h4">{{ $course->total_students }}</span>
                                                    <span class="d-block fs-5">Все</span>
                                                </div>

                                                <div class="col">
                                                    <span class="h4">{{ $course->inactive_students }}</span>
                                                    <span class="d-block fs-5">Учащийся</span>
                                                </div>

                                                <div class="col">
                                                    <span class="h4">{{ $course->active_students }}</span>
                                                    <span class="d-block fs-5">Выпускники</span>
                                                </div>
                                            </div>
                                            <!-- End Stats -->
                                        </div>
                                        <!-- End Footer -->
                                    </div>
                                    <!-- End Card -->
                                </div>
                            @endforeach

                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <div class="row row-cols-1">
                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 me-3 me-lg-4">
                                            <img class="avatar" src="assets/svg/brands/google-webdev-icon.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-secondary text-secondary p-2 mb-2">To do</span>

                                                    <h3 class="mb-1">Webdev</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                                                            <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                                                            <span class="avatar-initials">B</span>
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Adam Keep">
                                                            <span class="avatar-initials">A</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown1">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">2 hours ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">19</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">33</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">10</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 me-3 me-lg-4">
                                            <img class="avatar" src="assets/svg/brands/spec-icon.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                                                    <h3 class="mb-1">Get a complete store audit</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ella Lauda">
                                                            <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-info" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sara Iwens">
                                                            <span class="avatar-initials">S</span>
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                                                            <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                                                            <span class="avatar-initials">+5</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown2">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">1 day ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">4</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">8</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">18</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 me-3 me-lg-4">
                                            <img class="avatar" src="assets/svg/brands/capsule-icon.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-success text-success p-2 mb-2">Completed</span>

                                                    <h3 class="mb-1">Build stronger customer relationships</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                                                            <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="David Harrison">
                                                            <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Zack Ins">
                                                            <span class="avatar-initials">Z</span>
                                                        </a>
                                                        <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Lewis Clarke, Chris Mathew and 3 more">
                                                            <span class="avatar-initials">+5</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown3" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown3">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">1 day ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">7</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">7</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">0</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 me-3 me-lg-4">
                                            <img class="avatar" src="assets/svg/brands/prosperops-icon.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                                                    <h3 class="mb-1">Cloud computing</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Finch Hoot">
                                                            <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Bob Bardly">
                                                            <span class="avatar-initials">B</span>
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Linda Bates">
                                                            <img class="avatar-img" src="assets/img/160x160/img8.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Ella Lauda">
                                                            <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown4" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown4">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">2 hours ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">4</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">8</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">30</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 me-3 me-lg-4">
                                            <img class="avatar" src="assets/svg/brands/mailchimp-icon.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                                                    <h3 class="mb-1">Update subscription method</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                                                            <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Adam Keep">
                                                            <span class="avatar-initials">A</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown5" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown5">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">2 days ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">25</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">30</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">20</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 59%" aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <span class="avatar avatar-soft-info avatar-circle me-3 me-lg-4">
                        <span class="avatar-initials">I</span>
                      </span>
                                        <!-- End Avatar -->

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-secondary text-secondary p-2 mb-2">To do</span>

                                                    <h3 class="mb-1">Improve social banners</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                                                            <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Sam Kart">
                                                            <img class="avatar-img" src="assets/img/160x160/img4.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-primary" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Daniel Cs.">
                                                            <span class="avatar-initials">D</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown6" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown6">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">1 week ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">9</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">16</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">21</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 me-3 me-lg-4">
                                            <img class="avatar" src="assets/svg/brands/figma-icon.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-success text-success p-2 mb-2">Completed</span>

                                                    <h3 class="mb-1">Create a new theme</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Costa Quinn">
                                                            <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Clarice Boone">
                                                            <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-dark" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Zack Ins">
                                                            <span class="avatar-initials">Z</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown7" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown7">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">1 week ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">7</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">7</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">0</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                            <div class="col mb-3 mb-lg-5">
                                <!-- Card -->
                                <div class="card card-body">
                                    <div class="d-flex">
                                        <!-- Avatar -->
                                        <span class="avatar avatar-soft-dark avatar-circle me-3 me-lg-4">
                        <span class="avatar-initials">N</span>
                      </span>
                                        <!-- End Avatar -->

                                        <div class="flex-grow-1 ms-3">
                                            <div class="row align-items-sm-center">
                                                <div class="col">
                                                    <span class="badge bg-soft-primary text-primary p-2 mb-2">In progress</span>

                                                    <h3 class="mb-1">Notifications</h3>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="avatar avatar-soft-danger" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Teresa Eyker">
                                                            <span class="avatar-initials">T</span>
                                                        </a>
                                                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                                                            <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                                                        </a>
                                                        <a class="avatar avatar-soft-warning" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Olivier L.">
                                                            <span class="avatar-initials">O</span>
                                                        </a>
                                                        <a class="avatar avatar-light avatar-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Brian Halligan, Rachel Doe and 7 more">
                                                            <span class="avatar-initials">+9</span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <div class="col-auto">
                                                    <!-- Dropdown -->
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown8" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi-three-dots-vertical"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown8">
                                                            <a class="dropdown-item" href="#">Rename project </a>
                                                            <a class="dropdown-item" href="#">Add to favorites</a>
                                                            <a class="dropdown-item" href="#">Archive project</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Unfold -->
                                                </div>
                                            </div>
                                            <!-- End Row -->

                                            <!-- Stats -->
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="fs-5">Updated:</span>
                                                    <span class="fw-semibold text-dark">1 week ago</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Tasks:</span>
                                                    <span class="fw-semibold text-dark">9</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Completed:</span>
                                                    <span class="fw-semibold text-dark">16</span>
                                                </li>

                                                <li class="list-inline-item">
                                                    <span class="fs-5">Days left:</span>
                                                    <span class="fw-semibold text-dark">21</span>
                                                </li>
                                            </ul>
                                            <!-- End Stats -->

                                            <!-- Progress -->
                                            <div class="progress card-progress">
                                                <div class="progress-bar" role="progressbar" style="width: 77%" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <!-- End Progress -->

                                            <a class="stretched-link" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Tab Content -->
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
