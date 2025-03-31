@extends('layouts.app')

@section('content-main')

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        #container {
            position: relative;
            width: 100%;
            height: auto;
            padding: 100px;
            border: 2px solid #ccc;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px; /* увеличили пространство между строками */
        }

        .block {
            width: 210px; /* увеличили ширину блока */
            height: 60px; /* увеличили высоту блока */
            padding: 0px;
            line-height: 60px; /* выравнивание текста по центру */
            text-align: center;
            border-radius: 8px;
            background-color: #3498db;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .block:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .context-menu {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            z-index: 1000;
            display: none;
            border-radius: 5px;
        }

        .context-menu button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            cursor: pointer;
            text-align: left;
            border-radius: 5px;
            font-weight: bold;
            color: #333;
            transition: background-color 0.2s ease;
        }

        .context-menu button:hover {
            background-color: #e9ecef;
        }

        /* Для стрелок соединений */
        .jsplumb-connector {
            transition: all 0.3s ease;
        }

        /* Применим плавное изменение соединений */
        .jsplumb-connector:hover {
            stroke-width: 3px;
            stroke: #3498db;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.6/js/jsplumb.min.js"></script>

<h1>Дорожная карта</h1>
<div id="container"></div>

<!-- Контекстное меню -->
<div id="context-menu" class="context-menu">
    <button onclick="editBlock()">Узнать</button>
    <button onclick="deleteBlock()">Поиск</button>
    <button onclick="viewDetails()">Посмотреть детали</button>
</div>

<script >
    let selectedBlock = null;

    // Функция для создания дорожной карты
    function createTree(data) {
        const container = document.getElementById("container");
        const rows = [];
        let currentRow = [];

        // Разделяем данные на строки по 3 элемента
        data.forEach((step, index) => {
            currentRow.push(step);
            if (currentRow.length === 3 || index === data.length - 1) {
                rows.push(currentRow);
                currentRow = [];
            }
        });

        // Создаем блоки для каждой строки
        rows.forEach((row, rowIndex) => {
            const rowDiv = document.createElement("div");
            rowDiv.className = "row";

            row.forEach((step, stepIndex) => {
                const block = document.createElement("div");
                block.id = `block-${rowIndex}-${stepIndex}`;
                block.className = "block";
                block.textContent = step.title;

                // Добавляем обработчик клика
                block.addEventListener("click", function (event) {
                    event.stopPropagation(); // Предотвращаем закрытие меню

                    // Сохраняем выбранный блок
                    selectedBlock = { id: block.id, title: step.title };

                    // Показываем меню рядом с блоком
                    const menu = document.getElementById("context-menu");
                    menu.style.display = "block";
                    menu.style.top = `${event.clientY}px`;
                    menu.style.left = `${event.clientX}px`;
                });

                rowDiv.appendChild(block);
            });

            container.appendChild(rowDiv);

            // Соединяем блоки внутри строки
            for (let i = 0; i < row.length - 1; i++) {
                jsPlumb.connect({
                    source: `block-${rowIndex}-${i}`,
                    target: `block-${rowIndex}-${i + 1}`,
                    anchors: ["Right", "Left"],
                    connector: "Straight", // Прямая линия
                    paintStyle: { stroke: "#3498db", strokeWidth: 2 }, // Цвет линии и толщины
                    endpointStyle: { fill: "#3498db", radius: 4 }, // Конечные точки
                    hoverPaintStyle: { stroke: "#3498db", strokeWidth: 3 } // Плавный эффект при наведении
                });
            }

            // Соединяем второй блок текущей строки с вторым блоком следующей строки
            if (rowIndex > 0 && rows[rowIndex][1] && rows[rowIndex - 1][1]) {
                const secondBlockInPreviousRow = `block-${rowIndex - 1}-1`; // Второй блок предыдущей строки
                const secondBlockInCurrentRow = `block-${rowIndex}-1`; // Второй блок текущей строки

                jsPlumb.connect({
                    source: secondBlockInPreviousRow,
                    target: secondBlockInCurrentRow,
                    anchors: ["Bottom", "Top"],
                    connector: "Straight", // Прямая линия
                    paintStyle: { stroke: "#3498db", strokeWidth: 2 }, // Цвет линии и толщины
                    endpointStyle: { fill: "#3498db", radius: 4 } // Конечные точки
                });
            }
        });
    }

    // Закрытие меню при клике вне его
    document.addEventListener("click", function () {
        const menu = document.getElementById("context-menu");
        menu.style.display = "none";
    });

    // Функции для действий меню
    function editBlock() {
        if (selectedBlock) {
            alert(`Редактирование блока: ${selectedBlock.title}`);
        }
    }

    function deleteBlock() {
        if (selectedBlock) {
            const blockElement = document.getElementById(selectedBlock.id);
            if (blockElement) {
                blockElement.remove();
                alert(`Блок удален: ${selectedBlock.title}`);
            }
        }
    }

    function viewDetails() {
        if (selectedBlock) {
            alert(`Детали блока: ${selectedBlock.title}`);
        }
    }

    // Пример AJAX-запроса
    $.ajax({
        url: "{{ route('get.steps', $course->id) }}",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        contentType: "application/json",
        data: JSON.stringify({}),
        success: function(data) {
            console.log(data);
            createTree(data); // Создаем дорожную карту
        },
        error: function(xhr, status, error) {
            console.error("Ошибка:", error);
            console.error("Status:", status);
            console.error("Response:", xhr.responseText);
        }
    });


</script>


@endsection
