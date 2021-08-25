<?php

namespace App\Achievements\Types;

use App\Models\Achievement;

class FirstLessonWatched {

    public $name = "First Lesson Watched";

    public $level = 1;

    public $type = 'lesson';

    protected $model;

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => $this->name,
            'level' => $this->level,
            'type' => $this->type
        ]);
    }

    public function qualifier($user)
    {
        return $user->lessons->count() >= 1;
    }

    public function modelKey()
    {
        return $this->model->getKey();
    }
}