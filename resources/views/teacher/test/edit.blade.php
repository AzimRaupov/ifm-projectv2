@extends('layouts.teacher')

@section('content-main')
    <style>
        input[type="radio"],
        input[type="checkbox"] {
            transform: scale(1.5); /* увеличивает размер */
            margin-right: 8px;
            cursor: pointer;
        }
    </style>

    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Генеритсия лексии</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('teacher.test.generate')}}" method="post" class="generate-form">
                    @csrf
                    <input type="hidden" name="id" value="{{$step->id}}">
                    <div class="modal-body">

                        <label class="form-label">Тема лексии</label>
                        <input type="text" name="title" class="form-control">
                        <br>

                        <label class="form-label">Тип теста</label>
                       <select class="form-select" name="type">
                           <option value="one_correct">Один правилный ответ</option>
                           <option value="list_correct">Несколько правилных ответа</option>
                           <option value="question_answer">Вотпрос ответ</option>
                           <option value="true_false">Да или нет</option>
                           <option value="matching">М</option>

                       </select>
                        <br>
                        <label class="form-label">Дополнительный промт</label>

                        <input type="text" name="promt" id="" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary generate">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="bg-light border-bottom shadow-sm p-2 mb-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 1030;">
        <strong>🔧 Панель инструментов</strong>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1" onclick="generate_vocabulary_view()">
                <i data-lucide="cpu" class="lucide-icon-small"></i> Генерировать
            </button>

            <button class="btn btn-outline-success btn-sm d-flex align-items-center gap-1 js-save-form">
                <i data-lucide="save" class="lucide-icon-small"></i> Сохранить
            </button>

            <button class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1" onclick="delete_vocabulary()">
                <i data-lucide="trash-2" class="lucide-icon-small"></i> Удалить
            </button>
        </div>
    </div>

    <br>
    <div class="text-center">
        <ul class="nav nav-segment nav-pills mb-7" role="tablist">
            @foreach($step->test as $index => $test)
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
        @foreach($step->test as $index => $item)
            <div class="tests_list card tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                 id="tab{{ $item->id }}"
                 role="tabpanel"
                 style="width: 1000px;margin-left: 20px"
                 aria-labelledby="test_nav{{ $item->id }}">
                <div class="card-body" data-name="{{$item->id}}" data-value="{{$item->type_test}}">
                    <h2 style="text-align: center">{{$item->text}}</h2> <br>

                    @if ($item->type_test == "question_answer")
                        <textarea class="form-control" id="answer" name="answer_{{$item->id}}" placeholder="Ответ" rows="4" >{{$item->corrects[0]->true}}</textarea>

                    @elseif ($item->type_test == "one_correct" || $item->type_test == "list_correct")
                        @foreach($item->variantss as $in => $variant)
                            @if ($item->type_test == "list_correct")
                                <p>
                                    <input type="checkbox"
                                           id="variant-{{$in}}"
                                           {{ in_array($in, $item->corrects->pluck('true')->toArray())==true ? 'checked':''}}
                                           name="correct_{{$item->id}}[]"
                                           value="{{$in}}"
                                           class="form-check-input ms-2">
                                    <label for="variant-{{$in}}">{{$variant->variant}}</label>
                                </p>
                            @elseif ($item->type_test == "one_correct")
                                <p>
                                    <input type="radio"
                                           id="variant-{{$in}}"
                                           {{$in == $item->corrects[0]->true ? 'checked': ''}}
                                           name="correct_{{$item->id}}"
                                           value="{{$in}}"
                                           class="form-check-input ms-2">
                                    <label for="variant-{{$in}}">{{$variant->variant}}</label>
                                </p>

                            @endif
                        @endforeach

                    @elseif ($item->type_test == "matching")
                        <div class="row">
                            <div class="col-md-6">
                                <div class="list-group js-sortable">
                                    @foreach($item->lists1 as $in => $list)
                                        <div class="list-group-item" id="{{$in}}">{{$list->str}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="list-group js-sortable">
                                    @foreach($item->lists2 as $in => $list)
                                        <div class="list-group-item bg-light list2" id="{{$in}}">{{$list->str}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @elseif ($item->type_test == "true_false")
                        <p>
                            <input type="radio"
                                   id="true"
                                   name="true_false_{{$item->id}}"
                                   value="1"
                                   class="form-check-input ms-2"
                                {{$item->corrects[0]->true == 1 ? 'checked' : ''}}>
                            <label for="true">Да</label>
                        </p>
                        <p>
                            <input type="radio"
                                   id="false"
                                   name="true_false_{{$item->id}}"
                                   value="0"
                                   class="form-check-input ms-2"
                                {{$item->corrects[0]->true == 0 ? 'checked' : ''}}>
                            <label for="false">Нет</label>
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>



@endsection

@section('script')

    <script>
        document.querySelector('.generate')?.addEventListener('click', function(e) {
            e.preventDefault();

            const form = document.querySelector('.generate-form');
            if (!form) {
                alert('Форма не найдена!');
                return;
            }

            const formData = new FormData(form);
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Создаём AbortController и таймер
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 секунд

            fetch(form.getAttribute('action') || window.location.href, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                },
                body: formData,
                signal: controller.signal
            })
                .then(res => {
                    clearTimeout(timeoutId); // Убираем таймер, если ответ получен
                    return res.ok ? res.json() : res.text().then(text => Promise.reject(text));
                })
                .then(data => {
                    alert('✅ Успешно отправлено!');
                    console.log(data);
                })
                .catch(err => {
                    if (err.name === 'AbortError') {
                        alert('⏱ Время ожидания истекло (30 секунд)');
                    } else {
                        console.error(err);
                        alert('❌ Ошибка при отправке');
                    }
                });
        });
    </script>


    <script>
        function generate_vocabulary_view(){
            var modal = new bootstrap.Modal(document.getElementById('exampleModalCenter'));
            modal.show();
        }
    </script>


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
                    'id': {{$step->id}},
                    'answer': answer
                }),
                success: function (res) {
                    console.log(res);
                    // location.reload();
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
