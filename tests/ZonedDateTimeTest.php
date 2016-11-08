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
use LitGroup\Time\Date;
use LitGroup\Time\DateTime;
use LitGroup\Time\TimeZone;
use LitGroup\Time\TimeZoneId;
use LitGroup\Time\Month;
use LitGroup\Time\Time;
use LitGroup\Time\Year;
use LitGroup\Time\Offset;
use LitGroup\Time\ZonedDateTime;

class ZonedDateTimeTest extends \PHPUnit_Framework_TestCase
{
    const YEAR = 2016;
    const MONTH = 4;
    const DAY = 5;

    const HOUR = 6;
    const MINUTE = 8;
    const SECOND = 10;

    const DEFAULT_MONTH = 1;
    const DEFAULT_DAY = 1;
    const DEFAULT_HOUR = 0;
    const DEFAULT_MINUTE = 0;
    const DEFAULT_SECOND = 0;

    const TIMESTAMP = 1459825690;

    const TIMEZONE = "Europe/Moscow";
    const UTC_TIMEZONE = "UTC";
    const ANOTHER_TIMEZONE = 'Europe/Paris';

    const OFFSET_ABBR = 'MSK';
    const OFFSET_TOTAL_SECONDS = 10800;
    const OFFSET_DST = false;

    /**
     * @test
     * @testdox It is a subtype of DateTime
     */
    public function itIsASubtypeOfDateTime()
    {
        $this->assertInstanceOf(DateTime::class, $this->createDateTime());
    }

    /**
     * @test
     */
    public function itHasATimeZone()
    {
        $dateTime = $this->createDateTime();
        $expectedTimeZone = $this->createTimeZone();
        $this->assertTrue($expectedTimeZone->equals($dateTime->getTimeZone()));
    }

    /**
     * @test
     */
    public function itHasADate()
    {
        $dateTime = $this->createDateTime();
        $expectedDate = $this->createDate();

        $this->assertTrue($expectedDate->equals($dateTime->getDate()));
    }

    /**
     * @test
     */
    public function itHasATime()
    {
        $dateTime = $this->createDateTime();
        $expectedTime = $this->getTime();

        $this->assertTrue($expectedTime->equals($dateTime->getTime()));
    }

    /**
     * @test
     */
    public function itHasATimestampInSecondsSinceEpoch()
    {
        $dateTime = $this->createDateTime();
        $this->assertSame(self::TIMESTAMP, $dateTime->getSecondsSinceEpoch());
    }

