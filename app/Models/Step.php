<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable=['parent_id','course_id','title','experience','test_id','heirs','type','description','sort'];

    protected $casts=['skills'=>'array','heirs'=>'array'];

    public function test(){
        return $this->hasMany(Test::class);
    }
    public function step_heirs()
    {
        return $this->hasMany(Step::class,'parent_id');
    }
    public function course()
    {
       return $this->belongsTo(Course::class);
    }
    public function links()
    {
        return $this->hasMany(Link::class);
    }
    public function vocabularies()
    {
        return $this->hasMany(VocabularyStep::class);
    }
}
