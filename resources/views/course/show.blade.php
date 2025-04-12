@extends('layouts.app')

@section('content-main')

    <style>
        #containerr {
            position: relative;
            min-height: 100vh;
            border: 1px solid #ccc;
            overflow: auto; /* Добавляем прокрутку */
        }

        .box {
            margin-top: 30px;
            width: 180px; /* Фиксированная ширина */
            min-height: 50px; /* Минимальная высота */
            font-size: 12px;
            position: absolute;
            background-color: #4a90e2;
            color: white;
            text-align: center;
            border-radius: 8px;
            overflow: hidden; /* Скрываем текст, выходящий за границы */
            opacity: 0;
            transform: translateY(-20px); /* Начальная позиция для анимации */
            transition: opacity 0.5s ease-out, transform 0.5s ease-out; /* Плавная анимация */
            cursor: pointer; /* Указатель мыши как на ссылке */
            word-wrap: break-word; /* Перенос длинных слов */
            white-space: normal; /* Разрешаем перенос текста */
            line-height: 1.2; /* Межстрочный интервал */
            padding: 8px; /* Внутренние отступы */
            box-sizing: border-box; /* Учитываем padding в размерах */
        }
       .passed{
       background-color: #22c366;
       }
        /* CSS для анимации линии */
        path {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: drawLine 5s ease-in-out forwards;
            pointer-events: none; /* Линии не перехватывают клики */
        }

        /* Ключевая анимация для рисования линии */
        @keyframes drawLine {
            to {
                stroke-dashoffset: 0;
            }
        }

    </style>

    <script src="https://cdn.jsdelivr.net/npm/jsplumb@2.15.0/dist/js/jsplumb.min.js"></script>

    <div id="containerr"></div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel"></h5><br>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="margin-top: 0px">
            <div class="row" style="display: flex; align-items: center;">
                <a href="t" class="col-6 link_test" style="text-decoration: none; color: #3498db; display: flex; align-items: center; justify-content: center;">
                    Пройти тест

                </a>
                <a href="z" class="link_vocabulary col-6" style="text-decoration: none; color: #3498db; display: flex; align-items: center; justify-content: center;">
                    Лексика

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
        const lv=document.querySelector('.link_vocabulary');
        async function fetchData() {
            try {
                const response = await fetch("{{ route('get.steps', $course->id) }}", {
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
                ff(data);
                createConnections(data);
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
        function ff(steps) {
            const container = document.getElementById('containerr');
            let html = '';
            const parentSpacing = 150; // Расстояние между родительскими блоками
            const childRowHeight = 80; // Высота ряда для дочерних блоков
            let parentIndex = 0; // Счётчик родительских блоков
            const connections = []; // Массив для хранения соединений
            let pr = -1;

            for (let i = 0; i < steps.length; i++) {
                if (steps[i].type === 'parent') {
                    // Вычисляем вертикальное положение родительского блока
                    const parentTop = parentIndex * parentSpacing;
                    html += `<div id="box${i}" class="box ${steps[i].status == 1 ? 'passed' : ''}" style="top: ${parentTop}px; left: 45%; transform: translateX(-50%);">
                        ${steps[i].title}
                     </div>`;

                    // Если у родителя есть дочерние элементы
                    if (steps[i].heirs && steps[i].heirs.length > 0) {
                        const totalHeirs = steps[i].heirs.length;
                        for (let j = 0; j < totalHeirs; j++) {
                            const row = Math.floor(j / 2); // номер ряда
                            const side = j % 2 === 0 ? 'left' : 'right';
                            const leftPosition = side === 'left' ? '20%' : '70%';
                            const childTop = parentTop + row * childRowHeight;

                            html += `<div id="box${steps[i].heirs[j]}" class="box ${steps[steps[i].heirs[j]].status == 1 ? 'passed' : ''}" style="top: ${childTop}px; left: ${leftPosition}; transform: translateX(-50%);">
                                ${steps[steps[i].heirs[j]].title}
                             </div>`;

                            // Для дочерних соединений:
                            // левый дочерний: родитель (BottomCenter) -> дочерний (Right)
                            // правый дочерний: родитель (BottomCenter) -> дочерний (Left)
                            if (side === "left") {
                                connections.push({
                                    source: `box${i}`,
                                    target: `box${steps[i].heirs[j]}`,
                                    anchors: ['BottomLeft', 'Right']
                                });
                            } else {
                                connections.push({
                                    source: `box${i}`,
                                    target: `box${steps[i].heirs[j]}`,
                                    anchors: ['BottomRight', 'Left']
                                });
                            }
                        }
                    }
                    // Если есть предыдущий родитель, соединяем его с текущим родительским блоком
                    if (pr !== -1) {
                        connections.push({
                            source: `box${pr}`,
                            target: `box${i}`,
                            anchors: ['BottomCenter', 'TopCenter']
                        });
                    }
                    pr = i;
                    parentIndex++; // Переходим к следующему родительскому блоку
                }
            }

            container.innerHTML = html;

            animateBlocks();

            function animateBlocks() {
                const boxes = document.querySelectorAll('.box');

                // Разделяем блоки на родительские и дочерние
                const parentBoxes = Array.from(boxes).filter(box => {
                    return steps[box.id.replace('box', '')].type === 'parent';
                });

                const childBoxes = Array.from(boxes).filter(box => {
                    return steps[box.id.replace('box', '')].type === 'heir';
                });


                parentBoxes.forEach((box, index) => {
                    setTimeout(() => {
                        box.style.opacity = 1;
                        box.style.transform = 'translateY(0)';
                    }, index * 150);
                });

                // Появление дочерних блоков после родительских
                setTimeout(() => {
                    childBoxes.forEach((box, index) => {
                        setTimeout(() => {
                            box.style.opacity = 1;
                            box.style.transform = 'translateY(0)';
                        }, index * 200); // Задержка для каждого дочернего блока
                    });
                }, parentBoxes.length * 200); // Задержка перед появлением дочерних блоков
            }


            createConnections(connections);

            container.addEventListener('click', (e) => {
                const box = e.target.closest('.box');
                if (box) {
                    const index = box.id.replace('box', '');
                    const step = steps[index];
                    const title=document.getElementById('offcanvasRightLabel');

                    lv.removeAttribute("href");
                    ltest.removeAttribute("href");
                    title.textContent=step.title;

                    get_description(step.id);
                    create_vocabulary(step.id);
                    create_test(step.id);
                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
                    offcanvas.show();
                }
            });

        }
       let ltest=document.querySelector('.link_test');
        function createConnections(connections) {
            jsPlumb.ready(function() {
                jsPlumb.setContainer("containerr"); // Устанавливаем контейнер

                const commonSettings = {
                    connector: ['Straight', { cornerRadius: 5 }],
                    paintStyle: { stroke: '#e74c3c', strokeWidth: 3 },
                    endpoint: 'Dot',
                    endpointStyle: { fill: '#3385a3', radius: 5 },
                    overlays: [
                        ['Arrow', { location: 1, width: 12, length: 12, direction: 1, paintStyle: { fill: '#e74c3c' } }]
                    ],
                    cssClass: 'custom-line'
                };

                connections.forEach(conn => {
                    jsPlumb.connect({
                        source: conn.source,
                        target: conn.target,
                        anchors: conn.anchors,
                        ...commonSettings
                    });
                });

            });
        }
      async function create_test(step_id){
          try {

              const response =await fetch("{{ route('api.create.test') }}", {
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
              ltest.href='{{route('test.show')}}?id='+step_id;


          } catch (error) {
              console.error("Ошибка при загрузке шагов курса:", error);
          }
      }
      async function create_vocabulary(step_id){
          try {

              const response =await fetch("{{ route('api.create.vocabulary') }}", {
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
              lv.href='{{route('vocabulary.show')}}?id='+step_id;


          } catch (error) {
              console.error("Ошибка при загрузке шагов курса:", error);
          }
      }

        document.addEventListener('DOMContentLoaded', () => {
            const offcanvas = document.getElementById('offcanvasRight');
            const container = document.getElementById('containerr');
            fetchData();
            // Функция обновления соединений
            function updateJsPlumb() {
                setTimeout(() => jsPlumb.repaintEverything(), 20);
            }

            // Отслеживание открытия/закрытия шторки
            offcanvas.addEventListener('shown.bs.offcanvas', updateJsPlumb);
            offcanvas.addEventListener('hidden.bs.offcanvas', updateJsPlumb);

            // Отслеживание изменения размеров окна (например, при изменении ширины бокового меню)
            window.addEventListener('resize', updateJsPlumb);

            // Отслеживание изменений размеров контейнера (если nav изменяет его размер)
            const resizeObserver = new ResizeObserver(updateJsPlumb);
            resizeObserver.observe(container);
        });

    </script>
@endsection
