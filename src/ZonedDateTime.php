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

use DateTimeImmutable as NativeDateTime;
use DateTimeZone as NativeTimeZone;

final class ZonedDateTime implements DateTime
{
    /**
     * @var NativeDateTime
     */
    private $nativeDateTime;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;


    public static function ofDateAndTime(Location $location, Date $date, Time $time): ZonedDateTime
    {
        return new self($location, $date, $time);
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getTime(): Time
    {
        return $this->time;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getZone(): Zone
    {
        return $this->getLocation()->getZone($this->getSecondsSinceEpoch());
    }

    public function getSecondsSinceEpoch(): int
    {
        return $this->getNativeDateTime()->getTimestamp();
    }

    private function __construct(Location $location, Date $date, Time $time)
    {
        $this->location = $location;
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
            new NativeTimeZone($location->getId()->getRawValue())
        );
    }

    private function getNativeDateTime(): NativeDateTime
    {
        return $this->nativeDateTime;
    }
}