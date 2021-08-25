<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Comment;
use App\Models\Lesson;

use Illuminate\Support\Facades\Event;
use App\Events\LessonWatched;
class AchievmentTest extends TestCase
{

    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_a_first_lesson_watched_achievement_is_unlocked()
    {
        //Event::fake();
        //collect

        //generate user, lesson and lesson_user relationship
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson->id, ['watched' => true]);

        //listen lesson watched event
        event(new LessonWatched($lesson, $user));

        Event::assertDispatched(LessonWatched::class);

        //fire AchievementUnlocked event
        //fire batch unlock event


        //action

        //assert
        //$this->assertCount(1, $user->achievements);

    }

    
}
