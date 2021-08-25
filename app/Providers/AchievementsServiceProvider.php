<?php

namespace App\Providers;

use App\Achievements\Types\FirstLessonWatched;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{

    protected $achievements = [
       FirstLessonWatched::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('achievements', function() {
            return collect($this->achievements)->map(function($achievement) {
                return new $achievement;
            });
        });
    }

}