<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Comment;
use App\Models\Lesson;

use Illuminate\Support\Facades\Event;
use App\Events\LessonWatched;
use App\Listeners\UnlockLessonWatchedAchievements;
use Illuminate\Testing\Fluent\AssertableJson;

class AchievmentTest extends TestCase
{

    //use RefreshDatabase;
    
    public function test_first_lesson_watched_achievement_is_unlocked()
    {
        Event::fake(AchievementUnlocked::class);

        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson->id, ['watched' => true]);

        //listen lesson watched event
        event(new LessonWatched($lesson, $user));

        //test Achievement Unlocked event
        Event::assertDispatched(AchievementUnlocked::class);

        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertStatus(200);

    }

    public function test_five_lesson_watched_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->count(5)->create();
        $user->watched()->attach($lesson->pluck('id'), ['watched' => true]);
        
        //listen lesson watched event
        event(new LessonWatched($lesson->last(), $user));

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);

    }

    public function test_10_lesson_watched_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->count(10)->create();
        $user->watched()->attach($lesson->pluck('id'), ['watched' => true]);
        
        //listen lesson watched event
        event(new LessonWatched($lesson->last(), $user));

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);

    }

    public function test_25_lesson_watched_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->count(25)->create();
        $user->watched()->attach($lesson->pluck('id'), ['watched' => true]);
        
        //listen lesson watched event
        event(new LessonWatched($lesson->last(), $user));

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);

    }

    public function test_50_lesson_watched_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->count(50)->create();
        $user->watched()->attach($lesson->pluck('id'), ['watched' => true]);
        
        //listen lesson watched event
        event(new LessonWatched($lesson->last(), $user));

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);

    }

    public function test_first_comment_written_achievement_is_unlocked()
    {
        $comment = Comment::factory()->create();
        event(new CommentWritten($comment));

        $response = $this->get("/users/{$comment->user_id}/achievements");
        $response->assertStatus(200);

    }

    public function test_3_comments_written_achievement_is_unlocked()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        event(new CommentWritten($comment->last()));

        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertStatus(200);

    }

    public function test_5_comments_written_achievement_is_unlocked()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->count(5)->create([
            'user_id' => $user->id
        ]);

        event(new CommentWritten($comment->last()));

        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertStatus(200);

    }

    public function test_10_comments_written_achievement_is_unlocked()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->count(10)->create([
            'user_id' => $user->id
        ]);

        event(new CommentWritten($comment->last()));

        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertStatus(200);

    }

    public function test_20_comments_written_achievement_is_unlocked()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->count(20)->create([
            'user_id' => $user->id
        ]);

        event(new CommentWritten($comment->last()));

        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertStatus(200);

    }
    
    public function test_first_lesson_watched_and_first_comment_written_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson->id, ['watched' => true]);
        //listen lesson watched event
        event(new LessonWatched($lesson, $user));

        $lesson = Lesson::factory()->count(50)->create();
        $user->watched()->attach($lesson->pluck('id'), ['watched' => true]);
        
        //listen lesson watched event
        event(new LessonWatched($lesson->last(), $user));


        $lesson = Lesson::factory()->count(10)->create();
        $user->watched()->attach($lesson->pluck('id'), ['watched' => true]);
        
        //listen lesson watched event
        event(new LessonWatched($lesson->last(), $user));

        //generate comment
        $comment = Comment::factory()->create([
            'user_id' => $user->id
        ]);

        //listen comment written event
        event(new CommentWritten($comment));

        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertStatus(200);
    }

    
    
}
