<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
            background-color: #f8f8f8;
        }
        canvas {
            max-width: 500px;
        }
    </style>
</head>
<body>
<canvas id="radarChart"></canvas>

<script>
    const ctx = document.getElementById('radarChart').getContext('2d');

    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Speed', 'Acceleration', 'Conso', 'Style', 'Price'],
            datasets: [{
                label: 'Car Performance',
                data: [75, 90, 40, 30, 35],
                backgroundColor: 'rgba(255, 0, 255, 0.2)',
                borderColor: 'magenta',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    suggestedMin: 0,
                    suggestedMax: 100,
                    grid: { color: 'rgba(0,0,0,0.1)' }
                }
            }
        }
    });
</script>
</body>
</html>
