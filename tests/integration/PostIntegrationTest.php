<?php


use App\Models\Post;

class PostIntegrationTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    function test_a_slug_is_generated_and_saved_to_the_database()
    {
        $user = $this->defaultUser();

        $post = factory(Post::class)->make([
            'title' => 'Como instalar laravel',
        ]);

        $user->posts()->save($post);

        $this->assertSame( 'como-instalar-laravel', $post->fresh()->slug);
    }
}
