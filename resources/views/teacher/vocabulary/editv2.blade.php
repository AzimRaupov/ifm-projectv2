@extends('layouts.teacher')
@section('head')
    <script src="https://cdn.tiny.cloud/1/yc1vna9wb6j6dcol17ksd2cfbwws4l2i4w40l3lzdyi4uxyj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

@endsection

@section('new')
    new HSAddField('.js-add-field')
@endsection

@section('body-class')
    navbar-vertical-aside-mini-mode
@endsection

@section('content-main')
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Генеритсия лексии</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('teacher.vocabulary.generate')}}" method="post" class="generate-vocabulary">
                    @csrf
                    <input type="hidden" name="id" value="{{$step->id}}">
                    <div class="modal-body">

                        <label class="form-label">Тема лексии</label>
                        <input type="text" name="topic" class="form-control">
                        <br>
                        <label class="form-label">Дополнительный промт</label>

                        <input type="text" name="promt" id="" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary generate-vocabulary-button">Save changes</button>
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


    <div class="text-center">
        <ul class="nav nav-segment nav-pills mb-7" id="nav-nav" role="tablist">
            @foreach($step->vocabularies as $index=>$item)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                       id="test_nav{{ $item->id }}"
                       href="#tab{{ $item->id }}"
                       data-bs-toggle="pill"
                       data-bs-target="#tab{{ $item->id }}"
                       role="tab"
                       aria-controls="tab{{ $item->id }}"
                       aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        Подшаг {{ $index + 1 }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content" id="tab-content">
        @foreach($step->vocabularies as $index=>$item)
            <div class="tests_list card tab-pane vocabulary_class fade {{ $index === 0 ? 'show active' : '' }}"
                 id="tab{{ $item->id }}"
                 role="tabpanel"
                 style="width: auto; margin-left: 20px; background-color: #d6e1f1;"
                 aria-labelledby="test_nav{{ $item->id }}">
                <div class="card-body" data-name="{{ $item->id }}" >

                    <form method="POST"
                          action="{{ route('teacher.vocabulary.update') }}"
                          enctype="multipart/form-data"
                          class="vocabulary-form"
                          data-id="{{ $item->id }}">
                        @csrf
                        <label class="form-label" for="title">Загаловок:</label>
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <input type="text" name="title" id="title" class="form-control" value="{{$item->title}}"> <br>
                        <textarea name="content" class="tinymce">{{ $item->text }}</textarea> <br>
                        <!-- Form -->
                        <div class="js-add-field row mb-4"
                             data-hs-add-field-options='{
        "template": "#addEmailFieldTemplate",
        "container": "#addEmailFieldContainer",
        "defaultCreated": 0
      }'>

                            <div class="col-sm-9">

                                <!-- Container For Input Field -->
                                <div id="addEmailFieldContainer">
                                    @foreach($item->links as $link)
                                        <div style="">

                                            <input type="text" class="js-input-mask form-control" value="{{$link->link}}" name="links[]" placeholder="Enter email" aria-label="Enter email">


                                        </div>
                                    @endforeach
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


                    </form>

                </div>
            </div>
        @endforeach
    </div>



@endsection

@section('script')

    <script>
        function generate_vocabulary_view(){
            var modal = new bootstrap.Modal(document.getElementById('exampleModalCenter'));
            modal.show();
        }
    </script>


    <script>
        document.querySelector('.generate-vocabulary-button')?.addEventListener('click', function(e) {
            e.preventDefault();

            const form = document.querySelector('.generate-vocabulary');
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
        let testIndex = 30; // можешь заменить на реальное количество или считать по DOM
        let nextId = testIndex + 1;

        document.getElementById('add-test-btn').addEventListener('click', function () {
            const navList = document.getElementById('nav-nav');
            const tabContent = document.getElementById('tab-content');

            const navId = `test_nav${nextId}`;
            const tabId = `tab${nextId}`;

            // Добавляем новую вкладку
            navList.innerHTML += `
            <li class="nav-item">
                <a class="nav-link"
                   id="${navId}"
                   href="#${tabId}"
                   data-bs-toggle="pill"
                   data-bs-target="#${tabId}"
                   role="tab"
                   aria-controls="${tabId}"
                   aria-selected="false">
                    Лексия ${nextId}
                </a>
            </li>
        `;

            // Добавляем контент новой вкладки
            tabContent.innerHTML += `
            <div class="tests_list card tab-pane fade"
                 id="${tabId}"
                 role="tabpanel"
                 style="width: 1000px; margin-left: 20px; background-color: #d6e1f1;"
                 aria-labelledby="${navId}">
                <div class="card-body" data-name="${nextId}">
                    Контент теста ${nextId}
                </div>
            </div>
        `;

            // Активируем новую вкладку
            const newTab = new bootstrap.Tab(document.getElementById(navId));
            newTab.show();

            nextId++;
        });
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
            formData.append('dir', 'vocabulary'); // вот так правильно передаётся папка

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
    <style>
        .lucide-icon-small {
            width: 16px;
            height: 16px;
        }
    </style>

    <script>
        lucide.createIcons();
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
    <script>
        document.querySelector('.js-save-form')?.addEventListener('click', () => {
            const activeTab = document.querySelector('.vocabulary_class.show.active');
            console.log(activeTab);
            const activeCard = activeTab.querySelector('.card-body');
            const form = activeCard?.querySelector('form.vocabulary-form');

            if (!form) {
                alert('Форма не найдена');
                return;
            }

            // Сохраняем данные из TinyMCE в textarea
            if (window.tinymce) tinymce.triggerSave();

            const formData = new FormData(form);
            const action = form.getAttribute('action');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                body: formData
            })
                .then(res => res.ok ? res.json() : Promise.reject(res))
                .then(data => {
                    alert('✅ Успешно сохранено!');
                })
                .catch(err => {
                    console.error(err);
                    alert('❌ Ошибка при сохранении');
                });
        });
    </script>

@endsection
