<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepStudent extends Model
{
    protected $fillable=['user_id','step_id','status','course_id','ex'];
}
