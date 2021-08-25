<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class FiftyLessonsWatched extends AchievementsType {

    public $name = '50 Lessons Watched';
    public $type = 'lesson'; //comment or lesson
    public $value = 50;

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