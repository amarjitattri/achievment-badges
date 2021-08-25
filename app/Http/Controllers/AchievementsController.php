<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {     
        $getAchievements = Achievement::GetAchievements($user);

        return response()->json([
            'unlocked_achievements' => $getAchievements['unlocked_achievements'],
            'next_available_achievements' => $getAchievements['next_available_achievements'],
            'current_badge' => $getAchievements['current_badge'],
            'next_badge' => $getAchievements['next_badge'],
            'remaing_to_unlock_next_badge' => $getAchievements['remaing_to_unlock_next_badge']
        ]);
    }
}
