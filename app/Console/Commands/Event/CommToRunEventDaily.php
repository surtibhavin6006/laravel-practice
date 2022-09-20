<?php

namespace App\Console\Commands\Event;

use App\Repository\EventRepository;
use Illuminate\Console\Command;

class CommToRunEventDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customEvent:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch events to be execute daily';

    /**
     * Execute the console command.
     * @param EventRepository $eventRepository
     * @return mixed
     */
    public function handle(EventRepository $eventRepository)
    {
        $eventRepository->executeDailyEvent();
    }
}
