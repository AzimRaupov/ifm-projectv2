@extends('layouts.app')

@section('content-main')

    <div class="container my-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold" style="color: #2c3e50;">
                Как работает генерация курса с помощью ИИ?
            </h1>
            <p class="text-muted" style="font-size: 18px;">
                Узнайте, что происходит «под капотом», когда вы вводите тему и нажимаете кнопку «Генерировать».
            </p>
        </div>

        <!-- Карточки шагов -->
        <div class="row g-4">
            <!-- Шаг 1 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm rounded-4 border-0">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <span class="badge bg-primary p-3 fs-6 rounded-circle">1</span>
                        </div>
                        <h5 class="fw-bold mb-3">Анализ темы</h5>
                        <p class="text-muted">
                            Искусственный интеллект анализирует вашу тему курса и уточняет ключевые понятия, чтобы построить логичную структуру обучения.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Шаг 2 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm rounded-4 border-0">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <span class="badge bg-success p-3 fs-6 rounded-circle">2</span>
                        </div>
                        <h5 class="fw-bold mb-3">Создание программы</h5>
                        <p class="text-muted">
                            На основе вашего уровня и свободного времени система формирует программу с удобным распределением по неделям.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Шаг 3 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm rounded-4 border-0">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <span class="badge bg-warning p-3 fs-6 rounded-circle">3</span>
                        </div>
                        <h5 class="fw-bold mb-3">Генерация материалов</h5>
                        <p class="text-muted">
                            ИИ подбирает полезные ресурсы, формирует задания, тесты и практику, чтобы вы смогли закрепить знания.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блок преимуществ -->
        <div class="mt-5 text-center">
            <h2 class="fw-bold mb-4" style="color: #2c3e50;">Почему это удобно?</h2>
            <p class="text-muted fs-5 mb-4">
                Вы экономите время на поиске информации и получаете <span class="fw-bold">персональный учебный план</span>,
                который адаптирован под ваш уровень и свободное время.
            </p>
            <a href="{{ url('/') }}" class="btn btn-lg px-4"
               style="background-color: #3498db; color: white; border-radius: 50px; font-weight: bold;">
                Попробовать прямо сейчас
            </a>
        </div>

    </div>

@endsection
