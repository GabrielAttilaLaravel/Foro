<?php


class SuscribeToPostsTest extends FeatureTestCase
{
    function test_a_user_can_suscribe_to_a_post()
    {
        $post = $this->createPost();

        $user = factory(\App\User::class)->create();

        $this->actingAs($user);

        $this->visit($post->url)
            ->press('Suscribirse al post');

        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url)
            ->dontSee('Suscribirse al post');

    }
}