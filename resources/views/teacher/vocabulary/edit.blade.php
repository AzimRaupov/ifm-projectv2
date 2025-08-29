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
    <div class="bg-light border-bottom shadow-sm p-2 mb-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 1030;">
        <strong>🔧 Панель инструментов</strong>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
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

    <div class="js-step-form"
         style="margin: 20px"
         data-hs-step-form-options='{
        "progressSelector": "#basicVerStepFormProgress",
        "stepsSelector": "#basicVerStepFormContent",
        "endSelector": "#basicVerStepFinishBtn"
      }'>
        <div class="row">
            <div class="col-lg-3">
                <!-- Step -->
                <ul id="basicVerStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
                    @foreach($step->vocabularies as $index=>$item)

                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
              "targetSelector": "#form_step{{$item->id}}"
            }'>
                                <span class="step-icon step-icon-soft-dark {{$item->status==1 ? 'bg-warning' : ''}}" >{{$index+1}}</span>
                                <div class="step-content pb-5">
                                    <span class="step-title {{$item->status==1 ? 'text-warning' : ''}}">{{$item->title}}</span>
                                </div>
                            </a>
                        </li>

                    @endforeach
                </ul>
            </div>

            <div class="col-lg-9">
                <!-- Content Step Form -->
                <div id="basicVerStepFormContent">
                    @foreach($step->vocabularies as $index=>$item)
                        <div id="form_step{{$item->id}}" class="card card-body {{ $index === 0 ? 'active' : '' }}" style="min-height: 15rem;">


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

                    @endforeach

                </div>
            </div>
        </div>

    </div>
    <!-- End Step Form -->

@endsection

@section('script')

    <script>
        function delete_vocabulary() {
            const activeCard = document.querySelector('.card.active');
            const idv = activeCard?.querySelector('form.vocabulary-form');
            let body={
                'id':idv?.dataset.id
            };
            console.log(idv?.dataset.id);
        }
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
        document.querySelector('.js-save-form')?.addEventListener('click', () => {
            const activeCard = document.querySelector('.card.active');
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


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize HSStepForm
            new HSStepForm('.js-step-form', {
                finish: function ($el) {
                    const successMessageTemplate = $el.querySelector('.js-success-message').cloneNode(true);
                    successMessageTemplate.style.display = 'block';

                    $el.style.display = 'none';
                    $el.parentElement.appendChild(successMessageTemplate);
                }
            });
        });

    </script>
    <script>
        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = true; // обязательно, если у тебя CSRF

            xhr.open('POST', '{{ route("api.img.upload") }}');

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

@endsection


