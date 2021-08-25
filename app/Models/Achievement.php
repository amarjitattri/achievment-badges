<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'value'];   

    public function unlockAchievement(User $user)
    {
        $this->users()->attach($user);
    }

    public function users() 
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeGetAchievements($query, $user) 
    {
        $achievements = $query->orderBy('id')->get();
        $userAchievementsGroupBy = $user->achievements->groupBy('type');
        
        $unlockedAchievements = $user->achievements->whereIn('type', ['lesson', 'comment'])->toArray();
        $nextAchievements = $this->nextAvailableAchievements($userAchievementsGroupBy, $achievements)->toArray();
        $nextBadge = $this->nextBadge($userAchievementsGroupBy, $achievements);
        $nextBadge = $nextBadge ? $nextBadge->toArray() : null;
        
        $count = ($nextBadge ? $nextBadge['value'] : 0) - ($unlockedAchievements ? count($unlockedAchievements) : 0);

        return [
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAchievements,
            'current_badge' => isset($userAchievementsGroupBy['badge']) ? $userAchievementsGroupBy['badge']->toArray() : null,
            'next_badge' => $nextBadge,
            'remaing_to_unlock_next_badge' => $count
        ];
    }

    private function nextAvailableAchievements($userAchievementsGroupBy, $achievements)
    {
        $nextLessonWatchedAchievment = [];
        $nextCommentWrittenAchievment = [];

        //get next next Lesson Watched Achievment
        if (isset($userAchievementsGroupBy['lesson'])) {
            $lastLessonWatchedAchievmentId = $userAchievementsGroupBy['lesson']->last()->id;
            $nextLessonWatchedAchievment = $achievements->where('id', '>', $lastLessonWatchedAchievmentId)
            ->where('type', '=', 'lesson')
            ->first();
        }
        

        //get next Comment written Achievment
        if (isset($userAchievementsGroupBy['comment'])) {
            $nextCommentWrittenAchievmentId = $userAchievementsGroupBy['comment']->last()->id;
            $nextCommentWrittenAchievment = $achievements->where('id', '>', $nextCommentWrittenAchievmentId)
            ->where('type', '=', 'comment')
            ->first();
        }

        $nextAchievements = collect([
            $nextLessonWatchedAchievment,
            $nextCommentWrittenAchievment,
        ]);

        return $nextAchievements->filter();
    }

    private function nextBadge($userAchievementsGroupBy, $achievements)
    {
        if (isset($userAchievementsGroupBy['badge'])) {
            $nextCommentWrittenAchievmentId = $userAchievementsGroupBy['badge']->last()->id;
            return $achievements->where('id', '>', $nextCommentWrittenAchievmentId)
            ->where('type', '=', 'badge')
            ->first();
        }

        return false;
        
    }

    
    
}
