<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CreateEventRequestValidation;
use App\Http\Resources\Api\Event\EventHistoriesResource;
use App\Http\Resources\Api\Event\EventResource;
use App\Http\Resources\Api\Event\EventsResource;
use App\Repository\EventRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public $eventRepository;

    public function __construct(EventRepository $eventRepository){
        $this->eventRepository = $eventRepository;
    }

    public function all(Request $request)
    {
        // get all list
        $events = $this->eventRepository->getAllEvents(null);

        return new EventsResource($events);
    }

    public function create(CreateEventRequestValidation $request)
    {
        // get json request and pass to repository.
        $data = $this->eventRepository->createEvent($request);
        return new EventResource($data);
    }

    public function view(Request $request,$id)
    {
        // get json request and pass to repository.
        $data = $this->eventRepository->getEventById($request,$id);
        return new EventResource($data);
    }

    public function update(CreateEventRequestValidation $request,$id)
    {
        // get json request and pass to repository.
        $data = $this->eventRepository->updateEvent($request,$id);
        return new EventResource($data);
    }

    public function delete(Request $request,$id)
    {
        // get json request and pass to repository.
        return $this->eventRepository->deleteEvent($id);
    }

    public function viewEventHistory(Request $request,$id)
    {
        // get json request and pass to repository.
        $data = $this->eventRepository->getEventHisotryByEventId($id);
        return new EventHistoriesResource($data);
    }
}