    /**
     * @test
     */
    public function itHasAnOffset()
    {
        $dateTime = $this->createDateTime();
        $expectedZone = new Offset(self::OFFSET_ABBR, self::OFFSET_TOTAL_SECONDS, self::OFFSET_DST);

        $this->assertTrue($expectedZone->equals($dateTime->getOffset()));
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $dateTime = $this->createDateTime();
        $this->assertInstanceOf(Equatable::class, $dateTime);
        $this->assertSame($equal, $dateTime->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [
                true,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                true,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::UTC_TIMEZONE),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR - 3, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND + 1)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE + 1, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR + 1, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR, self::MONTH, self::DAY + 1),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR, self::MONTH + 1, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    TimeZone::of(self::TIMEZONE),
                    Date::of(self::YEAR + 1, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                $this->createMock(Equatable::class)
            ]
        ];
    }

    /**
     * @test
     */
    public function itTestsEqualityOfTimeZone()
    {
        $a = ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR);
        $b = ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR);
        $c = ZonedDateTime::of(TimeZone::of(self::ANOTHER_TIMEZONE), self::YEAR);

        $this->assertTrue($a->isSameTimeZone($b));
        $this->assertFalse($a->isSameTimeZone($c));
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodWithInitializationByScalarValues()
    {
        $this->assertTrue(
            ZonedDateTime::of($this->createTimeZone(), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)
                ->equals(
                    $this->createDateTime()
                )
        );

        $this->assertTrue(
            ZonedDateTime::of($this->createTimeZone(), self::YEAR)
                ->equals(
                    ZonedDateTime::of(
                        $this->createTimeZone(),
                        self::YEAR,
                        self::DEFAULT_MONTH,
                        self::DEFAULT_DAY,
                        self::DEFAULT_HOUR,
                        self::DEFAULT_MINUTE,
                        self::DEFAULT_SECOND
                    )
                )
        );
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodWithInitializationByDateAndTimeInUtcTimeZone()
    {
        $date = Date::of(self::YEAR, self::MONTH, self::DAY);
        $time = Time::of(self::HOUR, self::MINUTE, self::SECOND);

        $dateTime = ZonedDateTime::ofUtcDateAndTime($date, $time);
        $this->assertTrue(TimeZone::utc()->equals($dateTime->getTimeZone()));
        $this->assertTrue($date->equals($dateTime->getDate()));
        $this->assertTrue($time->equals($dateTime->getTime()));
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodWithInitializationByScalarValuesInUtcZone()
    {
        $dateTime = ZonedDateTime::ofUtc(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND);

        $this->assertTrue($dateTime->getTimeZone()->equals(TimeZone::utc()));
        $this->assertTrue($dateTime->equals(ZonedDateTime::of(
            TimeZone::utc(),
            self::YEAR, self::MONTH, self::DAY,
            self::HOUR, self::MINUTE, self::SECOND
        )));

        $this->assertTrue(
            ZonedDateTime::ofUtc(self::YEAR)
                ->equals(
                    ZonedDateTime::of(
                        TimeZone::utc(),
                        self::YEAR,
                        self::DEFAULT_MONTH,
                        self::DEFAULT_DAY,
                        self::DEFAULT_HOUR,
                        self::DEFAULT_MINUTE,
                        self::DEFAULT_SECOND
                    )
                )
        );
    }

    /**
     * @test
     * @small
     */
    public function itHasAFactoryForInitializationByCurrentDateAndTimeInUtc()
    {
        $dateTime = ZonedDateTime::nowUtc();
        $this->assertInstanceOf(ZonedDateTime::class, $dateTime);
        $this->assertEquals(time(), $dateTime->getSecondsSinceEpoch(), 'Should be equal to the current timestamp', 1.0);
        $this->assertTrue(TimeZone::utc()->equals($dateTime->getTimeZone()));
    }

    /**
     * @test
     * @dataProvider getComparisonExamples
     */
    public function itIsComparable(int $result, ZonedDateTime $another)
    {
        $dateTime = $this->createDateTime();
        $this->assertSame($result, $dateTime->compare($another));
        $this->assertSame($result > 0, $dateTime->greaterThan($another));
        $this->assertSame($result >= 0, $dateTime->greaterThanOrEqual($another));
        $this->assertSame($result < 0, $dateTime->lessThan($another));
        $this->assertSame($result <= 0, $dateTime->lessThanOrEqual($another));
    }

    public function getComparisonExamples(): array
    {
        return [
            [ 0, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR - 1, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH - 1, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY - 1, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 1, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE - 1, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND - 1)],
            [-1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR + 1, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH + 1, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY + 1, self::HOUR, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR + 1, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE + 1, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND + 1)],
            [ 0, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR - 1, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH - 1, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY - 1, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 4, self::MINUTE, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE - 1, self::SECOND)],
            [ 1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND - 1)],
            [-1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR + 1, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH + 1, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY + 1, self::HOUR - 3, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 2, self::MINUTE, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE + 1, self::SECOND)],
            [-1, ZonedDateTime::of(TimeZone::of(self::UTC_TIMEZONE), self::YEAR, self::MONTH, self::DAY, self::HOUR - 3, self::MINUTE, self::SECOND + 1)],
        ];
    }

    /**
     * @test
     */
    public function itIsSerializable()
    {
        $dateTime = $this->createDateTime();
        $this->assertInstanceOf(\Serializable::class, $dateTime);

        $unserialized = \unserialize(serialize($dateTime));
        $this->assertTrue(
            $this->createDateTime()->equals($unserialized)
        );
        $this->assertTrue(
            $this->createDateTime()->isSameTimeZone($unserialized)
        );
    }

    private function createDateTime(TimeZone $tz = null, Date $date = null, Time $time = null): ZonedDateTime
    {
        return ZonedDateTime::ofDateAndTime(
            $tz ?? $this->createTimeZone(),
            $date ?? $this->createDate(),
            $time ?? $this->getTime()
        );
    }

    private function createTimeZone(string $rawId = self::TIMEZONE): TimeZone
    {
        return TimeZone::of($rawId);
    }

    private function createDate(int $year = self::YEAR, int $month = self::MONTH, int $day = self::DAY): Date
    {
        return Date::of($year, $month, $day);
    }

    private function getTime(int $hour = self::HOUR, int $minute = self::MINUTE, int $second = self::SECOND): Time
    {
        return Time::of($hour, $minute, $second);
    }
}
