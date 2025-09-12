<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable=['user_id','topic','type','freetime','date_start','step','logo','level'];




    public function teacher()
    {
        return $this->belongsTo(User::class,'user_id');

    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    public function step_student()
    {
        return $this->hasMany(StepStudent::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_courses')
            ->withPivot(['status','complete','created_at','exp']);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }
}
