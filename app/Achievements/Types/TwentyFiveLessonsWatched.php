<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class TwentyFiveLessonsWatched extends AchievementsType {

    public $name = '25 Lessons Watched';
    public $type = 'lesson'; //comment or lesson
    public $value = 25;

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