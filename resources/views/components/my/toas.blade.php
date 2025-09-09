<style>
    /* Общие стили тостов */
    .toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 12px 20px;
        border-radius: 12px;
        font-family: Arial, sans-serif;
        font-weight: 500;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease, transform 0.4s ease;
        min-width: 220px;
        z-index: 9999;
    }

    .toast.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(-50%) translateY(0);
    }

    .toast svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    /* Тост успеха — новый цвет */
    #successToast {
        background-color: #5cb85c; /* мягкий зелёный */
        color: #fff;
    }

    /* Тост ошибки — как раньше */
    #errorToast {
        background-color: #f08a8a; /* мягкий красный */
        color: #fff;
    }
</style>
<!-- Тост успеха -->
<div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M13.485 1.929a.75.75 0 0 1 0 1.06L6.72 9.754a.75.75 0 0 1-1.06 0L2.515 6.609a.75.75 0 0 1 1.06-1.06l2.088 2.09 6.703-6.712a.75.75 0 0 1 1.06 0z"/>
    </svg>
    <span id="successMessage">Успешно сохранено!</span>
</div>
<!-- Тост ошибки -->
<div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 12.5A5.5 5.5 0 1 1 8 2.5a5.5 5.5 0 0 1 0 11zm-.75-8a.75.75 0 0 1 1.5 0v3a.75.75 0 0 1-1.5 0v-3zm.75 5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5z"/>
    </svg>
    <span id="errorMessage">Произошла ошибка!</span>
</div>


