<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'events';

    public const ID = 'id';
    public const TITLE = 'title';
    public const START_DATE = 'start_date';
    public const END_DATE = 'end_date';
    public const END_AFTER_OCCURRENCES = 'end_after_occurrences';
    public const REPEAT_ON = 'repeat_on';
    public const REPEAT_MONTH = 'repeat_month';
    public const REPEAT_WEEK = 'repeat_week';
    public const SUCC_FULLY_RUN_COUNT = 'successfullyRunCount';

    protected $primaryKey = self::ID;

    protected $fillable = [
        self::TITLE,
        self::START_DATE,
        self::END_DATE,
        self::END_AFTER_OCCURRENCES,
        self::REPEAT_ON,
        self::REPEAT_MONTH,
        self::REPEAT_WEEK,
        self::REPEAT_WEEK,
    ];

    public function getEventById($id)
    {
        return $this->where(self::ID,$id)->firstOrFail();
    }

    public function getDailyEvents(?Carbon $date)
    {
        if (empty($dateYmd)) {
            $date = Carbon::now();
        }

        $dateYmd = $date->format('Y-m-d');

        return $this
            ->where(self::REPEAT_ON,'=','D')
            ->applyFilterForCronEvents($dateYmd)
            ->get();
    }

    public function getMonthlyEvents(?Carbon $dateYmd,int $repeatMonth = 1)
    {
        if (empty($dateYmd)) {
            $date = Carbon::now();
        }

        $dateYmd = $date->format('Y-m-d');

        return $this
            ->where(self::REPEAT_ON,'=','M')
            ->where(self::REPEAT_MONTH,'=',$repeatMonth)
            ->applyFilterForCronEvents($dateYmd)
            ->get();
    }

    public function getWeeklyEvents(?Carbon $dateYmd)
    {
        if (empty($dateYmd)) {
            $date = Carbon::now();
        }
        $dateYmd = $date->format('Y-m-d');
        $currentDayOfWeek = (string)$date->dayOfWeek;

        return $this
            ->where(self::REPEAT_ON,'=','W')
            ->where(self::REPEAT_WEEK,'=',$currentDayOfWeek)
            ->applyFilterForCronEvents($dateYmd)
            ->get();
    }

    public function getYearEvents(?Carbon $dateYmd)
    {
        if (empty($dateYmd)) {
            $date = Carbon::now();
        }
        $dateYmd = $date->format('Y-m-d');

        return $this
            ->where(self::REPEAT_ON,'=','Y')
            ->applyFilterForCronEvents($dateYmd)
            ->get();
    }

    public function scopeApplyFilterForCronEvents($query,$dateYmd)
    {
        return $query->where(function($query) use($dateYmd){
            $query->whereDate(self::START_DATE,'<=',$dateYmd);
            $query->whereDate(self::END_DATE,'>=',$dateYmd);
            $query->where(self::END_AFTER_OCCURRENCES,'=',0);
        })->orWhere(function($query) use($dateYmd){
            $query->where(self::START_DATE,'<=',$dateYmd);
            $query->whereNull(self::END_DATE);
            $query->where(self::END_AFTER_OCCURRENCES,'>',self::SUCC_FULLY_RUN_COUNT);
        });
    }
}
