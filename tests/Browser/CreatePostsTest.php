<?php

namespace Tests\Browser;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use App\Models\Category;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $title = 'Esta es una pregunta';
    protected $content = 'Este es el contenido';

    function test_a_user_can_create_a_post()
    {
        $user = $this->defaultUser();

        $category = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($category, $user){
            $browser->loginAs($user)
                ->visitRoute('posts.create')
                ->type('title', $this->title)
                ->type('content', $this->content)
                ->select('category_id', (string) $category->id)
                ->press('Publicar')
                // Test a user is redirected to the posts details after creating it.
                ->assertPathIs('/posts/1-esta-es-una-pregunta');
        });

       $this->assertDatabaseHas('posts', [
            'title' => $this->title,
            'content' => $this->content,
            'pending' => true,
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);

        $post = Post::first();

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    function test_creating_a_post_requires_authentication()
    {
        $this->browse(function (Browser $browser){
            $browser->visitRoute('posts.create')
                ->assertRouteIs('token.create');
        });

    }

    function test_create_post_form_validation()
    {
        $this->browse(function (Browser $browser){
            $browser->loginAs($this->defaultUser())
                ->visitRoute('posts.create')
                ->press('Publicar')
                ->assertRouteIs('posts.create')
                ->assertSeeErrors([
                    'title' => 'El campo título es obligatorio',
                    'content' => 'El campo contenido es obligatorio'
                ]);
        });
    }
}
