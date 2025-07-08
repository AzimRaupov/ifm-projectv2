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
@endif
@endsection
