<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class UserController extends Controller
{
    public function ping()
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $activity = UserActivity::query()
            ->where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();
        if ($activity) {
            if ($activity->updated_at->diffInMinutes(now()) >= 1) {
                $activity->increment('minutes', 1);
                $activity->touch(); }
        } else {
            $activity = UserActivity::query()->create([
                'user_id'  => $user->id,
                'date'     => $today,
                'minutes'  => 1,
            ]);
        }
        return response()->json(['minutes' => $activity->minutes]);
    }
}
