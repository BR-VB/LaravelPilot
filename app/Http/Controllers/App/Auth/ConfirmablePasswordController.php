<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => 'start']);
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        Log::info(class_basename(self::class), [__FUNCTION__ => 'end']);

        return redirect()->intended(route('home', absolute: false));
    }
}
