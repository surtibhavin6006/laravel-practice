<?php

namespace App\Repository;

use App\Jobs\Event\EventJob;
use App\Models\Event;
use App\Models\EventHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    /**
     * @var Event $eventModel
     * @var EventHistory $eventHistoryModel
     */
    protected $eventModel,$eventHistory;

    public function __construct(
        Event $event,
        EventHistory $eventHistory
    )
    {
        $this->eventModel = $event;
        $this->eventHistoryModel = $eventHistory;
    }

    public function getAllEvents(?Request $request)
    {
       return (new $this->eventModel)
           ->orderBy($this->eventModel::ID,'desc')
           ->paginate(20);
    }

    public function prepareModel(Request $request,$id = null)
    {
        $eventData = empty($id) ? new $this->eventModel : (new $this->eventModel)->getEventById($id);

        $eventData->{$this->eventModel::TITLE} = $request->title;
        $eventData->{$this->eventModel::START_DATE} = Carbon::parse($request->startDate);
        $eventData->{$this->eventModel::END_DATE} = !empty($request->endDate) ? Carbon::parse($request->endDate) : null;
        $eventData->{$this->eventModel::END_AFTER_OCCURRENCES} = !empty($request->endAfterOccurrences) ? $request->endAfterOccurrences : 0;
        $eventData->{$this->eventModel::REPEAT_ON} = $request->repeatOn;
        $eventData->{$this->eventModel::REPEAT_WEEK} = !empty($request->repeatWeek) ? $request->repeatWeek : null;
        $eventData->{$this->eventModel::REPEAT_MONTH} = !empty($request->repeatMonth) ? $request->repeatMonth : null;

        return $eventData;
    }

    public function createEvent(Request $request)
    {
        ($model = $this->prepareModel($request))->save();
        return $model;
    }

    public function getEventById(Request $request,$id)
    {
        return (new $this->eventModel)->getEventById($id);
    }

    public function updateEvent(Request $request,$id)
    {
        ($model = $this->prepareModel($request,$id))->save();
        return $model;
    }

    public function deleteEvent($id)
    {
        return (new $this->eventModel)->getEventById($id)->delete();
    }

    public function executeDailyEvent(): void
    {
        /** @var Collection $dailyEventsData */
        $dailyEventsData = ($this->eventModel)->getDailyEvents(null);
        $this->dispacthEvents($dailyEventsData);
    }

    public function executeWeeklyEvent(): void
    {
        $weeklyEventsData = ($this->eventModel)->getWeeklyEvents(null);
        $this->dispacthEvents($weeklyEventsData);
    }

    public function executeMonthlyEvent($everyMonth = 1): void
    {
        $monthlyEventsData = ($this->eventModel)->getMonthlyEvents(null,$everyMonth);
        $this->dispacthEvents($monthlyEventsData);
    }

    public function executeYearlyEvent(): void
    {
        $yearlyEventsData = ($this->eventModel)->getYearEvents(null);
        $this->dispacthEvents($yearlyEventsData);
    }

    private function dispacthEvents($events)
    {
        $events->each(function ($event) {
            EventJob::dispatch($event);
        });

    }

    /**
     * @param $event
     * @return void
     */
    public function executeEvent($event): void
    {
        $event->{$this->eventModel::SUCC_FULLY_RUN_COUNT} = $event->{$this->eventModel::SUCC_FULLY_RUN_COUNT}+1;
        $event->save();

        $this->createEventHistory($event->{Event::ID});
    }

    /**
     * @param $eventId
     * @return void
     */
    private function createEventHistory($eventId): void
    {
        $this->eventHistoryModel->{EventHistory::FK_EVENT_ID} = $eventId;
        $this->eventHistoryModel->save();
    }

    public function getEventHisotryByEventId($eventId)
    {
        return $this->eventHistoryModel->getEventHistoryByEventId($eventId);
    }
}
