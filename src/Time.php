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
use LitGroup\Time\Exception\DateTimeException;

/**
 * A time without a time-zone in the ISO-8601 calendar system, such as 10:15:3.
 *
 * It is an immutable date-time object that represents a time, often viewed as
 * hour-minute-second.
 * Time is represented to second precision. For example, the value "13:45.30"
 * can be stored in a Time.
 *
 * This class does not store or represent a date or time-zone. Instead, it is a
 * description of the local time as seen on a wall clock.
 * It cannot represent an instant on the time-line without additional information
 * such as an offset or time-zone.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Time implements Equatable
{
    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minute;

    /**
     * @var int
     */
    private $second;

    public function __construct(int $hour, int $minute, int $second)
    {
        if ($hour < 0 || $hour > 23) {
            throw new DateTimeException("Hour has an invalid value: $hour");
        }
        $this->hour = $hour;

        if ($minute < 0 || $minute > 59) {
            throw new DateTimeException("Minute has an invalid value: $minute");
        }
        $this->minute = $minute;

        if ($second < 0 || $second > 59) {
            throw new DateTimeException("Second has an invalid value: $second");
        }
        $this->second = $second;
    }

    public function getHour(): int
    {
        return $this->hour;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }

    public function getSecond(): int
    {
        return $this->second;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Time &&
            $another->getHour() === $this->getHour() &&
            $another->getMinute() === $this->getMinute() &&
            $another->getSecond() === $this->getSecond();
    }
}