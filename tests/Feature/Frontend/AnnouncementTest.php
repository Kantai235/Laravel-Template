<?php

namespace Tests\Feature\Frontend;

use App\Domains\Announcement\Models\Announcement;
use Tests\TestCase;

/**
 * Class AnnouncementTest.
 */
class AnnouncementTest extends TestCase
{
    /** @test */
    public function announcementIsOnlyVisibleOnFrontend()
    {
        $announcement = Announcement::factory()->enabled()->frontend()->noDates()->create();

        $response = $this->get('login');

        $response->assertSee($announcement->message);

        $this->loginAsAdmin();

        $response = $this->get('admin/dashboard');

        $response->assertDontSee($announcement->message);
    }

    /** @test */
    public function announcementIsOnlyVisibleOnBackend()
    {
        $announcement = Announcement::factory()->enabled()->backend()->noDates()->create();

        $response = $this->get('login');

        $response->assertDontSee($announcement->message);

        $this->loginAsAdmin();

        $response = $this->get('admin/dashboard');

        $response->assertSee($announcement->message);
    }

    /** @test */
    public function announcementIsVisibleGlobally()
    {
        $announcement = Announcement::factory()->enabled()->global()->noDates()->create();

        $response = $this->get('login');

        $response->assertSee($announcement->message);

        $this->loginAsAdmin();

        $response = $this->get('admin/dashboard');

        $response->assertSee($announcement->message);
    }

    /** @test */
    public function aDisabledAnnouncementDoesNotShow()
    {
        $announcement = Announcement::factory()->disabled()->global()->noDates()->create();

        $response = $this->get('login');

        $response->assertDontSee($announcement->message);
    }

    /** @test */
    public function anAnnouncementInsideOfDateRangeShows()
    {
        $announcement = Announcement::factory()->enabled()->global()->insideDateRange()->create();

        $response = $this->get('login');

        $response->assertSee($announcement->message);
    }

    /** @test */
    public function anAnnouncementOutsideOfDateRangeDoesntShow()
    {
        $announcement = Announcement::factory()->enabled()->global()->outsideDateRange()->create();

        $response = $this->get('login');

        $response->assertDontSee($announcement->message);
    }
}
