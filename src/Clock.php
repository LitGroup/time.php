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
 * A clock providing access to the current date and time using a time-zone.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Clock implements Equatable
{
    /**
     * @var TimeZone
     */
    private $timeZone;

    /**
     * @var NativeTimeZone
     */
    private $nativeTimeZone;

    public static function withTimeZone(TimeZone $timeZone): Clock
    {
        return new Clock($timeZone);
    }

    public static function withUtcTimeZone(): Clock
    {
        return self::withTimeZone(TimeZone::utc());
    }

    public function getTimeZone(): TimeZone
    {
        return $this->timeZone;
    }

    public function now(): ZonedDateTime
    {
        return $this->createDateTimeFromNative(
            $this->createCurrentNativeDateTime()
        );
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Clock &&
            $this->getTimeZone()->equals($another->getTimeZone());
    }

    private function __construct(TimeZone $timeZone)
    {
        $this->timeZone = $timeZone;
        $this->nativeTimeZone = new NativeTimeZone($this->getTimeZone()->getId()->getRawValue());
    }

    private function getNativeTimeZone(): NativeTimeZone
    {
        return $this->nativeTimeZone;
    }

    private function createDateTimeFromNative(NativeDateTime $native): ZonedDateTime
    {
        assert($native->getTimezone()->getName() === $this->getTimeZone()->getId()->getRawValue());

        $parts = explode('/', $native->format('Y/m/d/H/i/s'));

        return ZonedDateTime::of(
            $this->getTimeZone(),
            intval($parts[0], 10),
            intval($parts[1], 10),
            intval($parts[2], 10),
            intval($parts[3], 10),
            intval($parts[4], 10),
            intval($parts[5], 10)
        );
    }

    private function createCurrentNativeDateTime(): NativeDateTime
    {
        return new NativeDateTime('now', $this->getNativeTimeZone());
    }
}