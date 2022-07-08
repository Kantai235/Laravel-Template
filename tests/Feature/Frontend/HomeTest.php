<?php

namespace Tests\Feature\Frontend;

use Tests\TestCase;

/**
 * Class HomeTest.
 */
class HomeTest extends TestCase
{
    /** @test */
    public function theHomePageExists()
    {
        $this->get('/')->assertOk();
    }
}
