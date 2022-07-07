<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;

/**
 * Class SwitchLanguageTest.
 */
class SwitchLanguageTest extends TestCase
{
    /** @test */
    public function theLanguageCanBeSwitched()
    {
        $response = $this->get('/lang/de');

        $response->assertSessionHas('locale', 'de');
    }
}
