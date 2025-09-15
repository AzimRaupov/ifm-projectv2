@extends('layouts.app')


@section('head')

    <script src="{{asset('js/main.js')}}"></script>
@endsection

@section('content-main')
    @if($tests->count()>0)

<style>
    input[type="radio"],
    input[type="checkbox"] {
        transform: scale(1.5); /* увеличивает размер */
        margin-right: 8px;
        cursor: pointer;
    }
    /*  dfd*/


    /* Общий стиль карточек теста */
    .tests_list.card {
        max-width: 100%;
        margin: 0 auto;
        background-color: #d6e1f1;
        padding: 15px;
        border-radius: 8px;
    }

    /* Контейнер с шагами matching */
    .matching-test {
        gap: 15px;
    }

    /* На телефонах и планшетах */
    @media (max-width: 768px) {
        .tests_list.card {
            width: 100%;
            margin-left: 0;
            padding: 10px;
        }

        /* Для matching: элементы один под другим */
        .matching-test .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Уменьшаем кнопки */
        .next-tab-btn,
        .btn-success {
            width: 100%;
            font-size: 16px;
        }

        /* Радиокнопки и чекбоксы с большим кликабельным полем */
        .form-check-input {
            transform: scale(1.3);
            margin-right: 8px;
        }
    }

    /* На совсем маленьких экранах */
    @media (max-width: 480px) {
        h2 {
            font-size: 18px;
        }
        .list-group-item {
            font-size: 14px;
            padding: 8px;
        }
    }

    /* Общий стиль для matching */
    .matching-test {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    /* Колонки для ПК */
    .matching-test .col-md-6 {
        flex: 0 0 48%; /* почти 50%, но с зазором */
        max-width: 48%;
    }

    /* На телефоне — вертикально */
    @media (max-width: 768px) {
        .matching-test .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }



</style>
    <br>
    <div class="text-center">
        <ul class="nav nav-segment nav-pills mb-7" role="tablist">
            @foreach($tests as $index => $test)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                       id="test_nav{{ $test->id }}"
                       href="#tab{{ $test->id }}"
                       data-bs-toggle="pill"
                       data-bs-target="#tab{{ $test->id }}"
                       role="tab"
                       aria-controls="tab{{ $test->id }}"
                       aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        Тест {{ $index + 1 }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content">
        @foreach($tests as $index => $test)
            <div class="tests_list card tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                 id="tab{{ $test->id }}"
                 role="tabpanel"
                 style="width: 1000px; margin-left: 20px; background-color: #d6e1f1;"
                 aria-labelledby="test_nav{{ $test->id }}">
                <div class="card-body" data-name="{{ $test->id }}" data-value="{{ $test->type_test }}">
                    <h2 style="text-align: center">{{ $test->text }}</h2> <br>

                    @if ($test->type_test == "question_answer")
                        <textarea class="form-control" id="answer" name="answer_{{ $test->id }}" placeholder="Textarea field" rows="4"></textarea>

                    @elseif ($test->type_test == "one_correct" || $test->type_test == "list_correct")
                        @if (!empty($test->variantss) && is_iterable($test->variantss))
                            @foreach($test->variantss as $in => $variant)
                                <p>
                                    <input type="{{ $test->type_test == "one_correct" ? "radio" : "checkbox" }}"
                                           id="variant-{{ $in }}"
                                           name="correct_{{ $test->id }}[]"
                                           value="{{ $in }}"
                                           class="form-check-input ms-2">
                                    <label for="variant-{{ $in }}">{{ $variant->variant }}</label>
                                </p>
                            @endforeach
                        @else
                            <p class="text-danger">{{ dd($test) }}</p>

                        @endif

                    @elseif ($test->type_test == "matching")
                        @php
                            // Перемешиваем коллекцию lists2
                            $test->lists2 = $test->lists2->shuffle();
                        @endphp
                        <div class="row matching-test" data-test-id="{{ $test->id }}">
                            <div class="col-md-6">
                                <div id="list1-{{ $test->id }}" class="list-group js-sortable list1">
                                    @foreach($test->lists1 as $in => $list)
                                        <div class="list-group-item" id="item1-{{ $test->id }}-{{ $in }}">{{ $list->str }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="list2-{{ $test->id }}" class="list-group js-sortable list2">
                                    @foreach($test->lists2 as $in => $list)
                                        <div class="list-group-item bg-light" id="item2-{{ $test->id }}-{{ $in }}">{{ $list->str }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @elseif ($test->type_test == "true_false")
                        <p>
                            <input type="radio" id="true_{{ $test->id }}" name="true_false_{{ $test->id }}" value="1" class="form-check-input ms-2">
                            <label for="true_{{ $test->id }}">Да</label>
                        </p>
                        <p>
                            <input type="radio" id="false_{{ $test->id }}" name="true_false_{{ $test->id }}" value="0" class="form-check-input ms-2">
                            <label for="false_{{ $test->id }}">Нет</label>
                        </p>
                    @endif

                    {{-- Кнопка "Вперед", если следующий тест существует --}}
                    @if ($index < count($tests) - 1)
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary next-tab-btn" data-next-tab="#tab{{ $tests[$index + 1]->id }}">
                                Вперед
                            </button>
                        </div>
                    @endif

                    {{-- Кнопка "Сдать тесты" на последнем тесте --}}
                    @if ($index === count($tests) - 1)
                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="pr_test()">Сдать тесты</button>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @else
        @include('components.my.spinner')
        <script>
            function while_check(){
                reqman("{{route('api.vocabulary.isset')}}", "POST", {id:{{$request->id}}}).then(rr => {
                    console.log(rr);
                    if(rr.count){
                        finish();
                        location.reload();
                    }
                });
            }

            setInterval(function() {
                while_check();
            }, 3000);
        </script>
    @endif


@endsection

@section('script')
    <script>

        function check_test(answer) {

            $.ajax({
                url: `{{ route('test.check') }}`,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    'id': {{$request->id}},
                    'answer': answer
                }),
                success: function (res) {
                    console.log(res);
                      location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Ошибка:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                }
            });
        }

        function pr_test() {
            const tests = document.querySelectorAll('.tests_list');
            const results = [];

            tests.forEach((test) => {
                const testId = test.querySelector('.card-body').getAttribute('data-name');
                const typeTest = test.querySelector('.card-body').getAttribute('data-value');

                let correct = null;

                if (typeTest === "question_answer") {
                    correct = test.querySelector('textarea').value;
                } else if (typeTest === "one_correct" || typeTest === "true_false") {
                    const selectedRadio = test.querySelector('.card-body input[type="radio"]:checked');
                    correct = selectedRadio ? selectedRadio.value : null;
                } else if (typeTest === "list_correct") {
                    const checkboxes = test.querySelectorAll('.card-body input[type="checkbox"]');
                    const checkedCheckboxes = [];
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) checkedCheckboxes.push(checkbox.value);
                    });
                    correct = checkedCheckboxes;
                } else if (typeTest === "matching") {
                    const matchingResults = [];
                    const list2 = test.querySelector(`#list2-${testId}`);
                    if (list2) {
                        list2.querySelectorAll('.list-group-item').forEach(item => {
                            matchingResults.push(item.textContent.trim());
                        });
                    }
                    correct = matchingResults;
                }

                results.push({
                    test_id: testId,
                    type: typeTest,
                    answer: correct
                });
            });


           check_test(results);
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.matching-test').forEach(container => {
                const testId = container.getAttribute('data-test-id');

                const list1 = document.getElementById(`list1-${testId}`);
                const list2 = document.getElementById(`list2-${testId}`);

                if (list1 && list2) {
                    // Первая колонка: запрет на сортировку и перемещение элементов из неё
                    new Sortable(list1, {
                        animation: 150,
                        group: {
                            name: "matching-group-" + testId,
                            pull: "clone", // клонирование, нельзя перемещать из list1
                            put: false
                        },
                        sort: false,
                    });

                    // Вторая колонка: можно сортировать и принимать элементы из list1
                    new Sortable(list2, {
                        animation: 150,
                        group: {
                            name: "matching-group-" + testId,
                            pull: false,  // нельзя вытаскивать из list2
                            put: true     // можно положить сюда элементы из list1
                        },
                        sort: true,
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.next-tab-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const nextTabSelector = button.getAttribute('data-next-tab');
                    const nextTabLink = document.querySelector(`a[href="${nextTabSelector}"]`);

                    if (nextTabLink) {
                        new bootstrap.Tab(nextTabLink).show();
                    }
                });
            });
        });
    </script>




@endsection
