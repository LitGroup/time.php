<?php
/**
 * This file is part of the "litgroup/time" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types = 1);

namespace LitGroup\Time;

use LitGroup\Equatable\Equatable;
use Serializable;

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
final class LocalDateTime implements DateTime, Equatable, Serializable
{
    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;

    public static function of(int $year, int $month = 1, int $day = 1, int $hour = 0, int $minute = 0, int $second = 0): LocalDateTime
    {
        return new self(Date::of($year, $month, $day), Time::of($hour, $minute, $second));
    }

    public function __construct(Date $date, Time $time)
    {
        $this->init($date, $time);
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

    public function compare(LocalDateTime $another): int
    {
        if (!$this->getDate()->equals($another->getDate())) {
            return $this->getDate()->compare($another->getDate());
        } else {
            return $this->getTime()->compare($another->getTime());
        }
    }

    public function greaterThan(LocalDateTime $another): bool
    {
        return $this->compare($another) > 0;
    }

    public function greaterThanOrEqual(LocalDateTime $another): bool
    {
        return $this->compare($another) >= 0;
    }

    public function lessThan(LocalDateTime $another): bool
    {
        return $this->compare($another) < 0;
    }

    public function lessThanOrEqual(LocalDateTime $another): bool
    {
        return $this->compare($another) <= 0;
    }

    public function serialize()
    {
        return \serialize([$this->getDate(), $this->getTime()]);
    }

    public function unserialize($serialized)
    {
        list ($date, $time) = \unserialize($serialized);
        $this->init($date, $time);
    }

    private function init(Date $date, Time $time)
    {
        $this->date = $date;
        $this->time = $time;
    }
}