<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestStudent extends Model
{
    protected $fillable=['user_id','test_id','step_id','view','verdict','score'];
}
