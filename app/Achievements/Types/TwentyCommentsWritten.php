<?php

namespace App\Achievements\Types;

use App\Models\Achievement;

class TwentyCommentsWritten extends AchievementsType {

    public $name = '';
    public $type = 'watched'; //comment or lesson

    public function qualifier($user)
    {
        //
    }

}