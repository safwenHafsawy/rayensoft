<?php

namespace App\Console\Commands;

use App\Services\WorkSessionService;
use Illuminate\Console\Command;

class PausedUncheckedWorkSession extends Command
{

    protected $signature = 'work-sessions:pause-unchecked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pause work sessions that have been left unchecked for a certain period';

    protected WorkSessionService $service;

    public function __construct(WorkSessionService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->service->autoPauseSessions();
    }
}
