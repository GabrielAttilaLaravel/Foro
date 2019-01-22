<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\VoteRepository;

class VotePostController extends Controller
{
    /**
     * @var VoteRepository
     */
    private $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {

        $this->voteRepository = $voteRepository;
    }
    
    public function upvote(Post $post)
    {
        $this->voteRepository->upvote($post);
        //Vote::upvote($post);

        return [
            'new_score' => $post->score
        ];
    }

    public function downvote(Post $post)
    {
        $this->voteRepository->downvote($post);

        return [
            'new_score' => $post->score
        ];
    }

    public function undovote(Post $post)
    {
        $this->voteRepository->undovote($post);

        return [
            'new_score' => $post->score
        ];
    }
}
