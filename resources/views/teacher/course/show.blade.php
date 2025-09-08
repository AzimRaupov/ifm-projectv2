@extends('layouts.teacher')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/yc1vna9wb6j6dcol17ksd2cfbwws4l2i4w40l3lzdyi4uxyj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsplumb@2.15.0/dist/js/jsplumb.min.js"></script>


    <script src="https://unpkg.com/lucide@latest"></script>
<script src="{{asset('js/main.js')}}"></script>
@endsection

@section('new')
    new HSAddField('.js-add-field')
@endsection

@section('title')
    {{$course->topic}}
@endsection


@section('content-main')

    <style>
        #successToast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #28a745;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 9999;
            min-width: 200px;
        }
        #successToast.show {
            opacity: 1;
            pointer-events: auto;
        }
        #successToast svg {
            width: 20px;
            height: 20px;
            fill: white;
        }
    </style>

    <div id="successToast" role="alert" aria-live="assertive" aria-atomic="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M13.485 1.929a.75.75 0 0 1 0 1.06L6.72 9.754a.75.75 0 0 1-1.06 0L2.515 6.609a.75.75 0 0 1 1.06-1.06l2.088 2.09 6.703-6.712a.75.75 0 0 1 1.06 0z"/>
        </svg>
        Успешно сохранено!
    </div>

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <form action="{{route('teacher.step.update')}}" method="post" class="form-update">
            @csrf
            <input type="hidden" name="id" id="step_ide">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Изменитӣ шаг</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="">
                    <input type="text" name="topic" id="title_step" class="form-control"> <br>
                    <textarea name="content" class="tinymce" id="description_input"></textarea>
                    <br>
                    <div id="links_content">
                        <div class="js-add-field row mb-4"
                             data-hs-add-field-options='{
        "template": "#addEmailFieldTemplate",
        "container": "#addEmailFieldContainer",
        "defaultCreated": 0
      }'>

                            <div class="col-sm-9">

                                <div id="addEmailFieldContainer">


                                </div>

                                <a href="javascript:;" class="js-create-field form-link">
                                    <i class="bi-plus-circle me-1"></i> Добавть цылку
                                </a>
                            </div>
                        </div>
                        <!-- End Form -->

                        <!-- Add Phone Input Field -->
                        <div id="addEmailFieldTemplate" style="display: none;">

                            <input type="text" class="js-input-mask form-control" name="links[]" placeholder="Enter email" aria-label="Enter email">


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary button-update">Save changes</button>
                </div>
            </div>

        </div>
    </form>
    </div>




    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('teacher.step.destroy')}}" method="post" class="form-destroy">
                    @csrf
                    <input type="hidden" name="id" value="" id="step_id_dell">

                <div class="modal-body">
                    <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary button-destroy">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="new_child" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('teacher.step.new.child')}}" method="post" class="form-new_child">
                    @csrf
                    <input type="hidden" name="id" value="" id="step_id_parent">

                    <div class="modal-body">
                        <label for="topic_child" class="form-label">Название шага</label>
                        <input type="text" name="title" id="topic_child" class="form-control">
                        <label for="experience" class="form-label">Опыт за шаг</label>
                        <input type="number" name="experience" id="experience" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary button-new_child">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$course->topic}}</h1>
                </div>

                <div class="col-auto">
                    <div class="col-auto d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1" onclick="generate()">
                            <i data-lucide="cpu" class="lucide-icon-small"></i> Генерировать
                        </button>
                        <button class="btn btn-outline-success btn-sm d-flex align-items-center gap-1 js-save-form" onclick="save()">
                            <i data-lucide="save" class="lucide-icon-small"></i> Сохранить
                        </button>
                        <button class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1" onclick="deletee()">
                            <i data-lucide="trash-2" class="lucide-icon-small"></i> Удалить
                        </button>
                    </div>

                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
    </div>


    <div class="space-y-6 relative border-l-2 border-gray-300 pl-6" id="roadmap"></div>

    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel"></h5><br>


            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>
        <div style="padding: 0 1rem;" id="input-content">

        </div>
        <div class="offcanvas-body" style="margin-top: 0px">
            <div class="row" style="display: flex; align-items: center;">
                <a href="t" class="col-6 link_test" style="text-decoration: none; color: #3498db; display: flex; align-items: center; justify-content: center;">
                    Пройти тест

                </a>
                <a href="z" class="link_vocabulary col-6" style="text-decoration: none; color: #3498db; display: flex; align-items: center; justify-content: center;">
                    Лекся

                </a>
            </div>
            <br>
            <span class="spinner-border spinner-border-sm" style="display: inline-block" ></span>

            <div id="description">

            </div>
            <div id="links">

            </div>
        </div>

    </div>


