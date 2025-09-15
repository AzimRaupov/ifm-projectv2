<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сертификат</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- QRCode.js -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <style>
        :root {
            --primary-blue: #4f9cf9;
            --light-blue: #e8f0fe;
            --dark: #1f2937;
            --paper: #ffffff;
        }

        body {
            font-family: "Inter", sans-serif;
            background: #f0f4f8;
            padding: 2rem;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }

            .certificate-wrap {
                margin: 0;
                width: 100%;
                height: auto;
                padding: 20mm;
                box-shadow: none;
                border-radius: 0;
                border: none;
            }

            .no-print {
                display: none !important;
            }
        }

        .certificate-wrap {
            max-width: 900px;
            margin: auto;
            background: var(--paper);
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            border-top: 12px solid var(--primary-blue);
        }

        .watermark {
            position: absolute;
            font-size: 140px;
            color: rgba(79, 156, 249, 0.08);
            font-family: "Playfair Display", serif;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            pointer-events: none;
            user-select: none;
            z-index: 1;
        }

        .cert-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .course-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--light-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            font-size: 36px;
            color: var(--primary-blue);
            font-weight: bold;
        }

        .course-icon img {
            width: 70%;
            height: 70%;
            object-fit: contain;
        }

        .cert-title {
            font-family: "Playfair Display", serif;
            font-size: 32px;
            color: var(--dark);
            margin: 0;
        }

        .cert-sub {
            font-size: 14px;
            color: #4b5563;
            margin: 2px 0 0;
        }

        .recipient {
            text-align: center;
            margin: 30px 0;
            position: relative;
            z-index: 2;
        }

        .recipient h2 {
            font-family: "Playfair Display", serif;
            font-size: 36px;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .recipient p {
            font-size: 16px;
            color: #374151;
        }

        /* Новая секция для описания курса */
        .course-description {
            background: rgba(79, 156, 249, 0.05);
            border-left: 4px solid var(--primary-blue);
            padding: 20px 25px;
            margin: 25px 0;
            border-radius: 8px;
            position: relative;
            z-index: 2;
        }

        .course-description h5 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .course-description p {
            color: #374151;
            line-height: 1.6;
            margin: 0;
            font-size: 14px;
        }

        /* Секция для ключевых навыков */
        .skills-section {
            margin: 25px 0;
            position: relative;
            z-index: 2;
        }

        .skills-title {
            text-align: center;
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }

        .skill-tag {
            background: var(--light-blue);
            color: var(--primary-blue);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .details {
            display: flex;
            justify-content: space-around;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .detail-box {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: var(--light-blue);
            border-radius: 12px;
            min-width: 150px;
        }

        .detail-box h6 {
            font-size: 12px;
            color: var(--primary-blue);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .detail-box p {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .signature {
            width: 45%;
            text-align: center;
            margin-top: 20px;
        }

        .sig-line {
            border-top: 1px solid rgba(0,0,0,0.2);
            padding-top: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
            color: #6b7280;
            position: relative;
            z-index: 2;
        }

        .qr-container {
            text-align: center;
            margin-top: 25px;
            position: relative;
            z-index: 2;
        }

        @media (max-width: 767px) {
            .signature { width: 100%; }
            .details { flex-direction: column; }
            .skills-list { justify-content: flex-start; }
        }
    </style>
</head>
<body>

<div class="certificate-wrap">
    <div class="watermark">СЕРТИФИКАТ</div>

    <div class="cert-header">
        <div class="course-icon">
<img src="{{$course->logo}}">
        </div>
        <div>
            <h1 class="cert-title">Сертификат об окончании</h1>
            <p class="cert-sub">Подтверждает, что участник успешно завершил курс</p>
        </div>
    </div>

    <div class="recipient">
        <h2 id="recipient-name">{{$user->name}}</h2>
        <p id="course-name" style="font-size: 19px;">«{{$course->topic}}»</p>
    </div>

    <!-- Новая секция описания курса -->
    <div class="course-description">
        <h5>Обучение:</h5>
        <p>Поздравляем! Участник {{$user->name}} успешно завершил курс «{{$course->topic}}». Он продемонстрировал отличные навыки и заработал {{$course_s->exp}} очков опыта из {{$course->ex}}, показав превосходный результат!  И теперь получает сертификат об успешном окончании курса. Желаем {{$user->name}} дальнейших успехов в обучении!</p>    </div>

    <!-- Секция ключевых навыков -->
    <div class="skills-section">
        <div class="skills-title">Полученные навыки:</div>
        <div class="skills-list">

           @foreach($course->skills as $skill)
            <span class="skill-tag">{{$skill->skill}}</span>
            @endforeach
        </div>
    </div>

    <div class="details">
        <div class="detail-box">
            <h6>Дата окончания</h6>
            <p id="date">15 марта 2025</p>
        </div>
        <div class="detail-box">
            <h6>Номер сертификата</h6>
            <p id="cert-no">WB-2025-0001</p>
        </div>
        <div class="detail-box">
            <h6>Часы</h6>
            <p id="hours">48 академических часов</p>
        </div>
    </div>


</div>

<div class="container mt-4 text-center no-print">
    <div class="alert alert-info mb-3">
        <strong>Инструкция:</strong> Нажмите на любой текст для редактирования. Двойной клик по навыкам - удаление.
    </div>
    <button class="btn btn-primary me-2" onclick="window.print()">🖨️ Печать / Сохранить PDF</button>
    <button class="btn btn-outline-secondary" onclick="downloadHTML()">💾 Скачать HTML</button>
</div>

<script>
    function downloadHTML() {
        const blob = new Blob([document.documentElement.outerHTML], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'certificate.html';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrContainer = document.getElementById('qrcode');
        const text = 'https://example.com/verify/WB-2025-0001';

        const canvas = document.createElement('canvas');
        QRCode.toCanvas(canvas, text, { width: 150 }, function (error) {
            if (error) console.error(error);
            qrContainer.appendChild(canvas);
        });
    });
</script>

</body>
</html>
