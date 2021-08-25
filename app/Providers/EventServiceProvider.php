<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\UnlockCommentWrittenAchievements;
use App\Listeners\UnlockLessonWatchedAchievements;
use App\Listeners\UnlockLesssonWathedAchievements;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            UnlockCommentWrittenAchievements::class,
        ],
        LessonWatched::class => [
            UnlockLessonWatchedAchievements::class,
        ],
        AchievementUnlocked::class => [
            //
        ],
        BadgeUnlocked::class => [
            //
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
