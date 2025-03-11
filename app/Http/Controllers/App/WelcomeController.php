<?php

namespace App\Http\Controllers\App;

use App\Services\WelcomeService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __construct(protected WelcomeService $welcomeService)
    {
        parent::__construct();
    }

    public function index(): View
    {
        Log::info($this->className, ['index - start']);

        $projectId = (int) session('projectId') ?? 0;
        $projectTitle = session('projectTitle') ?? '';
        $locale = session('locale', app()->getLocale());

        $resultArray = $this->welcomeService->getWelcomeContent($projectId, $locale);

        Log::info($this->className, ['index - end']);

        return view('welcome', [
            'projectTitle' => $projectTitle,
            'scopesLeft' => $resultArray[0] ?? [],
            'scopesRight' => $resultArray[1] ?? [],
        ]);
    }
}
