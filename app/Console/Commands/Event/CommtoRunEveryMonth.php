<?php

namespace App\Console\Commands\Event;

use App\Repository\EventRepository;
use Illuminate\Console\Command;

class CommtoRunEveryMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customEvent:monthly {--month=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch events to be execute every first day of given month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(EventRepository $eventRepository)
    {
        $onEveryMonth = $this->option('month');
        $eventRepository->executeMonthlyEvent($onEveryMonth);
    }
}
