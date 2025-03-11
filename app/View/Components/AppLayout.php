<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * NOT used so far in my project
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
