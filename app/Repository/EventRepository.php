<?php

namespace App\Repository;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    /**
     * @var Event $eventModel
     */
    protected $eventModel;

    public function __construct(
        Event $event
    )
    {
        $this->eventModel = $event;
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

    public function executeDailyEvent()
    {
        DB::enableQueryLog();

        $dailyEventsData = ($this->eventModel)->getDailyEvents(null);

        $this->runEvent($dailyEventsData);
        //dd($dailyEventsData);
        //dd(DB::getQueryLog());
    }

    public function executeWeeklyEvent()
    {
        $dailyEventsData = ($this->eventModel)->getWeeklyEvents(null);
        $this->runEvent($dailyEventsData);
    }

    public function executeMonthlyEvent($everyMonth = 1)
    {
        $dailyEventsData = ($this->eventModel)->getMonthlyEvents(null,$everyMonth);
        $this->runEvent($dailyEventsData);
    }

    public function executeYearlyEvent()
    {
        $dailyEventsData = ($this->eventModel)->getYearEvents(null);
        $this->runEvent($dailyEventsData);
    }

    public function runEvent($eventData)
    {
        if(!empty($eventData) && $eventData->count() >0){
            $eventData->each(function ($event) {
                $event->{$this->eventModel::SUCC_FULLY_RUN_COUNT} = $event->{$this->eventModel::SUCC_FULLY_RUN_COUNT}+1;
                $event->save();
            });
        }
    }
}
