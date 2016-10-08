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

namespace Test\LitGroup\Time;

use LitGroup\Equatable\Equatable;
use LitGroup\Time\Clock;
use LitGroup\Time\TimeZone;
use LitGroup\Time\ZonedDateTime;

class ClockTest extends \PHPUnit_Framework_TestCase
{
    const TIMEZONE = 'Europe/Moscow';
    const ANOTHER_TIMEZONE = 'Europe/Paris';

    /**
     * @test
     */
    public function itHasAFactoryForInitializationWithTimeZone()
    {
        $clock = Clock::withTimeZone(TimeZone::of(self::TIMEZONE));
        $this->assertInstanceOf(Clock::class, $clock);
    }

    /**
     * @test
     */
    public function itHasATimeZone()
    {
        $timeZone = TimeZone::of(self::TIMEZONE);

        $clock = Clock::withTimeZone($timeZone);
        $this->assertTrue($timeZone->equals($clock->getTimeZone()));
    }

    /**
     * @test
     */
    public function itHasAFactoryWithInitializationByUtcTimeZone()
    {
        $clock = Clock::withUtcTimeZone();
        $this->assertInstanceOf(Clock::class, $clock);
        $this->assertTrue($clock->getTimeZone()->equals(TimeZone::utc()));
    }

    /**
     * @test
     * @small
     */
    public function itReturnsCurrentDateTime()
    {
        $timeZone = TimeZone::of(self::TIMEZONE);
        $clock = Clock::withTimeZone($timeZone);

        $dateTime = $clock->now();
        $this->assertInstanceOf(ZonedDateTime::class, $dateTime);
        $this->assertEquals(time(), $dateTime->getSecondsSinceEpoch(), '', 1.0);
        $this->assertTrue($dateTime->getTimeZone()->equals($timeZone));
    }

    /**
     * @test
     */
    public function itIsEqualToAnotherOneWithTheSameTimeZone()
    {
        $clock = Clock::withTimeZone(TimeZone::of(self::TIMEZONE));
        $this->assertInstanceOf(Equatable::class, $clock);

        $this->assertTrue($clock->equals(Clock::withTimeZone(TimeZone::of(self::TIMEZONE))));
        $this->assertFalse($clock->equals(Clock::withTimeZone(TimeZone::of(self::ANOTHER_TIMEZONE))));
        $this->assertFalse($clock->equals($this->createMock(Equatable::class)));
    }
}
