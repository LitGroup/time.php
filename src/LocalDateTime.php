<?php
/**
 * This file is part of the "litgroup/datetime" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types = 1);

namespace LitGroup\Time;

use LitGroup\Equatable\Equatable;

/**
 * A date-time without a time-zone in the ISO-8601 calendar system, such as 2007-12-03T10:15:30.
 *
 * It is an immutable date-time object that represents a date-time, often viewed as year-month-day-hour-minute-second.
 * Time is represented to second precision.
 *
 * This class does not store or represent a time-zone. Instead, it is a description of the date, as used for birthdays,
 * combined with the local time as seen on a wall clock. It cannot represent an instant on the time-line without
 * additional information such as an offset or time-zone.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class LocalDateTime implements DateTime, Equatable
{
    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;

    public static function of(Date $date, Time $time): LocalDateTime
    {
        return new self($date, $time);
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getTime(): Time
    {
        return $this->time;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof LocalDateTime &&
            $another->getDate()->equals($this->getDate()) &&
            $another->getTime()->equals($this->getTime());
    }


    private function __construct(Date $date, Time $time)
    {
        $this->date = $date;
        $this->time = $time;
    }
}