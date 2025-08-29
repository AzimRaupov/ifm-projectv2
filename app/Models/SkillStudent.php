<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillStudent extends Model
{
    protected $fillable=['skill_id','user_id','course_id','score'];
}
