<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable=['vocabulary_step_id','link','step_id'];
}
