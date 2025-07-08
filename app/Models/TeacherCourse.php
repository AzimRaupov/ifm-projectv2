<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    protected $fillable=['course_id','user_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
