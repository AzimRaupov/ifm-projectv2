<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable=['text','course_id','step_id','type_test','score','view','skill_id','verdict'];
    protected $casts = ['variants' => 'array','correct' => 'array','list1'=>'array','list2'=>'array'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
    public function step()
    {
        return $this->belongsTo(Step::class);
    }
    public function lists1()
    {
        return $this->hasMany(MatchingList1::class);
    }
    public function lists2()
    {
        return $this->hasMany(MatchingList2::class);
    }
    public function variantss()
    {
           return $this->hasMany(Variant::class);
    }
    public function corrects()
    {
        return $this->hasMany(VariantTrue::class);
    }
}
