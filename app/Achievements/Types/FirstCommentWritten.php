<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class FirstCommentWritten extends AchievementsType {

    public $type = 'comment'; //comment or lesson

    public function qualifier($user)
    {
        if (isset($user->comments) && $user->comments->count() >= 1) {

            //fired achievement unlocked event
            event(new AchievementUnlocked($this->name(), $user));
            
            return true;
        }
        return false;
    }

}