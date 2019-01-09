<?php

use Tests\traits\TestHelper;
use Tests\traits\CreateApplication;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

class FeatureTestCase extends BaseTestCase
{
    use CreateApplication, TestHelper, DatabaseTransactions;

    public function seeErrors(array $fields)
    {
        foreach ($fields as $name => $errors){
            foreach ((array) $errors as $message){
                $this->seeInElement("#{$name} .error, .help-block", $message);
            }
        }

    }
}