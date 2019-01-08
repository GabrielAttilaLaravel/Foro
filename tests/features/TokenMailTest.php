<?php


use App\Mail\TokenMail;
use App\Models\Token;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
    function test_it_sends_a_link_with_the_token()
    {
        $user = new \App\User([
            'first_name' => 'Gabriel',
            'last_name' => 'Moreno',
            'email' => 'gabriel@attila.com'
        ]);

        $token = new Token([
            'token' => 'thist_is_a_token',
            'user' => $user,
        ]);

        $this->open(new TokenMail($token))
            ->seeLink($token->url, $token->url);
    }

    // Todo: crear un trait llamado InteractsWithMailable y colocar el metodo open()
    public function open(Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();//elimina los mensajes de la coleccion creando una nueva coleccion

        Mail::send($mailable);

        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}
