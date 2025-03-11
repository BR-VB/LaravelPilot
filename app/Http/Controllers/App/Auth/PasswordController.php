<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => 'start']);
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        Log::info(class_basename(self::class), [__FUNCTION__ => 'end']);

        return back()->with('status', 'password-updated');
    }
}
