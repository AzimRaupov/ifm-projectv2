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
