<?php


use App\Models\Post;

class CreatePostsTest extends FeatureTestCase
{
    function test_a_user_can_create_a_post()
    {
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        $this->actingAs($user = $this->defaultUser())
            ->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        $this->seeInDatabase('posts', [
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id
        ]);

        $post = Post::first();

        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url);
    }

    function test_creating_a_post_requires_authentication()
    {
        $this->visit(route('posts.create'))
             ->seePageIs(route('token.create'));
    }

    function test_create_post_form_validation()
    {
        $this->actingAs($this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ]);
            /*->seeInElement('.help-block', 'El campo título es obligatorio')
            ->seeInElement('.help-block', 'El campo contenido es obligatorio');*/
    }
}