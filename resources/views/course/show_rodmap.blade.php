@extends('layouts.app')
@section('icon')
    {{$course->logo}}
@endsection
@section('title')
    {{$course->topic}}
@endsection
@section('head')
     <script src="{{asset('js/main.js')}}"></script>
@endsection
@section('content-main')
    @include('components.my.modal1')

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 fw-bold mb-2 text-primary">
                        {{$course->topic}}
                    </h1>
                    <p class="mb-0 text-muted">
                        <span id="student_exp" class="fw-semibold text-success">{{$student_course->exp}}</span>
                        / {{$course->ex}} <small class="text-secondary">exp</small>
                    </p>
                </div>

                <div class="col-auto">
                    @if($course->step==$student_course->complete)
                    <a class="btn btn-outline-primary" href="{{route('course.certificate',['id'=>$course->id])}}" >
                        <i class="bi bi-award"></i>                        Получить сертификат
                    </a>
                    @endif
                    <a class="btn btn-outline-primary" href="{{route('course.progress',['id'=>$course->id])}}" >
                        <i class="bi bi-graph-up"></i>

                        Прогресс
                    </a>
                    <a class="btn btn-outline-danger" href="{{route('course.pdf_book',['id'=>$course->id])}}" >
                        <i class="bi bi-file-earmark-pdf"></i>

                        Формат pdf
                    </a>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jsplumb@2.15.0/dist/js/jsplumb.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
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
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                <a href="t" target="_blank" class="btn btn-primary link_test col-auto me-2" style="text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 5px 15px; font-size: 14px;">
                    Пройти тест
                </a>
                <a href="z" target="_blank" class="btn btn-primary link_vocabulary col-auto" style="text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 5px 15px; font-size: 14px;">
                    Лекция

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
    @if($student_course->status==1)
<script>
    var modal = new bootstrap.Modal(document.getElementById('certificateModal'));
    modal.show();
</script>
    @endif

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

        function view(st) {
            const roadmap = document.getElementById("roadmap");
            roadmap.innerHTML = ""; // Очистить перед отрисовкой

            roadmap.classList.add("container-fluid", "px-4"); // боковые отступы

            let delay = 0;

            st.forEach((step, stepIndex) => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "mb-5 fade-in";
                    wrapper.style.maxWidth = "100%";

                    const parentRow = document.createElement("div");
                    parentRow.className = "d-flex align-items-start gap-5 p-4 mb-3 rounded-3 bg-white border shadow-sm";

                    const icon = document.createElement("div");
                    icon.className = "pt-1 flex-shrink-0";
                    icon.style.cursor = "pointer"; // чтобы было понятно, что кликабельно
                    icon.innerHTML = step.status == '1'
                        ? '<i data-lucide="check-circle" class="text-success"></i>'
                        : '<i data-lucide="circle" class="text-secondary"></i>';


                    const card = document.createElement("div");
                    card.className = "flex-grow-1";

                    card.innerHTML = `
<div>
    <h3 style="color: rgb(55, 48, 163);">${step.title}</h3>
    <small class="text-muted fs-6">+${step.experience}exp</small>
</div>
`;
                    @if($course->type=="private")
                    icon.onclick = (e) => {
                        e.stopPropagation(); // чтобы клик не распространялся на card
                        if(step.status != '1') {
                            step.status = '1'; // локально обновляем
                            icon.innerHTML = '<i data-lucide="check-circle" class="text-success"></i>';

                            reqman("{{ route('api.step.statusEdit') }}", "POST", {id:step.id,status:'1'}).then(rr => {
                                console.log(rr);
                            });
                            lucide.createIcons();
                        }
                    };
                @endif
                    card.onclick = () => {
                        create_test(step.id);
                        create_vocabulary(step.id);
                        get_description(step.id);
                        new bootstrap.Offcanvas(document.getElementById('offcanvasRight')).show();
                        document.getElementById("offcanvasRightLabel").innerText = step.title;
                    };
                    parentRow.appendChild(icon);
                    parentRow.appendChild(card);
                    wrapper.appendChild(parentRow);

                    if (step.step_heirs && step.step_heirs.length > 0) {
                        step.step_heirs.forEach((child, childIndex) => {
                                const childRow = document.createElement("div");
                                childRow.className = "d-flex align-items-start gap-4 ms-5 mb-3 fade-in p-3 rounded bg-light border shadow-sm";
                                childRow.style.maxWidth = "calc(100% - 3rem)";

                                const childIcon = document.createElement("div");
                                childIcon.className = "pt-1 flex-shrink-0";
                                childIcon.style.cursor = "pointer";
                                childIcon.innerHTML = child.status == '1'
                                    ? '<i data-lucide="check" class="text-success"></i>'
                                    : '<i data-lucide="circle" class="text-secondary"></i>';

                                // Клик по иконке дочернего шага
                         @if($course->type=="private")
                                childIcon.onclick = (e) => {
                                    e.stopPropagation(); // чтобы клик не шел на весь row
                                    if(child.status != '1') {
                                        child.status = '1'; // локально обновляем
                                        childIcon.innerHTML = '<i data-lucide="check" class="text-success"></i>';
                                        reqman("{{ route('api.step.statusEdit') }}", "POST", {id:child.id,status:'1'}).then(rr => {
                                            console.log(rr);
                                        });
                                       lucide.createIcons();
                                    }
                                };
                            @endif
                                const childCard = document.createElement("div");
                                childCard.className = "flex-grow-1";

                                childCard.innerHTML = `
<p style="font-size: 16px;color: rgb(55, 48, 163);">${child.title}</p class="h4">
    <small class="text-muted fs-6">+${step.experience}exp</small>

`;

                                childCard.onclick = () => {
                                    create_test(child.id);
                                    create_vocabulary(child.id);
                                    get_description(child.id);
                                    new bootstrap.Offcanvas(document.getElementById('offcanvasRight')).show();
                                    document.getElementById("offcanvasRightLabel").innerText = child.title;
                                };
                                childRow.appendChild(childIcon);
                                childRow.appendChild(childCard);
                                wrapper.appendChild(childRow);
                                lucide.createIcons();
                        });
                    }

                    roadmap.appendChild(wrapper);
                    lucide.createIcons();
                }, delay);


        }



    </script>
@endsection
