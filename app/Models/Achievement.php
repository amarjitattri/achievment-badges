<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'level', 'type'];   

    public function unlockAchievement(User $user)
    {
        $this->users()->attach($user);
    }

    public function users() 
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeNextAvailableAchievements($query, $user) 
    {
        $achievements = $this->orderBy('id')->get();
        $userAchievementsGroupBy = $user->achievements->groupBy('type');

        //get next next Lesson Watched Achievment
        $lastLessonWatchedAchievmentId = $userAchievementsGroupBy['lesson']->last()->id;
        $nextLessonWatchedAchievment = $achievements->where('id', '>', $lastLessonWatchedAchievmentId)
        ->where('type', '=', 'lesson')
        ->first();

        //get next next Comment Watched Achievment
        $nextCommentWrittenAchievmentId = $userAchievementsGroupBy['lesson']->last()->id;
        $nextCommentWrittenAchievment = $achievements->where('id', '>', $nextCommentWrittenAchievmentId)
        ->where('type', '=', 'watched')
        ->first();

        $nextAchievements = collect([
            $nextLessonWatchedAchievment,
            $nextCommentWrittenAchievment,
        ]);
        
        return $nextAchievements->filter();
    }
    
}
