<?php

namespace App\Http\Controllers;

use App\Services\WorkSessionService;
use Illuminate\Http\Request;

class WorkSessionController extends Controller
{
    protected $service;

    public function __construct(WorkSessionService $service)
    {
        $this->service = $service;
    }

    public function confirmFocus(Request $request): void
    {

        $workSessionId = $request->input('workSessionId');

        $this->service->confirmFocus($workSessionId);
    }
}
