function radar(skills)
{
    console.log(skills.title);
let ctx =
    document.getElementById('radarChart').getContext('2d');
let myRadarChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels:
            [skills.title],
        datasets: [{
            label: 'GeeksforGeeks Skills',
            data: [skills.score],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgb(87,180,204)',
            borderWidth: 2,
        }]
    },
    options: {
        scale: {
            pointLabels: {
                fontSize: 12,  // Уменьшаем размер шрифта
            },
            ticks: {
                fontSize: 10,  // Уменьшаем размер шрифта для меток оси
            }
        },
        responsive: true, // Это гарантирует, что график будет адаптивным
        maintainAspectRatio: false, // Если нужно, чтобы график заполнил контейнер
    }
});
}
