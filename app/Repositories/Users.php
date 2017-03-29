<?php

namespace Janitor\Repositories;

class Users extends BaseRepository
{
    protected function model()
    {
        return \Janitor\Models\User::class;
    }
}