@endsection

@section('script')
    <script>
        document.querySelector('.button-update')?.addEventListener('click', (e) => {
            e.preventDefault(); // чтобы форма не отправлялась стандартно

            if (window.tinymce) tinymce.triggerSave();

            const form = document.querySelector('.form-update');
            formpost(form);
        });

        document.querySelector('.button-destroy')?.addEventListener('click',(e)=>{
            e.preventDefault();

            const destroy_form = document.querySelector('.form-destroy');

            formpost(destroy_form);
        });
       document.querySelector('.button-new_child')?.addEventListener('click',(e)=>{
           e.preventDefault();

           const new_child=document.querySelector('.form-new_child')

           formpost(new_child);
       });
    </script>



    <script>
        // 🛠 Решение проблемы с фокусом в модалках Bootstrap
        document.addEventListener('focusin', (e) => {
            if (
                e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null
            ) {
                e.stopImmediatePropagation();
            }
        });

    </script>
    <script>
        const lv=document.querySelector('.link_vocabulary');
        async function fetchData() {
            try {
                const response = await fetch("{{ route('api.get.steps', $course->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({}),
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);
                view(data)
            } catch (error) {
                console.error("Ошибка при загрузке шагов курса:", error);
            }
        }

        async function get_description(step_id) {
            try {
                const offcanvasBody = document.getElementById('description');
                offcanvasBody.innerHTML=``;
                const spin = document.querySelector('.spinner-border-sm');
                spin.style='display: inline-block';
                const bllink=document.getElementById('links');
                bllink.innerHTML=``;
                const response =await fetch("{{ route('api.create.description') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id:step_id
                    }),
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                const data =await response.json();

                console.log(data);
                spin.style="display: none";
                offcanvasBody.innerHTML= `
                        ${data.description}

                    `;
                for(let i=0;i<data.links.length;i++){
                    bllink.innerHTML+=`
                                <a href="${data.links[i].link}" target="_blank">${data.links[i].link}</a> <br>
                    `;
                }

            } catch (error) {
                console.error("Ошибка при загрузке шагов курса:", error);
            }
        }

        function status_step(id,status){
            fetch("{{route('api.status.step')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    'id':id,
                    'status':status
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка при запросе: ' + response.status);
                    }
                    return response.json();
                })
                .then(result => {
                    console.log(result);
                })
                .catch(error => {
                    console.error('Ошибка запроса:', error);
                });

        }

        let ltest=document.querySelector('.link_test');


        function create_test(step_id) {
            fetch("{{ route('api.create.test') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: step_id
                }),
            }).catch(error => {
                console.error("Ошибка при отправке теста:", error);
            });

            ltest.href = '{{ route('test.show') }}?id=' + step_id;
        }

        function create_vocabulary(step_id) {
            fetch("{{ route('api.create.vocabulary') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: step_id
                }),
            }).catch(error => {
                console.error("Ошибка при отправке запроса:", error);
            });

            lv.href = '{{ route('vocabulary.show') }}?id=' + step_id;
        }
        fetchData();

    </script>

    <script>
       let save_button=document.getElementById('save');




       function view(st) {
            const roadmap = document.getElementById("roadmap");
            roadmap.innerHTML = "";

            st.forEach((step) => {
                const wrapper = document.createElement("div");
                wrapper.className = "mb-3 px-3";
                wrapper.dataset.id = step.id;
                wrapper.dataset.type = "parent";

                const parentRow = document.createElement("div");
                parentRow.className = "d-flex align-items-start bg-light border rounded p-3";

                const icon = document.createElement("div");
                icon.className = "pt-1 me-3";
                icon.innerHTML = '<i data-lucide="folder" class="text-primary" style="width:20px; height:20px;"></i>';

                const card = document.createElement("div");
                card.className = "flex-grow-1 bg-white border rounded shadow-sm p-3";

                const header = document.createElement("div");
                header.className = "d-flex justify-content-between align-items-start";

                const title = document.createElement("h2");
                title.style.cursor = "pointer";
                title.textContent = step.title;
                title.onclick = () => {
                    create_test(step.id);
                    create_vocabulary(step.id);
                    get_description(step.id);
                    new bootstrap.Offcanvas(document.getElementById('offcanvasRight')).show();
                    document.getElementById("offcanvasRightLabel").innerText = step.title;
                };

                const buttons = document.createElement("div");
                buttons.className = "d-flex gap-2";

                const btnEdit = document.createElement("button");
                btnEdit.className = "btn p-1";
                btnEdit.title = "Изменить";
                btnEdit.innerHTML = '<i data-lucide="pencil" class="text-primary" style="width:18px; height:18px;"></i>';
                btnEdit.onclick = () => editStep(step);

                const btnDelete = document.createElement("button");
                btnDelete.className = "btn p-1";
                btnDelete.title = "Удалить";
                btnDelete.innerHTML = '<i data-lucide="trash-2" class="text-danger" style="width:18px; height:18px;"></i>';
                btnDelete.onclick = () => deleteStep(step);

                const btnAdd = document.createElement("button");
                btnAdd.className = "btn p-1";
                btnAdd.title = "Добавить подшаг";
                btnAdd.innerHTML = '<i data-lucide="plus" class="text-success" style="width:18px; height:18px;"></i>';
                btnAdd.onclick = () => addHeirStep(step);

                buttons.appendChild(btnEdit);
                buttons.appendChild(btnDelete);
                buttons.appendChild(btnAdd);

                header.appendChild(title);
                header.appendChild(buttons);

                const exp = document.createElement("small");
                exp.className = "text-muted";
                exp.textContent = `${step.experience} XP`;

                card.appendChild(header);
                card.appendChild(exp);
                parentRow.appendChild(icon);
                parentRow.appendChild(card);
                wrapper.appendChild(parentRow);

                // Контейнер для подшагов
                const childContainer = document.createElement("div");
                childContainer.className = "ms-5 mt-2";
                childContainer.id = `child-container-${step.id}`;

                if (step.step_heirs && step.step_heirs.length > 0) {
                    step.step_heirs.forEach((child) => {
                        const childRow = document.createElement("div");
                        childRow.className = "d-flex align-items-start bg-body-secondary border rounded p-2 mb-2";
                        childRow.dataset.id = child.id;
                        childRow.dataset.type = "child";
                        childRow.dataset.parentId = step.id;

                        const childIcon = document.createElement("div");
                        childIcon.className = "pt-1 me-2";
                        childIcon.innerHTML = '<i data-lucide="corner-down-right" class="text-secondary" style="width:16px; height:16px;"></i>';

                        const childCard = document.createElement("div");
                        childCard.className = "flex-grow-1 bg-white border rounded p-2 shadow-sm";

                        const childHeader = document.createElement("div");
                        childHeader.className = "d-flex justify-content-between align-items-center";

                        const childTitle = document.createElement("p");
                        childTitle.className = "";
                        childTitle.style.cursor = "pointer";
                        childTitle.style.fontSize = "19px";
                        childTitle.textContent = child.title;
                        childTitle.onclick = () => {
                            get_description(child.id);
                            create_test(child.id);
                            create_vocabulary(child.id);
                            new bootstrap.Offcanvas(document.getElementById('offcanvasRight')).show();
                            document.getElementById("offcanvasRightLabel").innerText = child.title;
                        };

                        const childBtns = document.createElement("div");
                        childBtns.className = "d-flex gap-2";

                        const chEdit = document.createElement("button");
                        chEdit.className = "btn p-1";
                        chEdit.title = "Изменить";
                        chEdit.innerHTML = '<i data-lucide="pencil" class="text-primary" style="width:16px; height:16px;"></i>';
                        chEdit.onclick = () => editStep(child);

                        const chDelete = document.createElement("button");
                        chDelete.className = "btn p-1";
                        chDelete.title = "Удалить";
                        chDelete.innerHTML = '<i data-lucide="trash-2" class="text-danger" style="width:16px; height:16px;"></i>';
                        chDelete.onclick = () => deleteStep(child);

                        childBtns.appendChild(chEdit);
                        childBtns.appendChild(chDelete);

                        childHeader.appendChild(childTitle);
                        childHeader.appendChild(childBtns);
                        childCard.appendChild(childHeader);

                        childRow.appendChild(childIcon);
                        childRow.appendChild(childCard);
                        childContainer.appendChild(childRow);
                    });
                }

                wrapper.appendChild(childContainer);
                roadmap.appendChild(wrapper);

                // Инициализация Sortable для подшагов внутри этого родителя
                new Sortable(childContainer, {
                    group: `children-${step.id}`,
                    animation: 150,
                    onEnd: function () {
                        saveChildOrder(step.id);
                    }
                });

                lucide.createIcons();
            });

            // Инициализация Sortable для родительских шагов
            new Sortable(roadmap, {
                handle: ".bg-light",
                animation: 150,
                onEnd: function () {
                    saveParentOrder();
                }
            });
        }

        function saveParentOrder() {
            const order = [];
            document.querySelectorAll("#roadmap > div[data-type='parent']").forEach(el => {
                order.push(el.dataset.id);
            });
            console.log("Новый порядок родителей:", order);
            reqman("{{ route('api.teacher.step.sort') }}", "POST", {type:'parents',list:order}).then(rr => {
                console.log(rr);
                showSuccessToast();
                save_button.disabled = false;
            });

            save_button.disabled=false;

        }

        function saveChildOrder(parentId) {
            const order = [];
            document.querySelectorAll(`#child-container-${parentId} > div[data-type='child']`).forEach(el => {
                order.push(el.dataset.id);
            });
            console.log(`Новый порядок подшагов родителя ${parentId}:`, order);

            reqman("{{ route('api.teacher.step.sort') }}", "POST",  {type:'childs',list:order}).then(rr => {
                console.log(rr);
                showSuccessToast()
                save_button.disabled = false;
            });
        }



    </script>

    <script>
        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = true; // обязательно, если у тебя CSRF

            xhr.open('POST', '{{ route("api.upload") }}');

            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                let json;
                try {
                    json = JSON.parse(xhr.responseText);
                } catch (err) {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                if (!json || typeof json.location !== 'string') {
                    reject('Invalid response format: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('dir', 'description'); // вот так правильно передаётся папка

            xhr.send(formData);
        });

        tinymce.init({
            selector: 'textarea.tinymce',
            height: 400,
            plugins: 'lists link image preview code media',
            toolbar: 'undo redo | styles | image | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link media | preview code',
            images_upload_handler: example_image_upload_handler,
            valid_elements: '*[*]',
            extended_valid_elements: '*[*]',
            language: 'ru',
        });
    </script>

    <script>
        function editStep(step){
            console.log(step);
            document.getElementById('title_step').value = step.title;
            document.getElementById('step_ide').value = step.id;

            if (tinymce.get('description_input')) {
                tinymce.get('description_input').setContent(step.description || '');
            } else {
                document.getElementById('description_input').value = step.description;
            }



            let links_content = document.getElementById('addEmailFieldContainer');

            links_content.innerHTML = '';

            for (let i = 0; i < step.links.length; i++) {
                links_content.innerHTML += `
        <div style>
            <input type="text" class="js-input-mask form-control"
                   value="${step.links[i].link}"
                   name="links[]"
                   placeholder="Enter email"
                   aria-label="Enter email">
        </div>
    `;
            }


            var modal = new bootstrap.Modal(document.getElementById('exampleModalScrollable'));
            modal.show();
        }
        function deleteStep(step){
            console.log(step);
            document.getElementById('step_id_dell').value=step.id;
            var modal = new bootstrap.Modal(document.getElementById('exampleModalCenter'));
            modal.show();
        }
        function addHeirStep(step){
            document.getElementById('step_id_parent').value=step.id;
            var modal = new bootstrap.Modal(document.getElementById('new_child'));
            modal.show();
        }

    </script>

@endsection
