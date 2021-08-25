<?php

namespace App\Achievements\Types;

use App\Events\BadgeUnlocked;
use App\Models\Achievement;

class Intermediate extends AchievementsType {

    public $type = 'badge'; //comment or lesson or badge
    public $value = 4;

    public function qualifier($user)
    {
        if ($this->getAchievementCount($user) == $this->value) {

            //fired badge unlocked event
            event(new BadgeUnlocked($this->name(), $user));

            return true;
       }
       return false;
    }

}