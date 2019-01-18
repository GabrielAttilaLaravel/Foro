<?php

namespace Tests;

use Laravel\Dusk\Browser;
use Tests\traits\TestHelper;
use Tests\traits\CreateApplication;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreateApplication, TestHelper;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();

        Browser::macro('assertSeeErrors', function (array $fields)
        {
            foreach ($fields as $name => $errors){
                foreach ((array) $errors as $message){
                    $this->assertSeeIn("#field_{$name}.has-error .help-block", $message);
                }
            }

        });
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(['--headless']);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
                ->setCapability(ChromeOptions::CAPABILITY, $options)
        );
    }
}
