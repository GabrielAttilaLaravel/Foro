<?php

namespace Tests\Feature;

use App\Repositories\VoteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VoteForPostTest extends \TestCase
{
    use DatabaseTransactions;

    function test_a_user_can_upvote_for_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $this->postJson($post->url . '/vote/1')
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 1
            ]);

        $this->assertSame(1, $post->current_vote);

        $this->assertSame(1, $post->fresh()->score);
    }

    function test_a_user_can_downvote_for_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $this->postJson($post->url . '/vote/-1')
            ->assertSuccessful()
            ->assertJson([
                'new_score' => -1
            ]);

        $this->assertSame(-1, $post->current_vote);

        $this->assertSame(-1, $post->fresh()->score);
    }

    function test_a_user_can_unvote_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $post->upvote($post);

        $this->deleteJson($post->url . '/vote')
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 0
            ]);

        $this->assertNull($post->current_vote);

        $this->assertSame(0, $post->fresh()->score);
    }

    function test_a_guest_user_cannot_vot_for_a_post()
    {
        $post = $this->createPost();

        $this->postJson("{$post->url}/vote/-1")
            ->assertStatus(401)
            ->assertJson(['error' => 'Unauthenticated.']);

        $this->assertNull($post->current_vote);
    }
}
