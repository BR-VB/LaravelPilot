<?php

namespace App\Http\Controllers\App;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //login view
    public function showLoginForm(): View
    {
        Log::info($this->className, [__FUNCTION__]);

        return view('auth.login', [
            'projectTitle' => session('projectTitle') ?? '',
        ]);
    }
}
