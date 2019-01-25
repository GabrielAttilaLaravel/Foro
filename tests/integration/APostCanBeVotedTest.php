<?php

use App\Models\Vote;
use App\User;
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
        $this->post->upvote();

        $this->assertSame(1, $this->post->current_vote);

        $this->assertSame(1, $this->post->score);
    }

    function test_a_post_can_be_downvoted()
    {
        $this->post->downvote();

        $this->assertSame(-1, $this->post->current_vote);

        $this->assertSame(-1, $this->post->score);
    }

    function test_a_post_cannot_be_upvoted_twice_by_same_user()
    {
        $this->post->upvote();

        $this->post->upvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $this->post->score);
    }

    function test_a_post_cannot_be_downvoted_twice_by_same_user()
    {
        $this->post->downvote();

        $this->post->downvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $this->post->score);
    }

    function test_a_user_can_switch_from_upvote_to_downvote()
    {
        $this->post->upvote();

        $this->post->downvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $this->post->score);
    }

    function test_a_user_can_switch_from_downvote_to_upvote()
    {
        $this->post->downvote();

        $this->post->upvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $this->post->score);
    }

    function test_the_post_score_is_calculated_correctly()
    {
        // cualquier usuario agrega un voto
        $this->post->votes()->create([
            'user_id' => factory(User::class)->create()->id,
            'vote' => 1,
        ]);

        $this->post->upvote();

        $this->assertSame(2, Vote::count());

        $this->assertSame(2, $this->post->score);
    }

    function test_a_post_can_be_unvoted(){
        $this->post->upvote();

        $this->assertSame(1, $this->post->current_vote);

        $this->post->undoVote();

        $this->assertNull($this->post->current_vote);

        $this->assertSame(0, $this->post->score);
    }

    function test_get_vote_from_user_returns_the_vote_from_the_right_post()
    {
        $this->post->upvote();

        $anotherPost = $this->createPost();

        $this->assertSame(1, $this->post->current_vote);

        $this->assertNull($anotherPost->current_vote);
    }
}
