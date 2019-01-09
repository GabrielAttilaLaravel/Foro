<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 08/01/19
 * Time: 10:04 PM
 */

namespace Tests\traits;


use Illuminate\Contracts\Console\Kernel;

trait CreateApplication
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->baseUrl = $app->make('config')->get('app.url');

        return $app;
    }
}