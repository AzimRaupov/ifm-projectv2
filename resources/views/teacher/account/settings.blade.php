
@extends('layouts.teacher')

@section('new')
    new HSFileAttach('.js-file-attach')

@endsection

@section('content-main')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Account</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Настройка</h1>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{route('profile.edit',['id'=>$user->id])}}">
                        <i class="bi-person-fill me-1"></i> Мой профиль
                    </a>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-3">
                <!-- Navbar -->
                <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
                    <!-- Navbar Toggle -->
                    <!-- Navbar Toggle -->
                    <div class="d-grid">
                        <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="text-dark">Menu</span>

                  <span class="navbar-toggler-default">
                    <i class="bi-list"></i>
                  </span>

                  <span class="navbar-toggler-toggled">
                    <i class="bi-x"></i>
                  </span>
                </span>
                        </button>
                    </div>
                    <!-- End Navbar Toggle -->
                    <!-- End Navbar Toggle -->

                    <!-- Navbar Collapse -->
                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <ul id="navbarSettings" class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical" data-hs-sticky-block-options='{
                     "parentSelector": "#navbarVerticalNavMenu",
                     "targetSelector": "#header",
                     "breakpoint": "lg",
                     "startPoint": "#navbarVerticalNavMenu",
                     "endPoint": "#stickyBlockEndPoint",
                     "stickyOffsetTop": 20
                   }'>
                            <li class="nav-item">
                                <a class="nav-link active" href="#content">
                                    <i class="bi-person nav-icon"></i> Основная информация
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#passwordSection">
                                    <i class="bi-key nav-icon"></i> Пароль
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#preferencesSection">
                                    <i class="bi-gear nav-icon"></i> Язык
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#deleteAccountSection">
                                    <i class="bi-trash nav-icon"></i> Удалить аккаунт
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Navbar Collapse -->
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-lg-9">
                <div class="d-grid gap-3 gap-lg-5">
                    <!-- Card -->
                    <form action="{{route('account.updateBasic')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="card">
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
                            <!-- End Profile Cover -->



                            <label class="avatar avatar-xxl avatar avatar-soft-primary avatar-circle avatar-uploader profile-cover-avatar" for="editAvatarUploaderModal">
                                @if(isset($user->photo) && $user->photo)
                                    <img id="editAvatarImgModal" class="avatar-img"
                                         src="{{ asset('storage/' . $user->photo) }}"
                                         alt="Фото профиля пользователя {{ $user->name }}">
                                @else
                                    <span class="avatar-initials avatar-soft-primary">{{ mb_substr($user->name, 0, 1) }}</span>

                                @endif

                                <input type="file" class="js-file-attach avatar-uploader-input"  name="photo" id="editAvatarUploaderModal" data-hs-file-attach-options='{
                            "textTarget": "#editAvatarImgModal",
                            "mode": "image",
                            "targetAttr": "src",
                            "maxFileSize": 55145728,
                            "allowTypes": [".png", ".jpeg", ".jpg"]
                         }'>

                                <span class="avatar-uploader-trigger">
                  <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                </span>
                            </label>
                            <!-- End Avatar -->


                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">Основная информация</h2>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Имя</label>


                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" id="emailLabel" placeholder="Email" aria-label="Email" value="{{$user->name}}">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="emailLabel" class="col-sm-3 col-form-label form-label">Эл.Почта</label>

                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" id="emailLabel" placeholder="Email" aria-label="Email" value="{{$user->email}}">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="phoneLabel" class="col-sm-3 col-form-label form-label">Биография</label>

                                    <div class="col-sm-9">
                                        <textarea name="bio" class="form-control">{{$user->bio}}</textarea>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->
                    </form>


                    <!-- Card -->
                    <div id="passwordSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Изменить пароль</h4>
                        </div>

                        <!-- Body -->
                        <form action="{{route('account.updatePass')}}" method="post">
                            @csrf

                            <div class="card-body">
                                <!-- Form -->
                                @csrf

                                <!-- Current Password -->
                                <div class="row mb-4">
                                    <label for="currentPasswordLabel" class="col-sm-3 col-form-label form-label">Текущий пароль</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control @error('currentPassword') is-invalid @enderror"
                                               name="currentPassword" id="currentPasswordLabel" placeholder="Введите текущий пароль">
                                        @error('currentPassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div class="row mb-4">
                                    <label for="newPassword" class="col-sm-3 col-form-label form-label">Новый пароль</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control @error('newPassword') is-invalid @enderror"
                                               name="newPassword" id="newPassword" placeholder="Введите новый пароль">
                                        @error('newPassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="row mb-4">
                                    <label for="newPassword_confirmation" class="col-sm-3 col-form-label form-label">Повторите новый пароль</label>
                                    <div class="col-sm-9">
                                        <div class="mb-3">
                                            <input type="password" class="form-control @error('newPassword_confirmation') is-invalid @enderror"
                                                   name="newPassword_confirmation" id="newPassword_confirmation" placeholder="Повторите новый пароль">
                                            @error('newPassword_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <h5>Требования к паролю:</h5>
                                        <p class="fs-6 mb-2">Убедитесь, что выполнены следующие требования:</p>
                                        <ul class="fs-6">
                                            <li>Минимальная длина — 8 символов</li>
                                            <li>Хотя бы одна цифра, символ или пробел</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                                <!-- End Form -->
                            </div>
                        </form>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="preferencesSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Язык</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form action="" method="post">
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="languageLabel" class="col-sm-3 col-form-label form-label">Language</label>

                                    <div class="col-sm-9">
                                        <!-- Select -->
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" id="languageLabel" data-hs-tom-select-options='{
                                  "searchInDropdown": false
                                }'>
                                                <option label="empty"></option>
                                                <option value="language1" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Image description" width="16"/><span>English (US)</span></span>'>English (US)</option>
                                                <option value="language2" selected="" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/gb.svg" alt="Image description" width="16"/><span>English (UK)</span></span>'>English (UK)</option>
                                                <option value="language3" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/de.svg" alt="Image description" width="16"/><span>Deutsch</span></span>'>Deutsch</option>
                                                <option value="language4" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/dk.svg" alt="Image description" width="16"/><span>Dansk</span></span>'>Dansk</option>
                                                <option value="language5" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/es.svg" alt="Image description" width="16"/><span>Español</span></span>'>Español</option>
                                                <option value="language6" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/nl.svg" alt="Image description" width="16"/><span>Nederlands</span></span>'>Nederlands</option>
                                                <option value="language7" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/it.svg" alt="Image description" width="16"/><span>Italiano</span></span>'>Italiano</option>
                                                <option value="language8" data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="./assets/vendor/flag-icon-css/flags/1x1/cn.svg" alt="Image description" width="16"/><span>中文 (繁體)</span></span>'>中文 (繁體)</option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Time zone</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="currentPassword" id="timeZoneLabel" placeholder="Your time zone" aria-label="Your time zone" value="GMT+01:00" readonly="">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form Switch -->
                                <label class="row form-check form-switch mb-4" for="accounrSettingsPreferencesSwitch1">
                    <span class="col-8 col-sm-9 ms-0">
                      <span class="d-block text-dark">Early release</span>
                      <span class="d-block fs-5">Get included on early releases for new Front features.</span>
                    </span>
                                    <span class="col-4 col-sm-3 text-end">
                      <input type="checkbox" class="form-check-input" id="accounrSettingsPreferencesSwitch1">
                    </span>
                                </label>
                                <!-- End Form Switch -->

                                <!-- Form Switch -->
                                <label class="row form-check form-switch mb-4" for="accounrSettingsPreferencesSwitch2">
                    <span class="col-8 col-sm-9 ms-0">
                      <span class="d-block text-dark mb-1">See info about people who view my profile</span>
                      <span class="d-block fs-5 text-muted"><a class="link" href="#">More about viewer info</a>.</span>
                    </span>
                                    <span class="col-4 col-sm-3 text-end">
                      <input type="checkbox" class="form-check-input" id="accounrSettingsPreferencesSwitch2" checked="">
                    </span>
                                </label>
                                <!-- End Form Switch -->

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->




                    <!-- End Card -->

                    <!-- Card -->
                    <div id="deleteAccountSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Удалить свою учетную запись</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <form action="{{route('account.deleteAcc')}}" method="post">
                                @csrf
                                <p class="card-text">При удалении учётной записи вы теряете доступ к сервисам Ai-PathFinder, а ваши персональные данные удаляются безвозвратно</p>
                                <div class="mb-4">
                                    <!-- Form Check -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="confirm" id="deleteAccountCheckbox" value="1">
                                        <label class="form-check-label" for="deleteAccountCheckbox">
                                            Подтвердите, что я хочу удалить свою учетную запись.                                    </label>
                                    </div>
                                    <!-- End Form Check -->
                                </div>

                                <div class="d-flex justify-content-end gap-3">
                                    <button type="submit" class="btn btn-danger">Удалть</button>
                                </div>
                            </form>
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection


@section('script')

    <script>
        (function() {
            window.onload = function () {


                // INITIALIZATION OF NAVBAR VERTICAL ASIDE
                // =======================================================
                new HSSideNav('.js-navbar-vertical-aside').init()


                // INITIALIZATION OF FORM SEARCH
                // =======================================================
                new HSFormSearch('.js-form-search')


                // INITIALIZATION OF BOOTSTRAP DROPDOWN
                // =======================================================
                HSBsDropdown.init()


                // INITIALIZATION OF SELECT
                // =======================================================
                HSCore.components.HSTomSelect.init('.js-select')


                // INITIALIZATION OF INPUT MASK
                // =======================================================
                HSCore.components.HSMask.init('.js-input-mask')


                // INITIALIZATION OF FILE ATTACHMENT
                // =======================================================
                new HSFileAttach('.js-file-attach')


                // INITIALIZATION OF STICKY BLOCKS
                // =======================================================
                new HSStickyBlock('.js-sticky-block', {
                    targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
                })


                // SCROLLSPY
                // =======================================================
                new bootstrap.ScrollSpy(document.body, {
                    target: '#navbarSettings',
                    offset: 100
                })

                new HSScrollspy('#navbarVerticalNavMenu', {
                    breakpoint: 'lg',
                    scrollOffset: -20
                })
            }
        })()
    </script>

@endsection
