<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Регистрация</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <!-- Font -->
    {{--    <link href="../../css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">--}}

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor.min.css')}}">

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('assets/css/theme.min.css')}}?v=1.0">

    <link rel="preload" href="{{asset('assets/css/theme.min-1.css')}}" data-hs-appearance="default" as="style">
    <link rel="preload" href="{{asset('assets/css/theme-dark.min.css')}}" data-hs-appearance="dark" as="style">

    <style data-hs-appearance-onload-styles="">

        *
        {
            transition: unset !important;
        }

        body
        {
            opacity: 0;
        }
    </style>

    <script>
        window.hs_config = {"autopath":"@@autopath","deleteLine":"hs-builder:delete","deleteLine:build":"hs-builder:build-delete","deleteLine:dist":"hs-builder:dist-delete","previewMode":false,"startPath":"/index.html","vars":{"themeFont":"https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap","version":"?v=1.0"},"layoutBuilder":{"extend":{"switcherSupport":true},"header":{"layoutMode":"default","containerMode":"container-fluid"},"sidebarLayout":"default"},"themeAppearance":{"layoutSkin":"default","sidebarSkin":"default","styles":{"colors":{"primary":"#377dff","transparent":"transparent","white":"#fff","dark":"132144","gray":{"100":"#f9fafc","900":"#1e2022"}},"font":"Inter"}},"languageDirection":{"lang":"ru"},"skipFilesFromBundle":{"dist":["assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","assets/js/demo.js"],"build":["assets/css/theme.css","assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js","assets/js/demo.js","assets/css/theme-dark.css","assets/css/docs.css","assets/vendor/icon-set/style.css","assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js","assets/js/demo.js"]},"minifyCSSFiles":["assets/css/theme.css","assets/css/theme-dark.css"],"copyDependencies":{"dist":{"*assets/js/theme-custom.js":""},"build":{"*assets/js/theme-custom.js":"","node_modules/bootstrap-icons/font/*fonts/**":"assets/css"}},"buildFolder":"","replacePathsToCDN":{},"directoryNames":{"src":"./src","dist":"./dist","build":"./build"},"fileNames":{"dist":{"js":"theme.min.js","css":"theme.min.css"},"build":{"css":"theme.min.css","js":"theme.min.js","vendorCSS":"vendor.min.css","vendorJS":"vendor.min.js"}},"fileTypes":"jpg|png|svg|mp4|webm|ogv|json"}
    </script>
</head>

<body>

<script src="{{asset('assets/js/hs.theme-appearance.js')}}"></script>

