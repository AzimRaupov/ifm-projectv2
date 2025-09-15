<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{


    public function courses(Request $request)
    {
        $user = User::query()->find($request->id);

        $courses = Course::query()
            ->with(['students' => function ($query) {
                $query->select(
                    'student_courses.user_id',
                    'student_courses.course_id',
                    'student_courses.status',
                    'student_courses.complete',
                    'student_courses.created_at',
                    'student_courses.exp',
                    'users.id as user_id',
                    'users.name',
                    'users.photo'
                )
                    ->join('users as u', 'student_courses.user_id', '=', 'u.id');
            }])
            ->where('user_id', $user->id)
            ->where('type', 'public')
            ->get();

        foreach ($courses as $course) {
            $course->total_students = $course->students->count();
            $course->active_students = $course->students->where('pivot.status', 1)->count();
            $course->inactive_students = $course->total_students - $course->active_students;
        }

        return view('teacher.account.courses', compact('courses', 'user'));


    }

    public function updateBasic(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'bio'   => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // до 5MB
        ]);


        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? $user->bio;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('avatars', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Изменения сохранены!');
    }


    public function updatePass(Request $request)
    {
        $user = Auth::user();

        // Валидация
        $request->validate([
            'currentPassword'      => 'required',
            'newPassword'          => 'required|min:6|confirmed',
        ], [
            'newPassword.confirmed' => 'Пароли не совпадают',
        ]);

        // Проверяем текущий пароль
        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->withErrors(['currentPassword' => 'Неверный текущий пароль']);
        }

        // Меняем пароль
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return back()->with('success', 'Пароль успешно изменён!');
    }

    public function deleteAcc(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'confirm' => 'accepted',
        ], [
            'confirm.accepted' => 'Вы должны подтвердить удаление аккаунта',
        ]);

        Auth::logout();

        $user->delete();
return redirect('/');
    }

}
