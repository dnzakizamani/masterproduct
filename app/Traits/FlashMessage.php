<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;

trait FlashMessage
{
    /**
     * Set success flash message.
     */
    protected function success(string $message): void
    {
        Session::flash('success', $message);
    }

    /**
     * Set error flash message.
     */
    protected function error(string $message): void
    {
        Session::flash('error', $message);
    }

    /**
     * Set warning flash message.
     */
    protected function warning(string $message): void
    {
        Session::flash('warning', $message);
    }

    /**
     * Set info flash message.
     */
    protected function info(string $message): void
    {
        Session::flash('info', $message);
    }

    /**
     * Set validation error flash message.
     */
    protected function validationError(string $message): void
    {
        Session::flash('error', $message);
    }

    /**
     * Set redirect with success message.
     */
    protected function redirectSuccess(string $message, string $route): \Illuminate\Http\RedirectResponse
    {
        return redirect()
            ->route($route)
            ->with('success', $message);
    }

    /**
     * Set redirect with error message.
     */
    protected function redirectError(string $message, string $route): \Illuminate\Http\RedirectResponse
    {
        return redirect()
            ->route($route)
            ->with('error', $message);
    }

    /**
     * Set back with success message.
     */
    protected function backSuccess(string $message): \Illuminate\Http\RedirectResponse
    {
        return redirect()
            ->back()
            ->with('success', $message);
    }

    /**
     * Set back with error message.
     */
    protected function backError(string $message): \Illuminate\Http\RedirectResponse
    {
        return redirect()
            ->back()
            ->with('error', $message)
            ->withInput();
    }
}
