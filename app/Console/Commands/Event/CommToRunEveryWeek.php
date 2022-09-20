<?php

namespace App\Console\Commands\Event;

use App\Repository\EventRepository;
use Illuminate\Console\Command;

class CommToRunEveryWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customEvent:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch events to be execute every day of with today\'s week data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(EventRepository $eventRepository)
    {
        $eventRepository->executeWeeklyEvent();
    }
}
