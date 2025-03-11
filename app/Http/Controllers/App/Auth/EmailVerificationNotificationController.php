<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationNotificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => 'start']);
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('home', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        Log::info(class_basename(self::class), [__FUNCTION__ => 'end']);

        return back()->with('status', 'verification-link-sent');
    }
}
