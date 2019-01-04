<?php


use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    function test_a_slug_is_generated_and_saved_to_the_database()
    {
        $post = $this->createPost([
            'title' => 'Como instalar laravel',
        ]);

        $this->assertSame( 'como-instalar-laravel', $post->fresh()->slug);
    }

    function test_a_user_creates_a_post_and_subscribes_to_it()
    {
        $user = factory(User::class)->create();

        $post = $user->createPost([
            'title' => 'titulo',
            'content' => 'contenido',
        ]);

        $this->seeInDatabase('posts',[
            'title' => $post->title,
            'content' => $post->content,
        ]);

        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
