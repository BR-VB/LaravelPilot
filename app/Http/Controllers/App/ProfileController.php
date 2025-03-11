<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\App\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //display the user's profile form
    public function edit(Request $request): View
    {
        Log::info($this->className, [__FUNCTION__]);

        return view('profile.edit', [
            'projectTitle' => session('projectTitle') ?? '',
            'user' => $request->user(),
        ]);
    }

    //update the user's profile information
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        Log::info($this->className, [__FUNCTION__ => 'end']);

        return redirect()->route('profile.edit')->withSuccess(__('auth.profile_update_success_message'));
    }

    //delete the user's account
    public function destroy(Request $request): RedirectResponse
    {
        Log::info($this->className, [__FUNCTION__]);
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info($this->className, [__FUNCTION__ => 'end']);

        return Redirect::to(route('home'));
    }
}
