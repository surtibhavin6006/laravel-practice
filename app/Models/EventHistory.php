<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventHistory extends Model
{
    use HasFactory;

    protected $table = 'event_history';

    public const ID = 'id';
    public const FK_EVENT_ID = 'fk_event_id';
    public const ERROR = 'error';
    public const CREATED_AT = 'created_at';

    protected $primaryKey = self::ID;

    protected $fillable = [
        self::FK_EVENT_ID
    ];

    protected $dateFormat = 'Y-m-d h:i:s';

    /**
     * @param $eventId
     * @return Builder|Collection
     */
    public function getEventHistoryByEventId($eventId)
    {
        return ($this->newQuery())->where(self::FK_EVENT_ID,$eventId)->get();
    }
}
