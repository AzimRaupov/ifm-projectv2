<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\Test;

class GetTest
{
   public static function get_test($id)
   {
       $course=Course::query()->where('id',$id)->
       with('steps')->firstOrFail();

       foreach ($course->steps as $list){
           $d=Test::query()->where('step_id',$list->id)->where('view',0)->first();
           if ($d) {
               return ['test' => $d, 'step' => $list];
           }
          else{
              return ['test'=>null,'step'=>$list];
          }
       }


   }
}
