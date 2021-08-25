<?php

namespace App\Providers;

use App\Achievements\Types;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{

    protected $achievements = [
        Types\FirstLessonWatched::class,
        Types\FiveLessonsWatched::class,
        Types\TenLessonsWatched::class,
        Types\TwentyFiveLessonsWatched::class,
        Types\FiftyLessonsWatched::class,
        Types\FirstCommentWritten::class,
        Types\ThreeCommentsWritten::class,
        Types\FiveCommentsWritten::class,
        Types\TenCommentsWritten::class,
        Types\TwentyCommentsWritten::class,
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
