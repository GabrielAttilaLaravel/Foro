<?php

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\PostCommented;
use App\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostCommentedTest extends TestCase
{
    use DatabaseTransactions;

    function test_it_builds_a_mail_message()
    {
        $post = factory(Post::class)->create([
            'title' => 'Titulo del post',
        ]);

        $author = factory(User::class)->create([
            'name' => 'Gabriel Moreno'
        ]);

        $comment = factory(Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $author->id,
        ]);

        $notification = new PostCommented($comment);

        $subscriber = factory(User::class)->create();

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Nuevo comentario en: Titulo del post',
            $message->subject
        );

        $this->assertSame(
            'Gabriel Moreno escribió un comentario en: Titulo del post',
            $message->introLines[0]
        );

        $this->assertSame($comment->post->url, $message->actionUrl);
    }
}
