<?php

namespace Test\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_go_to_admin_dashboard()
    {
        $this->get(route('admin::dashboard'))
            ->assertSee('Dashboard')
            ->assertStatus(200);
    }

    protected function setUp()
    {
        parent::setUp();

        $user = factory(\Janitor\Models\User::class)->create();

        $this->actingAs($user);
    }
}
