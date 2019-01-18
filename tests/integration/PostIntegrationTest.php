<?php


use App\User;
use App\Models\Post;
use App\Models\Category;

class PostIntegrationTest extends FeatureTestCase
{

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

        $category = factory(Category::class)->create();

        $post = $user->createPost([
            'title' => 'titulo',
            'content' => 'contenido',
            'category_id' => $category->id,
        ]);

        $this->seeInDatabase('posts',[
            'title' => $post->title,
            'content' => $post->content,
            'category_id' => $category->id,
        ]);

        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    function tests_a_user_can_filter_posts_by_category()
    {
        $laravel = factory(Category::class)->create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        $vue = factory(Category::class)->create([
            'name' => 'Vue,js',
            'slug' => 'vue-js'
        ]);

        factory(Post::class)->create([
            'title' => 'Post de Laravel 1',
            'category_id' => $laravel->id
        ]);

        factory(Post::class)->create([
            'title' => 'Post de Laravel 2',
            'category_id' => $laravel->id
        ]);

        $posts = Post::orderBy('created_at', 'DESC')->category($laravel)->get();

        $this->assertSame(2, $posts->count());

        $this->assertSame('post-de-laravel-1', $posts->first()->slug);

        $this->assertSame('post-de-laravel-2', $posts->last()->slug);
    }
}