<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main" class="main">
    <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url({{asset('assets/svg/components/card-6.svg')}});">
        <!-- Shape -->
        <div class="shape shape-bottom zi-1">
            <svg preserveaspectratio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewbox="0 0 1921 273">
                <polygon fill="#fff" points="0,273 1921,273 1921,0 "></polygon>
            </svg>
        </div>
        <!-- End Shape -->
    </div>

    <!-- Content -->
    <div class="container py-5 py-sm-7">
        <a class="d-flex justify-content-center mb-5" href="index.html">
            <img class="zi-2" src="{{asset('assets/svg/logos/logo.svg')}}" alt="Image Description" style="width: 8rem;">
        </a>

        <div class="mx-auto" style="max-width: 30rem;">
            <!-- Card -->
            <div class="card card-lg mb-5">
                <div class="card-body">
                    <!-- Form -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="js-validate needs-validation" novalidate="" action="{{route('register')}}" method="post">
                        @csrf
                        <div class="text-center">
                            <div class="mb-5">
                                <h1 class="display-5">Регистрация аккаунта</h1>
                                <p>У вас есть аккаунт? <a class="link" href="">Войти</a></p>
                            </div>

                            <div class="d-grid mb-4">
                                <a class="btn btn-white btn-lg" href="#">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <img class="avatar avatar-xss me-2" src="{{asset('assets/svg/brands/google-icon.svg')}}" alt="Image Description">
                                        Зарегистрироваться с помощью Google
                                    </span>
                                </a>
                            </div>

                            <span class="divider-center text-muted mb-4">Или</span>
                        </div>

                        <label class="form-label" for="fullNameSrEmail">Полное имя</label>

                        <!-- Form -->
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Form -->
                                <div class="mb-4">
                                    <input type="text" class="form-control form-control-lg" name="name" id="fullNameSrEmail" placeholder="Мария" aria-label="Мария" required="">
                                    <span class="invalid-feedback">Пожалуйста, введите ваше имя</span>
                                </div>
                                <!-- End Form -->
                            </div>

                            <div class="col-sm-6">
                                <!-- Form -->
                                <div class="mb-4">
                                    <input type="number" class="form-control form-control-lg" placeholder="Возраст" aria-label="18" required="" name="old">
                                    <span class="invalid-feedback">Пожалуйста, введите свой возраст</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Form -->
                        <label class="form-label" for="fullNameSrEmail">Электронная почта</label>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <input type="email" class="form-control form-control-lg" name="email" id="signupSrEmail" placeholder="example@site.com" aria-label="example@site.com" required="">
                                    <span class="invalid-feedback">Пожалуйста, введите свою почту</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <select name="user_type" class="form-select">
                                        <option value="student">Студент</option>
                                        <option value="schoolboy">Школьник</option>
                                        <option value="worker">Рабочий</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="mb-4">
                            <label class="form-label" for="signupSrPassword">Пароль</label>
                            <div class="input-group input-group-merge" data-hs-validation-validate-class="">
                                <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="8+ символов" aria-label="8+ символов" required="" minlength="8" data-hs-toggle-password-options='{
                           "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                           "defaultClass": "bi-eye-slash",
                           "showClass": "bi-eye",
                           "classChangeTarget": ".js-toggle-password-show-icon-1"
                         }'>
                                <a class="js-toggle-password-target-1 input-group-append input-group-text" href="javascript:;">
                                    <i class="js-toggle-password-show-icon-1 bi-eye"></i>
                                </a>
                            </div>
                            <span class="invalid-feedback">Пароль слишком слабый, пожалуйста, выберите другой.</span>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="mb-4">
                            <label class="form-label" for="signupSrConfirmPassword">Повторите пароль</label>
                            <div class="input-group input-group-merge" data-hs-validation-validate-class="">
                                <input type="password" class="js-toggle-password form-control form-control-lg" name="password_confirmation" id="signupSrConfirmPassword" placeholder="8+ символов" aria-label="8+ символов" required="" minlength="8" data-hs-toggle-password-options='{
                           "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                           "defaultClass": "bi-eye-slash",
                           "showClass": "bi-eye",
                           "classChangeTarget": ".js-toggle-password-show-icon-2"
                         }'>
                                <a class="js-toggle-password-target-2 input-group-append input-group-text" href="javascript:;">
                                    <i class="js-toggle-password-show-icon-2 bi-eye"></i>
                                </a>
                            </div>
                            <span class="invalid-feedback">Пароли не совпадают</span>
                        </div>
                        <!-- End Form -->

                        <!-- Form Check -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="termsCheckbox" required="">
                            <label class="form-check-label" for="termsCheckbox">
                                Я принимаю <a href="#">условия и положения</a>
                            </label>
                            <span class="invalid-feedback">Пожалуйста, примите условия и положения.</span>
                        </div>
                        <!-- End Form Check -->

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Зарегистрироваться</button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
            <!-- End Card -->

            <!-- Footer -->
            <div class="position-relative text-center zi-1">
                <small class="text-cap text-body mb-4">Доверяют лучшие команды мира</small>

                <div class="w-85 mx-auto">
                    <div class="row justify-content-between">
                        <div class="col">
                            <img class="img-fluid" src="{{asset('assets/svg/brands/gitlab-gray.svg')}}" alt="Logo">
                        </div>
                        <!-- End Col -->

                        <div class="col">
                            <img class="img-fluid" src="{{asset('assets/svg/brands/fitbit-gray.svg')}}" alt="Logo">
                        </div>
                        <!-- End Col -->

                        <div class="col">
                            <img class="img-fluid" src="{{asset('assets/svg/brands/flow-xo-gray.svg')}}" alt="Logo">
                        </div>
                        <!-- End Col -->

                        <div class="col">
                            <img class="img-fluid" src="{{asset('assets/svg/brands/layar-gray.svg')}}" alt="Logo">
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>
    <!-- End Content -->
</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- JS Implementing Plugins -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>

<!-- JS Front -->
<script src="{{asset('assets/js/theme.min.js')}}"></script>

<!-- JS Plugins Init. -->
{{--<script>--}}
{{--    (function() {--}}
{{--        window.onload = function () {--}}
{{--            // INITIALIZATION OF BOOTSTRAP VALIDATION--}}
{{--            // =======================================================--}}
{{--            HSBsValidation.init('.js-validate', {--}}
{{--                onSubmit: data => {--}}
{{--                    data.event.preventDefault()--}}
{{--                    alert('Submited')--}}
{{--                }--}}
{{--            })--}}

{{--            // INITIALIZATION OF TOGGLE PASSWORD--}}
{{--            // =======================================================--}}
{{--            new HSTogglePassword('.js-toggle-password')--}}
{{--        }--}}
{{--    })()--}}
{{--</script>--}}
</body>
</html>
