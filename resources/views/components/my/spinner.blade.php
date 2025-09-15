<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        color: #2c3e50;
        overflow: hidden;
        position: relative;
    }

    .container {
        margin-top: 7%;
        text-align: center;
        padding: 2.5rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 24px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(5px);
        position: relative;
        z-index: 1;
        max-width: 500px;
        width: 90%;
        border: 1px solid rgba(160, 210, 235, 0.2);
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    h1 {
        margin-bottom: 1.8rem;
        font-weight: 400;
        letter-spacing: 1.5px;
        color: #3498db;
        font-size: 1.8rem;
        text-transform: uppercase;
    }

    .spinner-container {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto 2.2rem;
    }

    .neural-core {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: radial-gradient(circle, #a0d2eb 0%, #7ab3e6 100%);
        box-shadow: 0 0 20px rgba(160, 210, 235, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #ffffff;
        font-weight: 500;
        font-size: 11px;
        z-index: 10;
        animation: pulse 2s infinite alternate;
    }

    .orbital-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 150px;
        height: 150px;
        border: 1.5px solid rgba(52, 152, 219, 0.15);
        border-radius: 50%;
        animation: rotate 15s infinite linear;
    }

    .orbital-ring:nth-child(2) {
        width: 130px;
        height: 130px;
        animation-duration: 12s;
        animation-direction: reverse;
    }

    .orbital-ring:nth-child(3) {
        width: 110px;
        height: 110px;
        animation-duration: 10s;
    }

    .orbital-ring::before {
        content: '';
        position: absolute;
        top: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 12px;
        height: 12px;
        background: #3498db;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(52, 152, 219, 0.4);
    }

    .data-particle {
        position: absolute;
        width: 6px;
        height: 6px;
        background: #3498db;
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.4);
        opacity: 0;
        animation: float 3s infinite;
    }

    .connection-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 1px solid transparent;
        border-top: 1px solid rgba(52, 152, 219, 0.1);
        animation: rotate 8s infinite linear;
    }

    .connection-line:nth-child(2) {
        animation-duration: 10s;
        animation-direction: reverse;
        border-top: 1px solid rgba(52, 152, 219, 0.08);
    }

    .progress-text {
        margin-top: 1.8rem;
        font-size: 1.1rem;
        letter-spacing: 0.8px;
        color: #34495e;
        font-weight: 400;
    }

    .progress-bar {
        height: 6px;
        width: 100%;
        background: rgba(52, 152, 219, 0.1);
        border-radius: 4px;
        margin-top: 15px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #a0d2eb, #3498db);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .message {
        margin-top: 1.5rem;
        font-size: 0.95rem;
        color: #3498db;
        min-height: 40px;
        font-weight: 300;
        transition: opacity 0.5s ease;
    }

    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0;
    }

    .floating-element {
        position: absolute;
        background: rgba(52, 152, 219, 0.03);
        border-radius: 50%;
        animation: floatElement 20s infinite linear;
    }

    @keyframes pulse {
        0% {
            transform: translate(-50%, -50%) scale(1);
            box-shadow: 0 0 20px rgba(160, 210, 235, 0.5);
        }
        100% {
            transform: translate(-50%, -50%) scale(1.05);
            box-shadow: 0 0 25px rgba(160, 210, 235, 0.7);
        }
    }

    @keyframes rotate {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }
        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(-80px) rotate(360deg);
            opacity: 0;
        }
    }

    @keyframes floatElement {
        0% {
            transform: translateY(0) rotate(0deg);
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
        }
    }
    @media (max-width: 480px) {
        .container {
            margin-top: 23%;
        }
    }
</style>
<div class="floating-elements">
    <div class="floating-element" style="width: 80px; height: 80px; top: 10%; left: 20%; animation-duration: 25s;"></div>
    <div class="floating-element" style="width: 40px; height: 40px; top: 70%; left: 80%; animation-duration: 20s; animation-delay: -5s;"></div>
    <div class="floating-element" style="width: 60px; height: 60px; top: 60%; left: 10%; animation-duration: 30s; animation-delay: -10s;"></div>
</div>

<div class="container">
    <h1>Генерация</h1>

    <div class="spinner-container" id="spinner-container">
        <div class="neural-core">AI</div>
        <div class="orbital-ring"></div>
        <div class="orbital-ring"></div>
        <div class="orbital-ring"></div>
        <div class="connection-line"></div>
        <div class="connection-line"></div>
    </div>

    <div class="progress-text">Обработка данных...</div>
    <div class="progress-bar">
        <div class="progress-fill" id="progress-fill"></div>
    </div>

    <div class="message" id="message">Инициализация нейронных связей</div>


</div>


<script>
    // Создание частиц данных
    const spinnerContainer = document.querySelector('.spinner-container');
    const messages = [
        "Загрузка анализа данных",
        "Формирование базы знаний",
        "Подготовка информационной базы",
        "Обработка и проверка информации",
        "Формирование результатов"
    ];

    // Создание частиц
    for (let i = 0; i < 16; i++) {
        const particle = document.createElement('div');
        particle.classList.add('data-particle');

        // Случайная позиция
        const angle = Math.random() * Math.PI * 2;
        const distance = 50 + Math.random() * 40;
        const x = 90 + Math.cos(angle) * distance;
        const y = 90 + Math.sin(angle) * distance;

        particle.style.left = `${x}px`;
        particle.style.top = `${y}px`;

        // Случайная задержка анимации
        const delay = Math.random() * 5;
        const duration = 2.5 + Math.random() * 1.5;

        particle.style.animation = `float ${duration}s ${delay}s infinite`;

        spinnerContainer.appendChild(particle);
    }

    // Смена сообщений
    let messageIndex = 0;
    const messageElement = document.getElementById('message');
    const progressFill = document.getElementById('progress-fill');
    let isFinished = false;
    let messageInterval;
    let progressInterval;

    // Функция для обновления сообщения
    function updateMessage() {
        if (isFinished) return;

        messageElement.style.opacity = 0;
        setTimeout(() => {
            messageElement.textContent = messages[messageIndex];
            messageElement.style.opacity = 1;
            messageIndex = (messageIndex + 1) % messages.length;
        }, 500);
    }

    // Функция для обновления прогресс-бара (только до 95%)
    function updateProgress() {
        if (isFinished) return;

        const currentWidth = parseFloat(progressFill.style.width) || 0;
        if (currentWidth < 95) {
            progressFill.style.width = (currentWidth + 0.5) + '%';
        }
    }

    // Начальное сообщение
    updateMessage();

    // Смена сообщений каждые 3 секунды
    messageInterval = setInterval(updateMessage, 3000);

    // Обновление прогресс-бара каждые 100ms
    progressInterval = setInterval(updateProgress, 100);

    // Функция finish - завершает процесс
    function finish() {
        if (isFinished) return;

        isFinished = true;
        clearInterval(messageInterval);
        clearInterval(progressInterval);

        // Устанавливаем прогресс-бар на 100%
        progressFill.style.width = '100%';

        // Меняем сообщение на завершающее
        messageElement.style.opacity = 0;
        setTimeout(() => {
            messageElement.textContent = "Генерация завершена!";
            messageElement.style.opacity = 1;
        }, 500);

        console.log("Процесс завершен вызовом finish()");
    }

    // Плавное появление контейнера
    window.addEventListener('load', () => {
        const container = document.querySelector('.container');
        if (container) {
            container.style.opacity = 1;
            container.style.transform = 'translateY(0)';
        }
    });

    // Экспортируем функцию finish в глобальную область видимости
    window.finish = finish;
</script>
