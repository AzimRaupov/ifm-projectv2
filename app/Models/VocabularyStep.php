<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocabularyStep extends Model
{
    protected $fillable=['step_id','title','text','exp','course_id'];

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
