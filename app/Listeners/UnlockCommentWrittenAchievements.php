<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockCommentWrittenAchievements
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $this->unlockAchievementsLogic($event);
    }

    /**
     * unlock achievements logic for comment written
     */
    public function unlockAchievementsLogic($event) 
    {
        $achievmentIdsUnlockForUser = app('achievements')->filter(function($achievements) use ($event) {
            return $achievements->qualifier($event->comment->user);
        })->map(function($achievements) {
            return $achievements->modelKey();
        });
        
        $event->comment->user->achievements()->sync($achievmentIdsUnlockForUser, false);

        //check if new badge unlocked
        $this->unlockBadgesLogic($event);
    }

    /**
     * unlock badges logic
     */
    public function unlockBadgesLogic($event)
    {
        $badgeIdsUnlockForUser = app('badges')->filter(function($badges) use ($event) {
            return $badges->qualifier($event->comment->user);
        })->map(function($badges) {
            return $badges->modelKey();
        });

        $event->comment->user->achievements()->sync($badgeIdsUnlockForUser, false);
    }
}
