<?php
/**
 * This class is used for administrator login.
 *
 * PHP 7
 *
 * @author Jan Cyril Segubience <jancyrilsegubience@gmail.com>
 */

namespace Janitor\QueryObjects;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminLogin
{
    use ThrottlesLogins;

    /**
     * The property that will contain the error message.
     *
     * @var string
     */
    public $message = '';

    /**
     * This will authenticate the admin user and will lockout if
     * multiple invalid login attempts is made.
     *
     * @param array $credentials The credentials sent by the user
     *
     * @return bool
     */
    public function login(array $credentials): bool
    {
        if ($this->hasTooManyLoginAttempts(new Request())) {
            $this->fireLockoutEvent(new Request());

            $seconds = $this->limiter()->availableIn($this->throttleKey(new Request()));

            $this->message = "Multiple invalid login attempts, please try again after {$seconds} ".str_plural('second', $seconds).'.';

            return false;
        }

        if (auth()->attempt($credentials)) {
            return true;
        }

        $this->incrementLoginAttempts(new Request());

        $this->message = 'Email or password is invalid, please try again.';

        return false;
    }

    /**
     * A method required by ThrottlesLogins trait.
     *
     * @return string The field to be used for authentication
     */
    private function username(): string
    {
        return 'email';
    }
}
