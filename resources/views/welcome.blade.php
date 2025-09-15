<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Ai-PathFinder</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/logo.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: iLanding
    * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
    * Updated: Nov 12 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between"  style="    background: rgba(255, 255, 255, 0.2); /* полупрозрачный фон */
    backdrop-filter: blur(10px); /* размытие фона за элементом */
    -webkit-backdrop-filter: blur(10px); /* для Safari */
    border: 1px solid rgba(255, 255, 255, 0.3); /* тонкая граница */
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* легкая тень */">

        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">Ai-PathFinder</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#hero" class="active">Главная</a></li>
                <li><a href="#services">Сервис</a></li>
                <li><a href="#courses">Курсы</a></li>
                <li><a href="#faq">Вопросы</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="{{route('register')}}">Начать сейчас</a>

    </div>
</header>
<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                        <div class="company-badge mb-4">
                            <i class="bi bi-gear-fill me-2"></i>
                            Работаем ради вашего успеха
                        </div>

                        <h1 class="mb-4">
                            Создавайте <br>
                            свою уникальную <br>
                            <span class="accent-text">дорожную карту обучения</span>

                        </h1>

                        <p class="mb-4 mb-md-5">
                            Наша платформа использует искусственный интеллект для создания курсов и дорожных карт обучения. Просто укажите тему, и AI сформирует шаги, материалы и структуру курса за вас.
                        </p>

                        <div class="hero-buttons">
                            <a href="{{route('register')}}" class="btn btn-primary me-0 me-sm-2 mx-1">Создать курс с AI</a>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                        <img src="assets/img/illustration-1.webp" alt="Hero Image" class="img-fluid">

                        <div class="customers-badge">
                            <div class="customer-avatars">

                                @foreach($teachers as $teacher)
                                    @if(isset($teacher->photo) && $teacher->photo)
                                        <img id="editAvatarImgModal" class="avatar avatar-img"
                                             src="{{ asset('storage/' . $teacher->photo) }}"
                                             alt="Фото профиля пользователя {{ $teacher->name }}">
                                    @else
                                        <span class="avatar-initials">{{ mb_substr($teacher->name, 0, 1) }}</span>

                                    @endif
                                @endforeach
                                <span class="avatar more">12+</span>
                            </div>
                            <p class="mb-0 mt-2">Более 12,000 преподавателей и студентов доверяют AI для генерации курсов</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="stat-content">
                            <h4>100+ Тем</h4>
                            <p class="mb-0">AI умеет создавать курсы по любым направлениям</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="stat-content">
                            <h4>20k+ Курсов</h4>
                            <p class="mb-0">Сформировано автоматически для студентов и преподавателей</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div class="stat-content">
                            <h4>500k+ Шагов</h4>
                            <p class="mb-0">Этапы обучения формируются AI на основе целей и навыков</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div class="stat-content">
                            <h4>Автоматическая адаптация</h4>
                            <p class="mb-0">AI подстраивает курсы под уровень и цели каждого пользователя</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- About Section -->

    <!-- Features Section -->

    <!-- Features Cards Section -->


    <section id="services" class="services section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Что делает наша платформа</h2>
            <p>AI автоматически создаёт курсы, материалы и тесты, чтобы вы могли учиться легко и эффективно</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-4">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card d-flex">
                        <div class="icon flex-shrink-0">
                            <i class="bi bi-map"></i>
                        </div>
                        <div>
                            <h3>Генерация дорожных карт</h3>
                            <p>AI создаёт пошаговую дорожную карту обучения по выбранной теме, подбирая оптимальный порядок шагов для усвоения материала.</p>
                            <a href="{{route('register')}}" class="read-more">Подробнее <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card d-flex">
                        <div class="icon flex-shrink-0">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div>
                            <h3>Создание учебных материалов</h3>
                            <p>AI автоматически подбирает и генерирует тексты, изображения и презентации для каждого шага вашего курса.</p>
                            <a href="{{route('register')}}" class="read-more">Подробнее <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card d-flex">
                        <div class="icon flex-shrink-0">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h3>Автоматическая генерация тестов</h3>
                            <p>AI создаёт интерактивные тесты и задания для проверки знаний на каждом шаге курса, экономя ваше время и усилия.</p>
                            <a href="{{route('register')}}" class="read-more">Подробнее <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card d-flex">
                        <div class="icon flex-shrink-0">
                            <i class="bi bi-camera-video"></i>
                        </div>
                        <div>
                            <h3>Поиск видеоуроков</h3>
                            <p>AI автоматически найдёт видеоуроки и обучающие ролики по вашим темам, делая обучение наглядным и удобным.</p>
                            <a href="{{route('register')}}" class="read-more">Подробнее <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

            </div>

        </div>

    </section><!-- /Services Section -->



    <!-- Дополнительный CSS для hover эффекта -->
    <style>
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
    </style>

    <!-- Stats Section -->

    <!-- Services Section -->

    <section id="courses" class="services section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Курсы</h2>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-4">
   @foreach($courses as $course)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card d-flex">

                        <div class="course-logo flex-shrink-0 me-5">
                            <img src="{{ $course->logo }}" alt="{{ $course->topic }} Logo" style="width: 50px;">
                        </div>

                        <div>
                            <h3>{{$course->topic}}</h3>
                            <p>{{$course->description}}</p>
                         <small>{{$course->teacher->name}}</small>
                            <a href="{{route('course.subscribe',['id'=>$course->id])}}" class="read-more">Подробнее <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

    </section><!-- /Services Section -->
{{--    <section id="teachers" class="py-5 bg-light">--}}
{{--        <div class="container">--}}
{{--            <!-- Section Title -->--}}
{{--            <div class="text-center mb-5" data-aos="fade-up">--}}
{{--                <h2 class="fw-bold">Учителя</h2>--}}
{{--                <p class="text-muted">Профессиональные наставники, готовые помочь вам достигать целей</p>--}}
{{--            </div>--}}

