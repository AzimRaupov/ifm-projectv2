@extends('layouts.app')

@section('content-main')

    <br>
    <div class="text-center">
        <ul class="nav nav-segment nav-pills mb-7" role="tablist">
            @foreach($test as $index => $item)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                       id="test_nav{{ $item->id }}"
                       href="#tab{{ $item->id }}"
                       data-bs-toggle="pill"
                       data-bs-target="#tab{{ $item->id }}"
                       role="tab"
                       aria-controls="tab{{ $item->id }}"
                       aria-selected="{{ $index === 0 ? 'true' : 'false' }}">Тест {{$index+1}}</a>
                </li>
            @endforeach
        </ul>
    </div>


    <div class="tab-content">
        @foreach($test as $index => $item)
            <div class="tests_list card tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                 id="tab{{ $item->id }}"
                 role="tabpanel"
                 style="width: 1000px;margin-left: 20px;background-color: #d6e1f1"
                 aria-labelledby="test_nav{{ $item->id }}">
                <div class="card-body" data-name="{{$item->id}}" data-value="{{$item->type_test}}">
                <h2 style="text-align: center">{{$item->text }}</h2> <br>
                @if ($item->type_test == "question_answer")
                    <textarea class="form-control" id="answer" name="answer_{{$item->id}}" placeholder="Textarea field" rows="4"></textarea>
                @elseif ($item->type_test == "one_correct" || $item->type_test == "list_correct")

                    @foreach($item->variants as $in=>$variant)

                        <p>
                            <input type="{{ ($item->type_test=="one_correct" ? "radio" : "checkbox") }}" id="variant-{{$in}}" name="correct_{{$item->id}}" value="{{$in}}" class="form-check-input ms-2">
                            <label for="variant-{{$in}}">{{$variant}}</label>
                        </p>

                    @endforeach

                @elseif($item->type_test=="matching" && $index!==9)
                    <div class="row">
                        <div class="col-md-6">
                            <div id="t1_list1" class="list-group js-sortable">
                                @foreach($item->list1 as $in=>$list)
                                    <div class="list-group-item" id="{{$in}}">{{$list}}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="t1_list2" class="list-group js-sortable">
                                @foreach($item->list2 as $in=>$list)
                                    <div class="list-group-item bg-light list2" id="{{$in}}">{{$list}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @elseif($item->type_test=="true_false")
                    <p>
                        <input type="radio" id="true" name="true_false_{{$item->id}}" value="1" class="form-check-input ms-2">
                        <label for="true">Да</label>
                    </p>
                    <p>
                        <input type="radio" id="false" name="true_false_{{$item->id}}" value="0" class="form-check-input ms-2">
                        <label for="false">Нет</label>
                    </p>
                @endif

                    @if($index < count($test) - 1)
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary next-tab-btn" data-next-tab="#tab{{ $test[$index + 1]->id }}">Вперед</button>
                        </div>
                    @endif
                @if($index===9)
                    <div class="row">
                        <div class="col-md-6">
                            <div id="t2_list1" class="list-group js-sortable">
                                @foreach($item->list1 as $in=>$list)
                                    <div class="list-group-item" id="{{$in}}">{{$list}}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="t2_list2" class="list-group js-sortable">
                                @foreach($item->list2 as $in=>$list)
                                    <div class="list-group-item bg-light list2" id="{{$in}}">{{$list}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div> <br>
                        <div class="text-center mt-4">
                            <button class="btn btn-primary" style="text-align: center" onclick="pr_test()">Сдать тесты</button>
                        </div>
                @endif
            </div>
            </div>
        @endforeach
    </div>


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
                    const list2Container = test.querySelector('.card-body').querySelector('#t1_list2, #t2_list2');
                    if (list2Container) {
                        const items = list2Container.querySelectorAll('.list-group-item');
                        items.forEach(item => {
                            matchingResults.push(item.textContent);
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


                new Sortable(document.getElementById("t1_list1"), {
                    animation: 150,
                    group: { name: "listGroup3", pull: "clone", put: false },
                    sort: false,
                });




                new Sortable(document.getElementById("t1_list2"), {
                    animation: 150,
                    group: { name: "listGroup3", pull: "clone", put: false },
                    sort: true,
                });

            new Sortable(document.getElementById("t2_list1"), {
                animation: 150,
                group: { name: "listGroup3", pull: "clone", put: false },
                sort: false,
            });




            new Sortable(document.getElementById("t2_list2"), {
                animation: 150,
                group: { name: "listGroup3", pull: "clone", put: false },
                sort: true,
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded',function (){
const nb=document.querySelectorAll('.next-tab-btn');
nb.forEach(button=>{
    button.addEventListener('click',function (){
        const nxt=this.getAttribute('data-next-tab');
        const nxtt=document.querySelector(`[data-bs-target="${nxt}"]`);

        if(nxtt){
            nxtt.click();
        }

    });
});
        });
    </script>

@endsection
