<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDashboardControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_go_to_admin_dashboard()
    {
        $this->admin();

        $this->visit(route('admin::dashboard'))
            ->see('Dashboard')
            ->seePageIs(route('admin::dashboard'))
            ->assertResponseOk();
    }

    private function admin()
    {
        $user = factory(Janitor\Models\User::class)->create();

        $this->actingAs($user);
    }
}
