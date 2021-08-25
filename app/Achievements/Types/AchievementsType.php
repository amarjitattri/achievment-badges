<?php

namespace App\Achievements\Types;

use App\Models\Achievement;

abstract class AchievementsType {

    protected $model;

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => $this->name(),
            'type' => $this->type
        ]);
    }

    public function name()
    {
        if(property_exists($this, 'name')) {
            return $this->name;
        }

        return trim(preg_replace('/[A-Z]/', ' $0', class_basename($this)));
    }
    
    public function modelKey()
    {
        return $this->model->getKey();
    }

    abstract public function qualifier($user);
}