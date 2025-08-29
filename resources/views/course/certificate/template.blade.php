<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Сертификат о прохождении курса</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f0f0;
            color: #333;
        }

        .certificate {
            width: 650px; /* ~A4 width at 96dpi */
            min-height: 900px; /* ~A4 height at 96dpi */
            margin: 40px auto;
            padding: 40px 60px;
            background: #ffffff;
            border: 2px solid #00bcd4;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.4);
            text-align: center;
            position: relative;
        }

        .certificate h1 {
            font-size: 40px;
            margin-bottom: 10px;
            color: #00bcd4;
        }

        .certificate h2 {
            font-size: 22px;
            color: #555;
            margin-bottom: 30px;
        }

        .recipient {
            font-size: 28px;
            font-weight: bold;
            margin: 30px 0;
            color: #0088cc;
        }

        .course-name {
            font-size: 20px;
            color: #444;
            font-style: italic;
        }

        .message {
            font-size: 18px;
            color: #666;
            margin: 20px 0 40px;
        }

        .footer {
            display: table;
            width: 100%;
            margin-top: 50px;
            font-size: 16px;
            color: #444;
        }

        .signature {
            display: table-cell;
            text-align: center;
        }

        .line {
            border-top: 1px solid #00bcd4;
            width: 200px;
            margin: 0 auto 8px;
        }

        .ai-icon {
            position: absolute;
            top: 20px;
            right: 40px;
            width: 50px;
            opacity: 0.15;
        }

        @media print {
            body {
                background: white !important;
            }

            .certificate {
                box-shadow: none;
                border: 1px solid #999;
            }

            .ai-icon {
                display: none;
            }
        }
    </style>
</head>
<body>
<button onclick="generatePDF()" style="position: fixed; top: 20px; left: 20px; z-index: 999;">Скачать PDF</button>

<div class="certificate">
    <h1>СЕРТИФИКАТ</h1>
    <h2>о прохождении курса</h2>
    <p class="message">Подтверждается, что</p>
    <div class="recipient">{{$course->students[0]->name}}</div>
    <p class="message">успешно завершил курс</p>
    <div class="course-name">{{$course->topic}}</div>

    <p class="message">и продемонстрировал(а) высокий уровень подготовки и навыков в области ИИ</p>

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            Преподаватель
        </div>
        <div class="signature">
            <div class="line"></div>
            Дата: 02.08.2025
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function generatePDF() {
        const element = document.querySelector('.certificate');
        const opt = {
            margin:       0,
            filename:     'certificate.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
</body>
</html>
