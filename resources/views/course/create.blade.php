@extends('layouts.app')

@section('head')

    <script src="{{asset('js/main.js')}}"></script>
@endsection

@section('content-main')

    <br>
    <div class="js-validate needs-validation">

        <!-- Заголовок -->
        <div class="text-center mb-5">
            <h1 class="display-5 mb-3" style="font-family: 'Roboto', sans-serif; color: #2c3e50;">
                Создайте свой курс с помощью искусственного интеллекта
            </h1>
            <p style="font-size: 16px; color: #7f8c8d;">
                Не знаете, как начать?
                <a class="link" href="{{route('course.tutorial')}}" style="color: #3498db; text-decoration: none; font-weight: bold;">
                    Узнать больше
                </a>
            </p>
        </div>

        <!-- Форма -->
        <div class="col-sm-6 mx-auto">

            <!-- Тема курса -->
            <div class="mb-4">
                <label class="form-label" for="topic" style="font-size: 16px; font-weight: 600;">
                    Названия курса
                </label>
                <input type="text"
                       class="form-control form-control-lg"
                       name="topic"
                       id="topic-input"
                       placeholder="Например: Веб-разработка"
                       required
                       style="border-radius: 12px; padding: 15px; font-size: 16px; transition: all 0.3s ease;">
                <span class="invalid-feedback" style="color: #e74c3c; font-size: 14px;">
                Пожалуйста, введите название
            </span>
            </div>

            <!-- Время обучения -->


            <!-- Уровень -->
            <div class="mb-4">
                <label class="form-label" for="level" style="font-size: 16px; font-weight: 600;">
                    Уровень
                </label>
                <select name="level" id="level" class="form-select"
                        style="border-radius: 12px; padding: 15px; font-size: 16px; background-color: #f9fbfc; border: 1px solid #dcdfe3; transition: all 0.3s ease;">
                    <option value="beginner">Начинающий</option>
                    <option value="intermediate">Продолжающий</option>
                    <option value="advanced">Профессионал</option>
                </select>
            </div>

            <!-- Кнопка -->
            <div class="text-center mt-4">
                <button class="btn btn-primary btn-lg px-4" onclick="create_course()" id="sub"
                        style="background-color: #3498db; border-radius: 50px; padding: 14px 40px; font-size: 18px; font-weight: bold; border: none; transition: all 0.3s ease;">
                    Генерировать курс
                </button>
            </div>

        </div>
    </div>

    <script>
        function create_course() {
            // Получаем данные из формы
            let topic = document.getElementById('topic-input').value.trim();
            let freetime = 14;
            let level = document.getElementById('level').value;
            let button = document.getElementById("sub");

            // Проверка заполнения
            if (!topic) {
                alert("Пожалуйста, введите тему курса.");
                return;
            }

            // Анимация кнопки
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Генерация...';
            button.disabled = true;

            // AJAX-запрос
            $.ajax({
                url: "{{ route('api.create.course') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    'topic': topic,
                    'freetime': freetime,
                    'level': level
                }),
                success: function(data) {
                    console.log(data);
                    button.innerHTML = 'Генерировать курс';
                    button.disabled = false;

                    if (data.redirect_url) {
                        showSuccessToast("Успешная генератсия.")
                        window.location.href = data.redirect_url;
                    } else {
                        createTree(data);
                    }
                },
                error: function(xhr, status, error) {
                    button.innerHTML = 'Генерировать курс';
                    button.disabled = false;
                    console.error("Ошибка:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                    showErrorToast("Произошла ошибка при генерации.");
                }
            });
        }
    </script>

@endsection
