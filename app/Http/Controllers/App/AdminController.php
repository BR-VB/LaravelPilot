<?php

namespace App\Http\Controllers\App;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): View
    {
        Log::info($this->className, [__FUNCTION__]);

        return view('admin');
    }
}
