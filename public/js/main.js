function showSuccessToast(message = "Успешно сохранено!") {
    const toast = document.getElementById('successToast');
    toast.textContent = ""; // Очистим
    // Добавим иконку + текст заново
    toast.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M13.485 1.929a.75.75 0 0 1 0 1.06L6.72 9.754a.75.75 0 0 1-1.06 0L2.515 6.609a.75.75 0 0 1 1.06-1.06l2.088 2.09 6.703-6.712a.75.75 0 0 1 1.06 0z"/>
      </svg> ${message}
    `;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}


function formpost(form) {

        if (!form) {
        alert('Форма не найдена');
        return;
    }


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
        fetchData();
            showSuccessToast();

    })
        .catch(err => {
        console.error(err);
        // alert('❌ Ошибка при сохранении');
    });

}
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

async function reqman(url, method, body) {
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify(body),
        });

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Ошибка при загрузке шагов курса:", error);
    }
}
