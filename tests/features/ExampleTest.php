<?php

class ExampleTest extends FeatureTestCase
{
    function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Gabriel Moreno',
            'email' => 'gabrieljmroenot@gamil.com'
        ]);

        $this->actingAs($user, 'api')
             ->visit('api/user')
             ->see('Gabriel Moreno')
             ->see('gabrieljmroenot@gamil.com');
    }
}
