<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 40px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h1, h2 { page-break-after: avoid; }
        .page-break { page-break-after: always; }
        * {
            font-family: "DejaVu Sans", sans-serif !important;
        }

    </style>
</head>
<body>

{{-- Обложка --}}
<div style="text-align: center; margin-top: 200px;">
    <h1>{{ $course->topic }}</h1>
    <p>Автоматически сгенерировано</p>
</div>

<div class="page-break"></div>

{{-- Шаги --}}
@foreach($course->steps as $step)
    <h2>{{ $step->title }}</h2>
       @foreach($step->vocabularies as $vocabulary)
           <h3>{{$vocabulary->title}}</h3>
              <p> {!! $vocabulary->text !!}</p>

       @endforeach

    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
