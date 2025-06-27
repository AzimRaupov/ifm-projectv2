@extends('layouts.app')

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

                    <h1 class="page-header-title">Settings</h1>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="user-profile-my-profile.html">
                        <i class="bi-person-fill me-1"></i> My profile
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
                                    <i class="bi-person nav-icon"></i> Basic information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#emailSection">
                                    <i class="bi-at nav-icon"></i> Email
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#passwordSection">
                                    <i class="bi-key nav-icon"></i> Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#preferencesSection">
                                    <i class="bi-gear nav-icon"></i> Preferences
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#twoStepVerificationSection">
                                    <i class="bi-shield-lock nav-icon"></i> Two-step verification
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#recentDevicesSection">
                                    <i class="bi-phone nav-icon"></i> Recent devices
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#notificationsSection">
                                    <i class="bi-bell nav-icon"></i> Notifications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#connectedAccountsSection">
                                    <i class="bi-diagram-3 nav-icon"></i> Connected accounts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#socialAccountsSection">
                                    <i class="bi-instagram nav-icon"></i> Social accounts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#deleteAccountSection">
                                    <i class="bi-trash nav-icon"></i> Delete account
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
                    <div class="card">
                        <!-- Profile Cover -->
                        <div class="profile-cover">
                            <div class="profile-cover-img-wrapper">
                                <img id="profileCoverImg" class="profile-cover-img" src="assets/img/1920x400/img2.jpg" alt="Image Description">


                            </div>
                        </div>
                        <!-- End Profile Cover -->

                        <!-- Avatar -->
                        <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="editAvatarUploaderModal">
                            <img id="editAvatarImgModal" class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">


                        </label>
                        <!-- End Avatar -->


                        <!-- End Body -->
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
                            <form action="{{ route('user.update') }}" method="post">
                                @csrf

                                <!-- Полное имя -->
                                <div class="row mb-4">
                                    <label for="name" class="col-sm-3 col-form-label form-label">
                                        Полное имя
                                        <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Displayed on public forums, such as Front."></i>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Имя" value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="row mb-4">
                                    <label for="email" class="col-sm-3 col-form-label form-label">Эль.почта</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Язык -->
                                <div class="row mb-4">
                                    <label for="lang" class="col-sm-3 col-form-label form-label">Язык</label>
                                    <div class="col-sm-9">
                                        <select class="js-select form-select @error('lang') is-invalid @enderror" id="lang" name="lang">
                                            <option value="tj" {{ old('lang', auth()->user()->lang) == 'tj' ? 'selected' : '' }}>Таджикский</option>
                                            <option value="ru" {{ old('lang', auth()->user()->lang) == 'ru' ? 'selected' : '' }}>Русский</option>
                                            <option value="en" {{ old('lang', auth()->user()->lang) == 'en' ? 'selected' : '' }}>English</option>
                                        </select>
                                        @error('lang')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Роль -->
                                <div class="row mb-4">
                                    <label for="type_user" class="col-sm-3 col-form-label form-label">Роль в жизни</label>
                                    <div class="col-sm-9">
                                        <select class="js-select form-select @error('type_user') is-invalid @enderror" id="type_user" name="type_user">
                                            <option value="schoolboy" {{ old('type_user', auth()->user()->type_user) == 'schoolboy' ? 'selected' : '' }}>Школьник</option>
                                            <option value="student" {{ old('type_user', auth()->user()->type_user) == 'student' ? 'selected' : '' }}>Студент</option>
                                            <option value="worker" {{ old('type_user', auth()->user()->type_user) == 'worker' ? 'selected' : '' }}>Работник</option>
                                        </select>
                                        @error('type_user')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Кнопка -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="emailSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Email</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <p>Your current email address is <span class="fw-semibold">mark@site.com</span></p>

                            <!-- Form -->
                            <form>
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">New email address</label>

                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="Enter new email address" aria-label="Enter new email address">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="passwordSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Change your password</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form id="changePasswordForm">
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="currentPasswordLabel" class="col-sm-3 col-form-label form-label">Current password</label>

                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="currentPassword" id="currentPasswordLabel" placeholder="Enter current password" aria-label="Enter current password">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="newPassword" class="col-sm-3 col-form-label form-label">New password</label>

                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter new password" aria-label="Enter new password">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label form-label">Confirm new password</label>

                                    <div class="col-sm-9">
                                        <div class="mb-3">
                                            <input type="password" class="form-control" name="confirmNewPassword" id="confirmNewPasswordLabel" placeholder="Confirm your new password" aria-label="Confirm your new password">
                                        </div>

                                        <h5>Password requirements:</h5>

                                        <p class="fs-6 mb-2">Ensure that these requirements are met:</p>

                                        <ul class="fs-6">
                                            <li>Minimum 8 characters long - the more, the better</li>
                                            <li>At least one lowercase character</li>
                                            <li>At least one uppercase character</li>
                                            <li>At least one number, symbol, or whitespace character</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="preferencesSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Preferences</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form>
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

                    <!-- Card -->
                    <div id="twoStepVerificationSection" class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0">Two-step verification</h4>
                                <span class="badge bg-soft-danger text-danger ms-2">Disabled</span>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <p class="card-text">Start by entering your password so that we know it's you. Then we'll walk you through two more simple steps.</p>

                            <form>
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="accountPasswordLabel" class="col-sm-3 col-form-label form-label">Account password</label>

                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="currentPassword" id="accountPasswordLabel" placeholder="Enter current password" aria-label="Enter current password">
                                        <small class="form-text">This is the password you use to log in to your Front account.</small>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Set up</button>
                                </div>
                            </form>
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="recentDevicesSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Recent devices</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <p class="card-text">View and manage devices where you're currently logged in.</p>
                        </div>
                        <!-- End Body -->

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>Browser</th>
                                    <th>Device</th>
                                    <th>Location</th>
                                    <th>Most recent activity</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td class="align-items-center">
                                        <img class="avatar avatar-xss me-2" src="assets/svg/brands/chrome-icon.svg" alt="Image Description"> Chrome on Windows
                                    </td>
                                    <td><i class="bi-laptop fs-3 me-2"></i> Dell XPS 15 <span class="badge bg-soft-success text-success ms-1">Current</span></td>
                                    <td>London, UK</td>
                                    <td>Now</td>
                                </tr>

                                <tr>
                                    <td class="align-items-center">
                                        <img class="avatar avatar-xss me-2" src="assets/svg/brands/chrome-icon.svg" alt="Image Description"> Chrome on Android
                                    </td>
                                    <td><i class="bi-phone fs-3 me-2"></i> Google Pixel 3a</td>
                                    <td>London, UK</td>
                                    <td>15, August 2020 15:08</td>
                                </tr>

                                <tr>
                                    <td class="align-items-center">
                                        <img class="avatar avatar-xss me-2" src="assets/svg/brands/chrome-icon.svg" alt="Image Description"> Chrome on Windows
                                    </td>
                                    <td><i class="bi-display fs-3 me-2"></i> Microsoft Studio 2</td>
                                    <td>London, UK</td>
                                    <td>12, August 2020 20:07</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="notificationsSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Notifications</h4>
                        </div>

                        <!-- Alert -->
                        <div class="alert alert-soft-dark card-alert text-center" role="alert">
                            We need permission from your browser to show notifications. <a class="alert-link" href="#">Request permission</a>
                        </div>
                        <!-- End Alert -->

                        <form>
                            <!-- Table -->
                            <div class="table-responsive datatable-custom">
                                <table class="table table-thead-bordered table-nowrap table-align-middle table-first-col-px-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-center">
                                            <div class="mb-1">
                                                <img class="avatar avatar-xs" src="assets/svg/illustrations/oc-email-at.svg" alt="Image Description" data-hs-theme-appearance="default">
                                                <img class="avatar avatar-xs" src="assets/svg/illustrations-light/oc-email-at.svg" alt="Image Description" data-hs-theme-appearance="dark">
                                            </div>
                                            Email
                                        </th>
                                        <th class="text-center">
                                            <div class="mb-1">
                                                <img class="avatar avatar-xs" src="assets/svg/illustrations/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="default">
                                                <img class="avatar avatar-xs" src="assets/svg/illustrations-light/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="dark">
                                            </div>
                                            Browser
                                        </th>
                                        <th class="text-center">
                                            <div class="mb-1">
                                                <img class="avatar avatar-xs" src="assets/svg/illustrations/oc-phone.svg" alt="Image Description" data-hs-theme-appearance="default">
                                                <img class="avatar avatar-xs" src="assets/svg/illustrations-light/oc-phone.svg" alt="Image Description" data-hs-theme-appearance="dark">
                                            </div>
                                            App
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>New for you</td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox1">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox1"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox2">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox2"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox3">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox3"></label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Account activity <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Get important notifications about you or activity you've missed"></i></td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox4">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox4"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox5" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox5"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox6" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox6"></label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>A new browser used to sign in</td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox7" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox7"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox8" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox8"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox9" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox9"></label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>A new device is linked</td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox10">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox10"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox11" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox11"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox12">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox12"></label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>A new device connected <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Email me when a new device connected"></i></td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox13">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox13"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox14" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox14"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="editUserModalAlertsCheckbox15" checked="">
                                                <label class="form-check-label" for="editUserModalAlertsCheckbox15"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                        </form>

                        <hr>

                        <!-- Body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm">
                                    <!-- Form -->
                                    <div class="mb-4">
                                        <p class="card-text">When should we send you notifications?</p>

                                        <!-- Select -->
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" autocomplete="off" data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "width": "15rem",
                                    "hideSearch": true
                                  }'>
                                                <option value="whenToSendNotification1">Always</option>
                                                <option value="whenToSendNotification2">Only when I'm online</option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Col -->

                                <div class="col-sm">
                                    <!-- Form -->
                                    <div class="mb-4">
                                        <p class="card-text">Send me a daily summary ("Daily Digest") of task activity.</p>

                                        <div class="row">
                                            <div class="col-auto mb-2">
                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select" autocomplete="off" data-hs-tom-select-options='{
                                      "searchInDropdown": false,
                                      "hideSearch": true,
                                      "dropdownWidth": "10rem"
                                    }'>
                                                        <option value="EveryDay">Every day</option>
                                                        <option value="weekdays" selected="">Weekdays</option>
                                                        <option value="Never">Never</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                            <!-- End Col -->

                                            <div class="col-auto mb-2">
                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select" autocomplete="off" data-hs-tom-select-options='{
                                      "searchInDropdown": false,
                                      "hideSearch": true,
                                      "dropdownWidth": "10rem"
                                    }'>
                                                        <option value="0">at 12 AM</option>
                                                        <option value="1">at 1 AM</option>
                                                        <option value="2">at 2 AM</option>
                                                        <option value="3">at 3 AM</option>
                                                        <option value="4">at 4 AM</option>
                                                        <option value="5">at 5 AM</option>
                                                        <option value="6">at 6 AM</option>
                                                        <option value="7">at 7 AM</option>
                                                        <option value="8">at 8 AM</option>
                                                        <option value="9" selected="">at 9 AM</option>
                                                        <option value="10">at 10 AM</option>
                                                        <option value="11">at 11 AM</option>
                                                        <option value="12">at 12 PM</option>
                                                        <option value="13">at 1 PM</option>
                                                        <option value="14">at 2 PM</option>
                                                        <option value="15">at 3 PM</option>
                                                        <option value="16">at 4 PM</option>
                                                        <option value="17">at 5 PM</option>
                                                        <option value="18">at 6 PM</option>
                                                        <option value="19">at 7 PM</option>
                                                        <option value="20">at 8 PM</option>
                                                        <option value="21">at 9 PM</option>
                                                        <option value="22">at 10 PM</option>
                                                        <option value="23">at 11 PM</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->

                            <p class="card-text">In order to cut back on noise, email notifications are grouped together and only sent when you're idle or offline.</p>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="connectedAccountsSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Connected accounts</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <p class="card-text">Integrated features from these accounts make it easier to collaborate with people you know on Front Dashboard.</p>

                            <!-- Form -->
                            <form>
                                <div class="list-group list-group-lg list-group-flush list-group-no-gutters">
                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="assets/svg/brands/google-icon.svg" alt="Image Description">
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">Google</h4>
                                                        <p class="fs-5 text-body mb-0">Calendar and contacts</p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-auto">
                                                        <!-- Form Switch -->
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="connectedAccounts1">
                                                            <label class="form-check-label" for="connectedAccounts1"></label>
                                                        </div>
                                                        <!-- End Form Switch -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->

                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="assets/svg/brands/spec-icon.svg" alt="Image Description">
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">Spec</h4>
                                                        <p class="fs-5 text-body mb-0">Project management</p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-auto">
                                                        <!-- Form Switch -->
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="connectedAccounts2">
                                                            <label class="form-check-label" for="connectedAccounts2"></label>
                                                        </div>
                                                        <!-- End Form Switch -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->

                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="assets/svg/brands/slack-icon.svg" alt="Image Description">
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">Slack</h4>
                                                        <p class="fs-5 text-body mb-0">Communication <a class="link" href="#">Learn more</a></p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-auto">
                                                        <!-- Form Switch -->
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="connectedAccounts3" checked="">
                                                            <label class="form-check-label" for="connectedAccounts3"></label>
                                                        </div>
                                                        <!-- End Form Switch -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->

                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="assets/svg/brands/mailchimp-icon.svg" alt="Image Description">
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">Mailchimp</h4>
                                                        <p class="fs-5 text-body mb-0">Email marketing service</p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-auto">
                                                        <!-- Form Switch -->
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="connectedAccounts4" checked="">
                                                            <label class="form-check-label" for="connectedAccounts4"></label>
                                                        </div>
                                                        <!-- End Form Switch -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->

                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="assets/svg/brands/google-webdev-icon.svg" alt="Image Description">
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">Google Webdev</h4>
                                                        <p class="fs-5 text-body mb-0">Tools for Web Developers <a class="link" href="#">Learn more</a></p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-auto">
                                                        <!-- Form Switch -->
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="connectedAccounts5">
                                                            <label class="form-check-label" for="connectedAccounts5"></label>
                                                        </div>
                                                        <!-- End Form Switch -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="socialAccountsSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Social accounts</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <form>
                                <div class="list-group list-group-lg list-group-flush list-group-no-gutters">
                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="bi-twitter list-group-icon"></i>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h4 class="mb-0">Twitter</h4>
                                                        <a class="fs-5" href="#">www.twitter.com/htmlstream</a>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <a class="btn btn-white btn-sm" href="javascript:;">Disconnect</a>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->

                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="bi-facebook list-group-icon"></i>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h4 class="mb-0">Facebook</h4>
                                                        <a class="fs-5" href="#">www.facebook.com/htmlstream</a>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <a class="btn btn-white btn-sm" href="javascript:;">Disconnect</a>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->

                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="bi-slack list-group-icon"></i>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h4 class="mb-0">Slack</h4>
                                                        <p class="fs-5 text-body mb-0">Not connected</p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <a class="btn btn-white btn-sm" href="javascript:;">Connect</a>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->

                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="bi-linkedin list-group-icon"></i>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h4 class="mb-0">Linkedin</h4>
                                                        <a class="fs-5" href="#">www.linkedin.com/htmlstream</a>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <a class="btn btn-white btn-sm" href="javascript:;">Disconnect</a>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->

                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="bi-google list-group-icon"></i>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h4 class="mb-0">Google</h4>
                                                        <p class="fs-5 text-body mb-0">Not connected</p>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <a class="btn btn-white btn-sm" href="javascript:;">Connect</a>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->
                                </div>
                            </form>
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div id="deleteAccountSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Delete your account</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <p class="card-text">When you delete your account, you lose access to Front account services, and we permanently delete your personal data. You can cancel the deletion for 14 days.</p>

                            <div class="mb-4">
                                <!-- Form Check -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="deleteAccountCheckbox">
                                    <label class="form-check-label" for="deleteAccountCheckbox">
                                        Confirm that I want to delete my account.
                                    </label>
                                </div>
                                <!-- End Form Check -->
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a class="btn btn-white" href="#">Learn more</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
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
