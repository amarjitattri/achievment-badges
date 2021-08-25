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
        
        $event->comment->user->achievements()->sync($achievmentIdsUnlockForUser);
    }
}
