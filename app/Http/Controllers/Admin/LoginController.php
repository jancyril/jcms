<?php

namespace Janitor\Http\Controllers\Admin;

use Janitor\Http\Requests;
use Illuminate\Http\Request;
use Janitor\QueryObjects\AdminLogin;
use Janitor\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return $this->admin('auth.login', ['pageTitle' => 'Administrator Login']);
    }

    public function login(Requests\Admin\Login $validation)
    {
        $auth = new AdminLogin();

        if (!$auth->login($this->request->all())) {
            return $this->error($auth->message);
        }

        return $this->success('Login successful, please wait while we redirect you.');
    }
}
