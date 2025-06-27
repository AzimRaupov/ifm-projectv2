@extends('layouts.app')



@section('content-main')
    <br>
    <div class="js-validate needs-validation">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="text-center mb-5">
            <h1 class="display-5 mb-3" style="font-family: 'Roboto', sans-serif; color: #2c3e50;">Создайте свой курс с помощью искусственного интеллекта</h1>
            <p style="font-size: 16px; color: #7f8c8d;">Как это работает? <a class="link" href="#" style="color: #3498db; text-decoration: none; font-weight: bold;">Обучиться</a></p>
        </div>

        <div class="col-sm-6 mx-auto">
            <div class="mb-4">
                <label class="form-label" for="topic" style="font-size: 16px; font-weight: 600;">Чему хотите научиться?</label>
                <input type="text" class="form-control form-control-lg" name="topic" id="topic-input" placeholder="Тема" required
                       style="border-radius: 10px; padding: 15px; font-size: 16px; transition: all 0.3s ease;">
                <span class="invalid-feedback" style="color: #e74c3c; font-size: 14px;">Пожалуйста, введите тему</span>
            </div>
        </div>

        <div class="col-sm-6 mx-auto">
            <div class="mb-4">
                <label class="form-label" for="freetime" style="font-size: 16px; font-weight: 600;">Сколько часов в неделю вы можете обучаться?</label>
                <input type="text" id="freetime" class="form-control form-control-lg" name="freetime">
            </div>
        </div>
        <div class="col-sm-6 mx-auto">
            <div class="mb-4">
                <label class="form-label" for="level" style="font-size: 16px; font-weight: 600;">Ваш уроваень занние</label>
                <select name="level" id="level" class="form-select"
                        style="border-radius: 10px; padding: 15px; font-size: 16px; background-color: #f0f3f5; border: 1px solid #bdc3c7; transition: all 0.3s ease;">
                    <option value="ignorant">Не чего не знаю</option>
                    <option value="knowing">Уже знаю</option>
                    <option value="experienced">Хорошо знаю</option>
                </select>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary" onclick="create_course(event)" id="sub"
                    style="background-color: #3498db; border-radius: 50px; padding: 12px 30px; font-size: 16px; font-weight: bold; border: none; transition: all 0.3s ease;">
                Генерировать</button>
        </div>
    </div>
@endsection
