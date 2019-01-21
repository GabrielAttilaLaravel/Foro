<?php

use App\Models\Vote;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APostCanBeVotedTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $post;

    function setUp()
    {
        parent::setUp();

        $this->actingAs($this->user = $this->defaultUser());

        $this->post = $this->createPost();
    }

    function test_a_post_can_be_voted()
    {
        Vote::upvote($this->post);

        $this->assertDatabaseHas('votes',[
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'vote' => 1
        ]);

        $this->assertSame(1, $this->post->score);
    }

    function test_a_post_can_be_downvoted()
    {
        Vote::downvote($this->post);

        $this->assertDatabaseHas('votes',[
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'vote' => -1
        ]);

        $this->assertSame(-1, $this->post->score);
    }

    function test_a_post_cannot_be_upvoted_twice_by_same_user()
    {
        Vote::upvote($this->post);

        Vote::upvote($this->post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $this->post->score);
    }

    function test_a_post_cannot_be_downvoted_twice_by_same_user()
    {
        Vote::downvote($this->post);

        Vote::downvote($this->post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $this->post->score);
    }

    function test_a_user_can_switch_from_upvote_to_downvote()
    {
        Vote::upvote($this->post);

        Vote::downvote($this->post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $this->post->score);
    }

    function test_a_user_can_switch_from_downvote_to_upvote()
    {
        Vote::downvote($this->post);

        Vote::upvote($this->post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $this->post->score);
    }

    function test_the_post_score_is_calculated_correctly()
    {
        // cualquier usuario agrega un voto
        Vote::create([
            'post_id' => $this->post->id,
            'user_id' => factory(\App\User::class)->create()->id,
            'vote' => 1,
        ]);

        Vote::upvote($this->post);

        $this->assertSame(2, Vote::count());

        $this->assertSame(2, $this->post->score);
    }
}
