<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepHeir extends Model
{

    protected $fillable=['step_id','course_id','title','experience','test_id','heirs','type','description'];

    protected $casts=['skills'=>'array','heirs'=>'array'];

}
