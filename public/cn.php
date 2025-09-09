<?php
require __DIR__ . '/vendor/setasign/fpdf/makefont/makefont.php';

// Конвертируем TTF в шрифт для FPDF с поддержкой кириллицы
MakeFont(__DIR__ . '/storage/ttf/DejaVuSans.ttf', 'cp1251', true);
