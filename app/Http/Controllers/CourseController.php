<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Models\Course;
use App\Models\Step;
use App\Models\StudentCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GenerateRodmap;
use Illuminate\Support\Str;
use function Pest\Laravel\json;
use setasign\Fpdi\Fpdi;
use tFPDF;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function certificate(Request $request)
    {
        $name = "Азим";
        $surname = "Иванов";

        // FPDI на базе tFPDF
        // создаем собственный класс-наследник
        $pdf = new class extends Fpdi {
            public function __construct()
            {
                parent::__construct();
            }
        };

        // Загружаем PDF-шаблон
        $pageCount = $pdf->setSourceFile(storage_path('app/certificate.pdf'));
        $templateId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($templateId);

        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($templateId);

        // 🔹 Подключаем TTF-шрифт напрямую
        $pdf->SetFont('Arial', 'B', 36);
        $pdf->SetFont('Arial', '', 28);
        $pdf->SetTextColor(0, 0, 0);

        // Координаты текста
        $pdf->SetXY(70, 150);
        $pdf->Write(10, "$name $surname");

        // Отдаём PDF в браузер
        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="certificate.pdf"');
    }    public function index()
    {

    }

    public function create()
    {
        return view('course.create');
    }

    public function store(CreateCourseRequest $request)
    {
       $user=Auth::user();
        $date_start=Carbon::today();
      $map=GenerateRodmap::generateDescriptionn($request,$user);
      dd($map);

    }
function progress(Request $request)
{
    $complete=0;
    $course = Course::where('id', $request->id)
        ->with([
            'skills',
            'steps',
            'step_student'=>function ($q) {
                $q->where('status','1');
            }
        ])
        ->first();
    $complete=count($course->step_student);
    $complete = count($course->steps) > 0 ? round(($complete / count($course->steps)) * 100, 2) : 0;
    return view('course.progress',compact(['course','complete']));

}
    public function show(Request $request)
    {
        $user=Auth::user();
        $course = Course::query()
            ->where('id', $request->input('id'))
            ->firstOrFail();
        $student_course=StudentCourse::query()->where('user_id',$user->id)->where('course_id',$course->id)->first();

            return view('course.show_rodmap',compact('course','student_course'));


    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
