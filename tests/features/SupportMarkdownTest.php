<?php

class SupportMarkdownTest extends FeatureTestCase
{
    function test_the_post_content_support_markdown()
    {
        $importtantText = 'Un texto muy importante';

        $post = $this->createPost([
            'content' => "La primera parte del texto. **$importtantText**. La ultima parte del texto"
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importtantText);
    }

    function test_the_code_in_the_post_is_escaped()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";

        $post = $this->createPost([
            'content' => "`$xssAttack`. Text normal"
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Text normal')
            ->seeText($xssAttack);
    }

    function test_xss_attack()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";

        $post = $this->createPost([
            'content' => "$xssAttack. Text normal"
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Text normal')
            ->seeText($xssAttack);
    }

    function test_xss_attack_with_html()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";

        $post = $this->createPost([
            'content' => "$xssAttack. Text normal"
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack);
    }
}
