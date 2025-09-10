@extends('layouts.teacher')


@section('content-main')

@if($courses->isEmpty())

    <div class="content container-fluid">
        <div class="row justify-content-sm-center text-center py-10">
            <div class="col-sm-7 col-md-5">
                <img class="img-fluid mb-5" src="{{asset('assets/svg/illustrations/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                <img class="img-fluid mb-5" src="{{asset('assets/svg/illustrations-light/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">

                <h1>Здравствуй, ты ещё не создал курс!</h1>
                <p>Нажми на кнопку, чтобы создать курс.</p>

                <a class="btn btn-primary" href="{{route('teacher.course.create')}}">Создайте первый курс</a>
            </div>
        </div>
    </div>
@else
        <!-- Content -->
        <div class="content container-fluid" style="margin-bottom: 0px;">
            <!-- Page Header -->
            <div class="page-header" style="margin-bottom: 0px;">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">


                        <h1 class="page-header-title">Панель управления</h1>
                    </div>
                    <!-- End Col -->

                    <div class="col-lg-auto">
                        <span class="text-cap small">Ученики:</span>

                        <div class="d-flex">
                            <!-- Avatar Group -->
                            <div class="avatar-group avatar-circle me-3">
                                <a class="avatar" href="user-profile.html" data-bs-toggle="tooltip" data-bs-placement="top" title="Amanda Harvey">
                                    <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="user-profile.html" data-bs-toggle="tooltip" data-bs-placement="top" title="Linda Bates">
                                    <img class="avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-info" href="user-profile.html" data-bs-toggle="tooltip" data-bs-placement="top" title="#digitalmarketing">
                  <span class="avatar-initials">
                    <i class="bi-people-fill"></i>
                  </span>
                                </a>
                                <a class="avatar" href="user-profile.html" data-bs-toggle="tooltip" data-bs-placement="top" title="David Harrison">
                                    <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="user-profile.html" data-bs-toggle="tooltip" data-bs-placement="top" title="Antony Taylor">
                                    <span class="avatar-initials">A</span>
                                </a>

                                <a class="avatar avatar-light avatar-circle" href="javascript:;" data-bs-toggle="modal" data-bs-target="#shareWithPeopleModal">
                                    <span class="avatar-initials">+2</span>
                                </a>
                            </div>
                            <!-- End Avatar Group -->

                            <a class="btn btn-primary btn-icon rounded-circle" href="javascript:;" data-bs-toggle="modal" data-bs-target="#shareWithPeopleModal">
                                <i class="bi-share-fill"></i>
                            </a>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
            </div>
            <!-- End Page Header -->
        </div>
        <!-- End Content -->

        <div class="row g-4 mb-4 mx-3 mt-0"> <!-- mx-2 для боковых отступов, mt-0 для верхнего -->
            <div class="col-md-3">
                <div class="card shadow-sm border-1">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded me-3">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted">Всего курсов</h6>
                            <h4 class="fw-bold mb-0">{{$courses->count()}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-1">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded me-3">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted">Ученики</h6>
                            <h4 class="fw-bold mb-0">{{$students->count()}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-1">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded me-3">
                            <i class="bi bi-ui-checks fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted">Тесты</h6>
                            <h4 class="fw-bold mb-0">42</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-1">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 text-info p-3 rounded me-3">
                            <i class="bi bi-award fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted">Сертификаты</h6>
                            <h4 class="fw-bold mb-0">{{$totalCertificate}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 justify-content-start" style="margin-left: 25px;">
            @foreach($courses as $course)
                <div class="col-12 col-md-4"> <!-- на мобильных 1 в ряд, на планшете и выше 3 в ряд -->
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex mb-3 align-items-center">
                                <div class="me-2">
                                    <h4 class="text-wrap">{{ $course->topic }}</h4>

                                    <!-- Avatar Group -->
                                    <div class="avatar-group avatar-group-sm">
                                        @foreach($course->students->take(4) as $student)
                                            <span class="avatar avatar-circle">
                                        <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                                    </span>
                                        @endforeach
                                        <span class="fs-6 ms-2">{{ $course->students->count() }}</span>
                                    </div>
                                </div>

                                <div class="ms-auto">
                                    <!-- Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown">
                                            <i class="bi-three-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{route('teacher.course.edit',['id'=>$course->id])}}"><i class="bi-pencil dropdown-item-icon"></i> Изменить</a>
                                            <a class="dropdown-item" href="#"><i class="bi-star dropdown-item-icon"></i> Favorite</a>
                                            <a class="dropdown-item" href="#"><i class="bi-archive dropdown-item-icon"></i> Archive</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#"><i class="bi-trash dropdown-item-icon"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="row mb-3 text-center">
                                <div class="col">
                                    <div class="text-center">
                                        <span class="d-block h4 mb-1">{{$course->students->count()}}</span>
                                        <span class="d-block fs-6">Ученики</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-center">
                                        <span class="d-block h4 mb-1">0</span>
                                        <span class="d-block fs-6">Учащийся</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-center">
                                        <span class="d-block h4 mb-1">0</span>
                                        <span class="d-block fs-6">Выпускники</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress -->
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


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
                        <th>Курс</th>
                        <th>Пройдено на</th>
                        <th>Дата поступление</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($students as $student)
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
                            <span class="d-block h5 mb-0">{{$student->name_course}}</span>
                        </td>
                        <td>{{$student->pivot->complete}}</td>

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

@endif
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
