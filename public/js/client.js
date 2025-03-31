user_name=document.getElementById('user-name');
user_type=document.getElementById('user-email');
main_content=document.getElementById('content-main');

function main(list){
    user=list.user;
    courses=list.courses;


    console.log(main_content);
    user_name.textContent=user.name;
    user_type.textContent=user.email;

    if(courses.length===0){

        main_content.innerHTML = `
            <div class="content container-fluid">
                <div class="row justify-content-sm-center text-center py-10">
                    <div class="col-sm-7 col-md-5">
                        <img class="img-fluid mb-5" src="{{asset('assets/svg/illustrations/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                        <img class="img-fluid mb-5" src="{{asset('assets/svg/illustrations-light/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">

                        <h1>Hello, nice to see you!</h1>
                        <p>You are now minutes away from creativity than ever before. Enjoy!</p>

<button class="btn btn-primary" onclick="newCourse()">Создайте первый курс</button>
                    </div>
                </div>
            </div>`;
    }
    else{

    }


}
function newCourse(){
    main_content.innerHTML = `
     <br>
     <form class="js-validate needs-validation" action="{{ route('course.store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="text-center">
            <div class="mb-5">
                <h1 class="display-5">Создайте свой курс с помощью искусственного интеллекта</h1>
                <p>Как это работает? <a class="link" href="#">Обучиться</a></p>
            </div>
        </div>

        <div class="col-sm-6 text-center">
            <div class="mb-4">
                <label class="form-label" for="topic">Чему хотите научиться?</label>
                <input type="text" class="form-control form-control-lg" name="topic" id="topic" placeholder="Тема" required>
                <span class="invalid-feedback">Пожалуйста, введите тему</span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-4">
                <label class="form-label" for="freetime">Сколько часов в неделю вы можете обучаться?</label>
                <select name="freetime" id="freetime" class="form-select">
                    <option value="5inweek">Пять часов в неделю</option>
                    <option value="10inweek">Десять часов в неделю</option>
                    <option value="20inweek">Двадцать часов в неделю</option>
                </select>
            </div>
        </div>

        <input type="submit" value="Генерировать" class="btn btn-primary">
    </form>

    <div id="responseMessage"></div>
    `;

}

fetch("{{ route('api1.get') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    }
})
    .then(response => {
        if (!response.ok) {
            throw new Error("Ошибка HTTP: " + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        main(data);
    })
    .catch(error => console.error("Ошибка:", error));