{{--            <div class="row g-4">--}}

{{--                @foreach($teachers as $teacher)--}}
{{--                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">--}}
{{--                        <div class="card border-0 shadow-sm hover-scale">--}}
{{--                            <img src="{{{asset('storage/'.$teacher->logo)}}}" class="card-img-top rounded-circle mx-auto mt-3" style="width:120px; height:120px; object-fit:cover;" alt="Saul Goodman">--}}
{{--                            <div class="card-body text-center">--}}
{{--                                <h5 class="card-title fw-bold">{{$teacher->name}}</h5>--}}
{{--                                <p class="text-primary mb-2">CEO & Founder</p>--}}
{{--                                <div class="mb-2">--}}
{{--                                    <i class="bi bi-star-fill text-warning"></i>--}}
{{--                                    <i class="bi bi-star-fill text-warning"></i>--}}
{{--                                    <i class="bi bi-star-fill text-warning"></i>--}}
{{--                                    <i class="bi bi-star-fill text-warning"></i>--}}
{{--                                    <i class="bi bi-star-fill text-warning"></i>--}}
{{--                                </div>--}}
{{--                                <p class="text-muted small">{{$teacher->bio}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <!-- Pricing Section -->

    <!-- Faq Section -->
    <section class="faq-9 faq section light-background" id="faq">
        <div class="container">
            <div class="row">

                <div class="col-lg-5" data-aos="fade-up">
                    <h2 class="faq-title">Часто задаваемые вопросы</h2>
                    <p class="faq-description">
                        Наша AI-платформа создаёт персонализированные обучающие дорожные карты. Она подходит для учеников, преподавателей и всех, кто хочет прокачать навыки через самообучение. Курсы формируются автоматически на основе целей и уровня знаний.
                    </p>
                    <div class="faq-arrow d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                        <!-- SVG стрелки остаются без изменений -->
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3>Что такое обучение в формате дорожной карты?</h3>
                            <div class="faq-content">
                                <p>Это визуальный путь, состоящий из шагов с учебными материалами, заданиями и тестами. Вы всегда видите, где находитесь и что предстоит изучить дальше.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Как работает генерация курсов с помощью AI?</h3>
                            <div class="faq-content">
                                <p>Вы указываете свою цель (например, "выучить Python", "подготовиться к собеседованию" или "развить soft-skills"), и AI формирует персонализированный курс с материалами, видео и тестами.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Кто может использовать платформу?</h3>
                            <div class="faq-content">
                                <p>Платформа подходит для всех: учеников, студентов, преподавателей и специалистов. Вы можете пройти готовый курс, создать свой или сгенерировать индивидуальный маршрут с помощью AI.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Могут ли учителя управлять курсами и учениками?</h3>
                            <div class="faq-content">
                                <p>Да, учителя могут создавать и редактировать курсы, добавлять учеников, отслеживать их прогресс и настраивать обратную связь. Платформа идеально подходит для онлайн-обучения и учебных заведений.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Можно ли использовать платформу для самообучения?</h3>
                            <div class="faq-content">
                                <p>Да! Просто укажи свою цель — и AI подберёт оптимальный путь обучения. Всё автоматически: тебе не нужно вручную искать материалы или составлять план.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Какие материалы доступны в курсах?</h3>
                            <div class="faq-content">
                                <p>Каждый шаг может содержать видеоуроки, статьи, задания, тесты, ссылки на внешние ресурсы и многое другое. Весь контент подбирается AI или преподавателем.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Отслеживается ли прогресс?</h3>
                            <div class="faq-content">
                                <p>Да, каждый пользователь видит свой прогресс, а преподаватели могут отслеживать успехи учеников. Это помогает оставаться мотивированным и видеть результат.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section><!-- /Faq Section -->



</main>

<footer id="contact" class="footer">
    <div class="container footer-top">
        <div class="row gy-4">

            <!-- Блок о платформе -->
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="index.html" class="logo d-flex align-items-center">
                    <span class="sitename">AI - PathFinder</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>г. Худжанд</p>
                    <p>Таджикистан</p>
                    <p class="mt-3"><strong>Телефон:</strong> <span>+992 977-17-36</span></p>
                    <p><strong>Email:</strong> <span>zmraupov@gmail.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href="#"><i class="bi bi-telegram"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Полезные ссылки -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Полезные ссылки</h4>
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="/register">Регистратсия</a></li>
                    <li><a href="/login">Вход</a></li>

                    <li><a href="#services">О платформе</a></li>
                </ul>
            </div>

            <!-- Возможности платформы -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Функции</h4>
                <ul>
                    <li>Создание курсов</li>
                    <li>AI-генерация контента</li>
                    <li>Дорожные карты</li>
                    <li>Видеоуроки и тесты</li>
                    <li>Аналитика прогресса</li>
                </ul>
            </div>

            <!-- Для кого платформа -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Для кого</h4>
                <ul>
                    <li>Ученикам</li>
                    <li>Преподавателям</li>
                    <li>Самообучение</li>
                    <li>Корпоративное обучение</li>
                    <li>HR и развитие</li>
                </ul>
            </div>

            <!-- Дополнительно -->


        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>


<script src="assets/js/main.js"></script>

</body>

</html>
