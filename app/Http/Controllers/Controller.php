<?php

namespace Janitor\Http\Controllers;

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
    protected function success(string $message, array $data = []): array
    {
        $content = [
            'result' => true,
            'type' => 'success',
            'title' => 'Success',
            'message' => $message,
        ];

        return empty($data) ? $content : array_merge($content, $data);
    }

    /**
     * Method to notify failed operation.
     *
     * @param string $message The error message
     *
     * @return array
     */
    protected function error(string $message, array $data = []): array
    {
        $content = [
            'result' => false,
            'type' => 'error',
            'title' => 'Error',
            'message' => $message,
        ];

        return empty($data) ? $content : array_merge($content, $data);
    }

    /**
     * Method to notify information about an operation.
     *
     * @param string $message The informative message
     *
     * @return array
     */
    protected function info(string $message, array $data = []): array
    {
        $content = [
            'result' => true,
            'type' => 'info',
            'title' => 'Heads up',
            'message' => $message,
        ];

        return empty($data) ? $content : array_merge($content, $data);
    }
}
