<?php

namespace App\Console\Commands\Event;

use App\Repository\EventRepository;
use Illuminate\Console\Command;

class CommToRunEveryYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customEvent:yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch events to be execute every first day of week';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(EventRepository $eventRepository)
    {
        $eventRepository->executeYearlyEvent();
    }
}
