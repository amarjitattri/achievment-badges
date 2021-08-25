<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class FiveLessonsWatched extends AchievementsType {

    public $name = '5 Lessons Watched';
    public $type = 'lesson'; //comment or lesson
    public $value = 5;

    public function qualifier($user)
    {
        if (isset($user->lessons) && $user->lessons->count() == $this->value) {

            //fired achievement unlocked event
            event(new AchievementUnlocked($this->name(), $user));

            return true;
        }
        return false;
    }

}