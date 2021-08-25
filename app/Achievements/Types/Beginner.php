<?php

namespace App\Achievements\Types;

use App\Events\BadgeUnlocked;
use App\Models\Achievement;

class Beginner extends AchievementsType {

    public $type = 'badge'; //comment or lesson

    public $value = 0;

    public function qualifier($user)
    {
       return $this->getAchievementCount($user) < 4;
    }

}