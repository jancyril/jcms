<?php

namespace Janitor\Http\Controllers;

use Janitor\Helpers\InfoResponse;
use Janitor\Helpers\ErrorResponse;
use Janitor\Helpers\SuccessfulResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * This will generate the view for admin page.
     *
     * @param string $view Path to the view
     * @param array  $data Data to be passed to the view
     *
     * @return Illuminate\View\View
     */
    protected function admin(string $view, array $data = [])
    {
        return view('admin.'.$view, $data);
    }

    /**
     * This will generate the view for user page.
     *
     * @param string $view Path to the view
     * @param array  $data Data to be passed to the view
     *
     * @return Illuminate\View\View
     */
    protected function user(string $view, array $data = [])
    {
        return view('user.'.$view, $data);
    }

    /**
     * Method to notify successful operation.
     *
     * @param string $message The success message
     *
     * @return array
     */
    protected function success(string $message, array $data = [])
    {
        return new SuccessfulResponse($message, $data);
    }

    /**
     * Method to notify failed operation.
     *
     * @param string $message The error message
     *
     * @return array
     */
    protected function error(string $message, array $data = [])
    {
        return new ErrorResponse($message, $data);
    }

    /**
     * Method to notify information about an operation.
     *
     * @param string $message The informative message
     *
     * @return array
     */
    protected function info(string $message, array $data = [])
    {
        return new InfoResponse($message, $data);
    }
}
