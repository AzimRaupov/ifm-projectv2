<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary_Student extends Model
{
    protected $fillable=['user_id','vocabulary_id','status','step_id'];
}
