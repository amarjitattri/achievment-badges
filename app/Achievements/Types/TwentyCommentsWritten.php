<?php

namespace App\Achievements\Types;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

class TwentyCommentsWritten extends AchievementsType {

    public $name = '20 Comment Written';
    public $type = 'comment'; //comment or lesson
    public $value = 20;

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