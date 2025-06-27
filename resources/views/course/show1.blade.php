@extends('layouts.app')
@section('icon')
    {{$course->logo}}
@endsection
@section('title')
    {{$course->topic}}
@endsection
@section('content1')

    <style>
        main#content-main {
            position: relative;
            min-height: 100vh;
            border: 1px solid #ccc;
            overflow: auto;
        }

        .box {
            margin-top: 30px;
            width: 180px;
            min-height: 50px;
            font-size: 12px;
            position: absolute;
            background-color: #4a90e2;
            color: white;
            text-align: center;
            border-radius: 8px;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            cursor: pointer;
            word-wrap: break-word;
            white-space: normal;
            line-height: 1.2;
            padding: 8px;
            box-sizing: border-box;
        }

        .passed {
            background-color: #22c366;
        }

        path {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: drawLine 5s ease-in-out forwards;
            pointer-events: none;
        }

        @keyframes drawLine {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jsplumb@2.15.0/dist/js/jsplumb.min.js"></script>

    {{-- шторка --}}
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
            <span class="spinner-border spinner-border-sm" style="display: inline-block"></span>
            <div id="description"></div>
            <div id="links"></div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        const lv = document.querySelector('.link_vocabulary');
        let ltest = document.querySelector('.link_test');

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
            } catch (error) {
                console.error("Ошибка при загрузке шагов курса:", error);
            }
        }

        function ff(steps) {
            const container = document.querySelector('#content-main');
            let html = '';
            const parentSpacing = 150;
            const childRowHeight = 80;
            let parentIndex = 0;
            const connections = [];
            let pr = -1;

            for (let i = 0; i < steps.length; i++) {
                if (steps[i].type === 'parent') {
                    const parentTop = parentIndex * parentSpacing;
                    html += `<div id="box${i}" class="box ${steps[i].status == 1 ? 'passed' : ''}" style="top: ${parentTop}px; left: 45%; transform: translateX(-50%);">
                        ${steps[i].title}
                    </div>`;

                    if (steps[i].heirs && steps[i].heirs.length > 0) {
                        const totalHeirs = steps[i].heirs.length;
                        for (let j = 0; j < totalHeirs; j++) {
                            const row = Math.floor(j / 2);
                            const side = j % 2 === 0 ? 'left' : 'right';
                            const leftPosition = side === 'left' ? '20%' : '70%';
                            const childTop = parentTop + row * childRowHeight;

                            html += `<div id="box${steps[i].heirs[j]}" class="box ${steps[steps[i].heirs[j]].status == 1 ? 'passed' : ''}" style="top: ${childTop}px; left: ${leftPosition}; transform: translateX(-50%);">
                                ${steps[steps[i].heirs[j]].title}
                            </div>`;

                            connections.push({
                                source: `box${i}`,
                                target: `box${steps[i].heirs[j]}`,
                                anchors: [side === "left" ? 'BottomLeft' : 'BottomRight', side === "left" ? 'Right' : 'Left']
                            });
                        }
                    }

                    if (pr !== -1) {
                        connections.push({
                            source: `box${pr}`,
                            target: `box${i}`,
                            anchors: ['BottomCenter', 'TopCenter']
                        });
                    }

                    pr = i;
                    parentIndex++;
                }
            }

            container.innerHTML = html;

            animateBlocks();
            createConnections(connections);

            container.addEventListener('click', (e) => {
                const box = e.target.closest('.box');
                if (box) {
                    const index = box.id.replace('box', '');
                    const step = steps[index];
                    const title = document.getElementById('offcanvasRightLabel');

                    lv.removeAttribute("href");
                    ltest.removeAttribute("href");

                    title.textContent = step.title;
                    get_description(step.id);
                    create_vocabulary(step.id);
                    create_test(step.id);

                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
                    offcanvas.show();
                }
            });
        }

        function animateBlocks() {
            const boxes = document.querySelectorAll('.box');
            const parentBoxes = Array.from(boxes).filter(box => box.id.includes('box') && !box.classList.contains('heir'));
            const childBoxes = Array.from(boxes).filter(box => !parentBoxes.includes(box));

            parentBoxes.forEach((box, index) => {
                setTimeout(() => {
                    box.style.opacity = 1;
                    box.style.transform = 'translateY(0)';
                }, index * 150);
            });

            setTimeout(() => {
                childBoxes.forEach((box, index) => {
                    setTimeout(() => {
                        box.style.opacity = 1;
                        box.style.transform = 'translateY(0)';
                    }, index * 200);
                });
            }, parentBoxes.length * 200);
        }

        function createConnections(connections) {
            jsPlumb.ready(() => {
                jsPlumb.setContainer(document.querySelector('main#content-main'));

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

        async function get_description(step_id) {
            try {
                const offcanvasBody = document.getElementById('description');
                const spin = document.querySelector('.spinner-border-sm');
                const bllink = document.getElementById('links');
                offcanvasBody.innerHTML = ``;
                bllink.innerHTML = ``;
                spin.style = 'display: inline-block';

                const response = await fetch("{{ route('api.create.description') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: step_id }),
                });

                const data = await response.json();
                spin.style = "display: none";
                offcanvasBody.innerHTML = `${data.description}`;
                data.links.forEach(link => {
                    bllink.innerHTML += `<a href="${link.link}" target="_blank">${link.link}</a><br>`;
                });
            } catch (error) {
                console.error("Ошибка при загрузке описания:", error);
            }
        }

        function create_test(step_id) {
            fetch("{{ route('api.create.test') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: step_id }),
            }).catch(console.error);

            ltest.href = '{{ route('test.show') }}?id=' + step_id;
        }

        function create_vocabulary(step_id) {
            fetch("{{ route('api.create.vocabulary') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: step_id }),
            }).catch(console.error);

            lv.href = '{{ route('vocabulary.show') }}?id=' + step_id;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const offcanvas = document.getElementById('offcanvasRight');
            const container = document.querySelector('main#content-main');
            fetchData();

            function updateJsPlumb() {
                setTimeout(() => jsPlumb.repaintEverything(), 20);
            }

            offcanvas.addEventListener('shown.bs.offcanvas', updateJsPlumb);
            offcanvas.addEventListener('hidden.bs.offcanvas', updateJsPlumb);
            window.addEventListener('resize', updateJsPlumb);
            new ResizeObserver(updateJsPlumb).observe(container);
        });
    </script>
@endsection

