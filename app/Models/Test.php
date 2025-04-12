<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable=['text','step_id','type_test','correct','score','variants','view','list1','list2','skill_id','verdict'];
    protected $casts = ['variants' => 'array','correct' => 'array','list1'=>'array','list2'=>'array'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

}
