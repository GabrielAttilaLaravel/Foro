<?php

use Tests\traits\TestHelper;
use Tests\traits\CreateApplication;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use CreateApplication, TestHelper;
}
