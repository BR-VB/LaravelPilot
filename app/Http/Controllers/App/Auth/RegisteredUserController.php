<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //register view
    public function create(): View
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return view('auth.register', [
            'projectTitle' => session('projectTitle') ?? '',
        ]);
    }

    /**
     * register store
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => 'start']);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        Log::info(class_basename(self::class), [__FUNCTION__ => 'end']);

        return redirect()->back();
    }
}
