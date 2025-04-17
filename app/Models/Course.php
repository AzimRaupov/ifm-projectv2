<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable=['user_id','topic','freetime','date_start','step','logo'];

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
