<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class FirstLessonWatched extends AchievementsType {

    public $type = 'lesson'; //comment or lesson

    public function qualifier($user)
    {
        if (isset($user->lessons) && $user->lessons->count() >= 1) {

            //fired achievement unlocked event
            event(new AchievementUnlocked($this->name(), $user));

            return true;
        }
        return false;
    }

}