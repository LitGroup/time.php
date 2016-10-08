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

use DateTimeImmutable as NativeDateTime;
use DateTimeZone as NativeTimeZone;
use LitGroup\Equatable\Equatable;

/**
 * A date-time with a time-zone in the ISO-8601 calendar system, such as 2007-12-03T10:15:30+03:00 Europe/Moscow.
 *
 * ZonedDateTime is an immutable representation of a date-time with a time-zone.
 * This class stores all date and time fields, to a precision of seconds, and
 * a time-zone, with a zone offset used to handle ambiguous local date-times.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class ZonedDateTime implements DateTime, Equatable
{
    /**
     * @var NativeDateTime
     */
    private $nativeDateTime;

    /**
     * @var TimeZone
     */
    private $timeZone;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;


    public static function of(
        TimeZone $timeZone,
        int $year, int $month = 1, int $day = 1,
        int $hour = 0, int $minute = 0, int $second = 0
    ): ZonedDateTime {
        return self::ofDateAndTime(
            $timeZone,
            Date::of($year, $month, $day),
            Time::of($hour, $minute, $second)
        );
    }

    public static function ofDateAndTime(TimeZone $timeZone, Date $date, Time $time): ZonedDateTime
    {
        return new self($timeZone, $date, $time);
    }

    public static function ofUtc(
        int $year, int $month = 1, int $day = 1,
        int $hour = 0, int $minute = 0, int $second = 0
    ): ZonedDateTime {
        return self::of(TimeZone::utc(), $year, $month, $day, $hour, $minute, $second);
    }

    public static function ofUtcDateAndTime(Date $date, Time $time): ZonedDateTime
    {
        return self::ofDateAndTime(TimeZone::utc(), $date, $time);
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getTime(): Time
    {
        return $this->time;
    }

    public function getTimeZone(): TimeZone
    {
        return $this->timeZone;
    }

    public function getOffset(): Offset
    {
        return $this->getTimeZone()->getOffsetAt($this->getSecondsSinceEpoch());
    }

    public function getSecondsSinceEpoch(): int
    {
        return $this->getNativeDateTime()->getTimestamp();
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof ZonedDateTime &&
            $another->getSecondsSinceEpoch() === $this->getSecondsSinceEpoch();
    }

    private function __construct(TimeZone $timeZone, Date $date, Time $time)
    {
        $this->timeZone = $timeZone;
        $this->date = $date;
        $this->time = $time;
        $this->nativeDateTime = NativeDateTime::createFromFormat(
            'Y/m/d H:i:s',
            sprintf(
                "%'04d/%'02d/%'02d %'02d:%'02d:%'02d",
                $date->getYear()->getRawValue(),
                $date->getMonth()->getRawValue(),
                $date->getDayOfMonth(),
                $time->getHour(),
                $time->getMinute(),
                $time->getSecond()
            ),
            new NativeTimeZone($timeZone->getId()->getRawValue())
        );
    }

    private function getNativeDateTime(): NativeDateTime
    {
        return $this->nativeDateTime;
    }
}