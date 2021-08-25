<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class ThreeCommentsWritten extends AchievementsType {

    public $name = '3 Comments Written';
    public $type = 'comment'; //comment or lesson
    public $value = 3;

    public function qualifier($user)
    {
        if (isset($user->comments) && $user->comments->count() == $this->value) {

            //fired achievement unlocked event
            event(new AchievementUnlocked($this->name(), $user));
            
            return true;
        }
        return false;
    }

}