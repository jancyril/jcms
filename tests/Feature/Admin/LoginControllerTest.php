<?php

namespace Test\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_go_to_the_admin_login_page()
    {
        $this->get(route('admin::login'))
            ->assertSee('Administrator Login');
    }

    /** @test **/
    public function admin_login_will_fail_if_email_is_empty()
    {
        $password = str_random(10);
        $data = ['email' => '', 'password' => $password];

        $this->post(route('admin::post-login'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function admin_login_will_fail_if_email_is_not_a_valid_email()
    {
        $password = str_random(10);
        $data = ['email' => 'myemail', 'password' => $password];

        $this->post(route('admin::post-login'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function admin_login_will_fail_if_password_is_empty()
    {
        $data = ['email' => 'me@jancyril.com', 'password' => ''];

        $this->post(route('admin::post-login'), $data)
            ->assertSessionHasErrors();
    }

    /** @test **/
    public function admin_login_will_fail_if_email_or_password_is_invalid()
    {
        $data = ['email' => 'me@jancyril.com', 'password' => str_random(10)];

        $this->post(route('admin::post-login'), $data)
            ->assertSee('Error');
    }

    /** @test **/
    public function admin_login_will_succeed_if_credentials_are_valid()
    {
        $password = str_random(10);
        $user = factory(\Janitor\Models\User::class)->create(['password' => $password]);

        $this->post(route('admin::post-login'), ['email' => $user->email, 'password' => $password])
            ->assertSee('Success');
    }

    /** @test **/
    public function admin_login_will_lockout_after_five_invalid_attempts()
    {
        $password = str_random(10);
        $user = factory(\Janitor\Models\User::class)->create(['password' => $password]);

        for ($x = 0; $x < 5; ++$x) {
            $this->post(route('admin::post-login'), ['email' => $user->email, 'password' => str_random(10)])
                ->assertSee('Error');
        }

        $this->post(route('admin::post-login'), ['email' => $user->email, 'password' => $password])
            ->assertSee('Error')
            ->assertSee('seconds');
    }

    /** @test **/
    public function admin_login_can_remember_a_user()
    {
        $password = str_random(10);
        $user = factory(\Janitor\Models\User::class)->create(['password' => $password]);

        $this->post(route('admin::post-login'), ['email' => $user->email, 'password' => $password])
            ->assertSee('Success');

        $this->get(route('admin::login'))
            ->assertRedirect(route('admin::dashboard'));
    }
}
