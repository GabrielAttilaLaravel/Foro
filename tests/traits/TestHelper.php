<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 08/01/19
 * Time: 10:11 PM
 */

namespace Tests\traits;


use App\User;
use App\Models\Post;

trait TestHelper
{
    /**
     * @var \App\User
     */
    protected $defaultUser;

    public function defaultUser(array $attributes = [])
    {
        if ($this->defaultUser){
            return $this->defaultUser;
        }

        return $this->defaultUser = factory(User::class)->create($attributes);
    }

    public function createPost(array $attributes = [])
    {
        return factory(Post::class)->create($attributes);
    }
}