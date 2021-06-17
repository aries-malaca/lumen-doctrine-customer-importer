<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfServiceIsUp()
    {
        $this->get('/');
        $this->assertEquals(
            'Welcome to Lumen App!', $this->response->getContent()
        );
    }
}
