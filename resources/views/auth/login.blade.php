<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Вход</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <!-- Font -->

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
<script src="{{asset('js/main.js')}}"></script>
    <script>
        window.hs_config = {"autopath":"@@autopath","deleteLine":"hs-builder:delete","deleteLine:build":"hs-builder:build-delete","deleteLine:dist":"hs-builder:dist-delete","previewMode":false,"startPath":"/index.html","vars":{"themeFont":"https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap","version":"?v=1.0"},"layoutBuilder":{"extend":{"switcherSupport":true},"header":{"layoutMode":"default","containerMode":"container-fluid"},"sidebarLayout":"default"},"themeAppearance":{"layoutSkin":"default","sidebarSkin":"default","styles":{"colors":{"primary":"#377dff","transparent":"transparent","white":"#fff","dark":"132144","gray":{"100":"#f9fafc","900":"#1e2022"}},"font":"Inter"}},"languageDirection":{"lang":"en"},"skipFilesFromBundle":{"dist":["assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","assets/js/demo.js"],"build":["assets/css/theme.css","assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js","assets/js/demo.js","assets/css/theme-dark.css","assets/css/docs.css","assets/vendor/icon-set/style.css","assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js","assets/js/demo.js"]},"minifyCSSFiles":["assets/css/theme.css","assets/css/theme-dark.css"],"copyDependencies":{"dist":{"*assets/js/theme-custom.js":""},"build":{"*assets/js/theme-custom.js":"","node_modules/bootstrap-icons/font/*fonts/**":"assets/css"}},"buildFolder":"","replacePathsToCDN":{},"directoryNames":{"src":"./src","dist":"./dist","build":"./build"},"fileNames":{"dist":{"js":"theme.min.js","css":"theme.min.css"},"build":{"css":"theme.min.css","js":"theme.min.js","vendorCSS":"vendor.min.css","vendorJS":"vendor.min.js"}},"fileTypes":"jpg|png|svg|mp4|webm|ogv|json"}
        window.hs_config.gulpRGBA = (p1) => {
            const options = p1.split(',')
            const hex = options[0].toString()
            const transparent = options[1].toString()

            var c;
            if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                c= hex.substring(1).split('');
                if(c.length== 3){
                    c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c= '0x'+c.join('');
                return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',' + transparent + ')';
            }
            throw new Error('Bad Hex');
        }
        window.hs_config.gulpDarken = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = -parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
        window.hs_config.gulpLighten = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
    </script>
</head>

<body>

<script src="{{asset('assets/js/hs.theme-appearance.js')}}"></script>

<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main" class="main">
    @include('components.my.toas')
    @if ($errors->has('email'))

        <script>
            showErrorToast("{{$errors->first('email')}}")
        </script>

    @endif

    <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url('{{asset('assets/svg/components/card-6.svg')}}');">
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
            <img class="zi-2" src="{{asset('assets/img/logo.png')}}" alt="Image Description" style="width: 8rem;">
        </a>

        <div class="mx-auto" style="max-width: 30rem;">
            <!-- Card -->
            <div class="card card-lg mb-5">
                <div class="card-body">
                    <!-- Form -->
                    <form class="js-validate needs-validation" action="{{route('login')}}" novalidate="" method="POST">
                        @csrf
                        <div class="text-center">
                            <div class="mb-5">
                                <h1 class="display-5">Авторизация</h1>
                                <p>Ещё не создали аккаунт? <a class="link" href="{{route('register')}}">Регистрация</a></p>
                            </div>

                            <div class="d-grid mb-4">
                                <a class="btn btn-white btn-lg" href="{{route('google.auth')}}">
                    <span class="d-flex justify-content-center align-items-center">
                      <img class="avatar avatar-xss me-2" src="{{asset('assets/svg/brands/google-icon.svg')}}" alt="Image Description">
                      Войти через Google
                    </span>
                                </a>
                            </div>

                            <span class="divider-center text-muted mb-4">Или</span>
                        </div>

                        <!-- Form -->
                        <div class="mb-4">
                            <label class="form-label" for="signinSrEmail">Электронная почта</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail" tabindex="1" placeholder="email@address.com" aria-label="email@address.com" required="">
                            <span class="invalid-feedback">Пожалуйста, введите корректный email адрес.</span>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="mb-4">
                            <label class="form-label w-100" for="signupSrPassword" tabindex="0">
                  <span class="d-flex justify-content-between align-items-center">
                    <span>Пароль</span>
                    <a class="form-label-link mb-0" href="authentication-reset-password-basic.html">Забыли пароль?</a>
                  </span>
                            </label>

                            <div class="input-group input-group-merge" data-hs-validation-validate-class="">

                                <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="8+ символов" aria-label="8+ символов" required="" minlength="8" data-hs-toggle-password-options='{
                           "target": "#changePassTarget",
                           "defaultClass": "bi-eye-slash",
                           "showClass": "bi-eye",
                           "classChangeTarget": "#changePassIcon"
                         }'>
                                <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                                    <i id="changePassIcon" class="bi-eye"></i>
                                </a>
                            </div>

                            <span class="invalid-feedback">Пожалуйста, введите корректный пароль.</span>
                        </div>
                        <!-- End Form -->

                        <!-- Form Check -->


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Авторизация</button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
            <!-- End Card -->


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
