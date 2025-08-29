@extends('layouts.app')

@section('content-main')

    <div id="test-user" class="container mt-5 p-4 border border-primary rounded shadow-sm" style="padding-top: 0px; width: 90%">
       <p style="text-align: left" id="kl"></p>
        <h3 id="test-text" class="text-center mb-4"></h3>

        <div class="test-content mb-4 chek" id="input-test">


        </div>

        <button onclick="clik()" class="btn btn-primary w-100">Проверить</button>
    </div>
<style>
    input[type="radio"] {
        transform: scale(1.5); /* увеличь значение, если нужно больше */
        margin-right: 8px;
        cursor: pointer;
    }
</style>
    <script>
        // Initialize test as an object
        let test = {};
        const inputContainer = document.getElementById('input-test');

        function radio() {
            try {
                const selectedRadio = document.querySelector('.chek input[type="radio"]:checked');
                return selectedRadio ? selectedRadio.value : false;
            } catch (e) {
                return false;
            }
        }

        function checkbox() {
            const checkboxes = document.querySelectorAll('.chek input[type="checkbox"]');
            const checkedCheckboxes = [];

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    checkedCheckboxes.push(checkbox.value);
                }
            });
            return checkedCheckboxes;
        }
        function matching() {
            const matchingResults = [];
            list2= document.querySelectorAll('#list2 .list2');

            list2.forEach((item, index) => {
                let t=item.textContent;
                matchingResults.push(t);
            });
          return matchingResults;
        }
        function question_answer(){
            let text_content=document.getElementById('answer');

            return text_content.value;
        }

        function test_view(dd) {
            test = dd.test; // Assign the incoming test object to the global test variable
            const testText = document.getElementById('test-text');
            document.getElementById('kl').textContent='10/'+dd.kl;
            testText.textContent = test.text;

            inputContainer.innerHTML = '';

            if (test.type_test === "question_answer") {
                inputContainer.innerHTML = `
                <textarea class="form-control" id="answer" placeholder="Textarea field" rows="4"></textarea>
            `;
            } else if (test.type_test === "one_correct" || test.type_test === "list_correct") {
                const typeInput = test.type_test === "one_correct" ? "radio" : "checkbox";
                let inputHtml = '';

                for (let i = 0; i < test.variants.length; i++) {
                    inputHtml += `
                    <p>
                        <input type="${typeInput}" id="variant-${i}" name="correct" value="${i}" class="form-check-input ms-2">
                        <label for="variant-${i}">${test.variants[i]}</label>
                    </p>
                `;
                }

                inputContainer.innerHTML = inputHtml;
            } else if (test.type_test === "matching") {
                let list1 = ``;
                let list2 = ``;
                let arr=test.list2.sort(() => Math.random() - 0.5);
                for (let i = 0; i < test.list1.length; i++) {
                    list1 += `<div class="list-group-item" id="${i}">${test.list1[i]}</div>`;
                    list2 += `<div class="list-group-item bg-light list2" id="${i}">${arr[i]}</div>`;
                }
                const matchingH = `
                <div class="row">
                    <div class="col-md-6">
                        <div id="list1" class="list-group js-sortable">
                            ${list1}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="list2" class="list-group js-sortable">
                            ${list2}
                        </div>
                    </div>
                </div>
            `;
                inputContainer.innerHTML = matchingH;
                initSortable();

            }
            else if(test.type_test){
                inputContainer.innerHTML=`
                  <p>
                        <input type="radio" id="" name="correct" value="1" class="form-check-input ms-2">
                        <label for="">Да</label>
                    </p>
  <p>
                        <input type="radio" id="variant" name="correct" value="0" class="form-check-input ms-2">
                        <label for="variant">Нет</label>
                    </p>
                `;
            }

        }

        function send_test(correct) {
            console.log(correct);
            $.ajax({
                url: `{{ route('api.check.test') }}`,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    'test_id': test.id,
                    'correct': correct
                }),
                success: function (res) {
                    console.log(res);
                    get_test();
                },
                error: function (xhr, status, error) {
                    console.error("Ошибка:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                }
            });
        }

        function clik() {
            if (test.type_test === "one_correct" || test.type_test === "true_false") {
                send_test(radio());
            } else if (test.type_test === "list_correct") {
                send_test(checkbox());
            }
            else if(test.type_test==="matching"){
                send_test(matching());
            }
            else if(test.type_test==="question_answer"){
                send_test(question_answer());
            }
        }

        let data_g = [];
        function get_test(){
            inputContainer.innerHTML = '';

            $.ajax({
            url: "{{ route('get.test',$step->id) }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            contentType: "application/json",
            data: JSON.stringify({}),
            success: function (data1) {
                console.log(data1);
                data_g = data1.test;
                test_view(data1); // Display the test using test_view function
            },
            error: function (xhr, status, error) {
                console.error("Ошибка:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
            }
        });
        }
        get_test();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
    <script>
        function initSortable() {
            // Инициализируем Sortable для первого списка
            if (document.getElementById("list1")) {
                new Sortable(document.getElementById("list1"), {
                    animation: 150,
                    group: { name: "listGroup3", pull: "clone", put: false },
                    sort: false,
                });
            }

            // Инициализируем Sortable для второго списка
            if (document.getElementById("list2")) {
                new Sortable(document.getElementById("list2"), {
                    animation: 150,
                    group: { name: "listGroup3", pull: "clone", put: false },
                    sort: true,
                });
            }
        }
    </script>
@endsection
