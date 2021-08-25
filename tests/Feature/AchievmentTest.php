<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Comment;
use App\Models\Lesson;

use Illuminate\Support\Facades\Event;
use App\Events\LessonWatched;
use Illuminate\Testing\Fluent\AssertableJson;

class AchievmentTest extends TestCase
{

    //use RefreshDatabase;
    
    public function test_first_lesson_watched_achievement_is_unlocked()
    {
        //Event::fake();
        //collect

        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson->id, ['watched' => true]);

        //listen lesson watched event
        event(new LessonWatched($lesson, $user));

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);

        //fire AchievementUnlocked event
        //fire batch unlock event


        //action

        //assert
        //$this->assertCount(1, $user->achievements);

    }

    public function test_first_comment_written_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $comment = Comment::factory()->create();

        //listen lesson watched event
        event(new CommentWritten($comment));

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

    public function test_first_lesson_watched_and_first_comment_written_achievement_is_unlocked()
    {
        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson->id, ['watched' => true]);
        //listen lesson watched event
        event(new LessonWatched($lesson, $user));

        //generate comment
        $comment = Comment::factory()->create([
            'user_id' => $user->id
        ]);

        //listen comment written event
        event(new CommentWritten($comment));

        //$response = $this->get("/users/{$user->id}/achievements");
    }
    
}
