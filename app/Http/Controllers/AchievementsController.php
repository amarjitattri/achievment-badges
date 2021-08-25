<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {     
        return response()->json([
            'unlocked_achievements' => $user->achievements->toArray(),
            'next_available_achievements' => Achievement::NextAvailableAchievements($user)->toArray(),
            'current_badge' => '',
            'next_badge' => '',
            'remaing_to_unlock_next_badge' => 0
        ]);
    }
}
