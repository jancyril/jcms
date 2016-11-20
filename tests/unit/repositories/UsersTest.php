<?php

use Janitor\Repositories\Users;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_add_a_new_user()
    {
        $data = factory(Janitor\Models\User::class)->make()->toArray();

        $user = new Users();
        $user->add(array_merge($data, ['password' => str_random(20)]));

        $this->seeInDatabase('users', $data);
    }

    /** @test **/
    public function it_can_update_a_user()
    {
        $data = $this->create();

        $user = new Users();
        $user->update($data->id, ['firstname' => 'Juan Carlo']);

        $this->seeInDatabase('users', array_merge($data->toArray(), ['firstname' => 'Juan Carlo']));
    }

    /** @test **/
    public function it_can_delete_a_user()
    {
        $data = $this->create();

        $user = new Users();
        $user->delete($data->id);

        $this->notSeeInDatabase('users', $data->toArray());
    }

    private function create()
    {
        return factory(Janitor\Models\User::class)->create();
    }
}
