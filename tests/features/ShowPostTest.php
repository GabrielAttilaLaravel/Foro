<?php

use App\Models\Post;

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        $user = $this->defaultUser([
            'name' => 'Gabriel Moreno'
        ]);

        $post = $this->createPost([
            'title' => 'Este es el titulo del post',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id,
        ]);

        $this->visit($post->url)
             ->seeInElement('h1', $post->title)
             ->see($post->content)
             ->see('Gabriel Moreno');
    }

    public function test_old_urls_are_redirected()
    {
        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }
}
