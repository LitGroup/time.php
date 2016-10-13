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
    const MONTH = 8;
    const DAY = 4;

    const HOUR = 3;
    const MINUTE = 5;
    const SECOND = 7;

    const DEFAULT_MONTH = 1;
    const DEFAULT_DAY = 1;
    const DEFAULT_HOUR = 0;
    const DEFAULT_MINUTE = 0;
    const DEFAULT_SECOND = 0;

    const TIMESTAMP = 1470269107;

    const TIMEZONE = "Europe/Moscow";
    const UTC_TIMEZONE = "UTC";
    const ANOTHER_TIMEZONE = 'Europe/Paris';

    const OFFSET_ABBR = 'MSK';
    const OFFSET_TOTAL_SECONDS = 10800;
    const OFFSET_DST = false;

    /**
     * @var ZonedDateTime
     */
    private $dateTime;

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

    protected function setUp()
    {
        $this->timeZone = TimeZone::ofId(new TimeZoneId(self::TIMEZONE));
        $this->date = new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY);
        $this->time = Time::of(self::HOUR, self::MINUTE, self::SECOND);
        $this->dateTime = ZonedDateTime::ofDateAndTime($this->timeZone, $this->date, $this->time);
    }

    /**
     * @test
     * @testdox It is a subtype of DateTime
     */
    public function itIsASubtypeOfDateTime()
    {
        $this->assertInstanceOf(DateTime::class, $this->getDateTime());
    }

    /**
     * @test
     */
    public function itHasATimeZone()
    {
        $dateTime = $this->getDateTime();
        $expectedTimeZone = $this->getTimeZone();
        $this->assertTrue($expectedTimeZone->equals($dateTime->getTimeZone()));
    }

    /**
     * @test
     */
    public function itHasADate()
    {
        $dateTime = $this->getDateTime();
        $expectedDate = $this->getDate();

        $this->assertTrue($expectedDate->equals($dateTime->getDate()));
    }

    /**
     * @test
     */
    public function itHasATime()
    {
        $dateTime = $this->getDateTime();
        $expectedTime = $this->getTime();

        $this->assertTrue($expectedTime->equals($dateTime->getTime()));
    }

    /**
     * @test
     */
    public function itHasATimestampInSecondsSinceEpoch()
    {
        $dateTime = $this->getDateTime();
        $this->assertSame(self::TIMESTAMP, $dateTime->getSecondsSinceEpoch());
    }

    /**
     * @test
     */
    public function itHasAnOffset()
    {
        $dateTime = $this->getDateTime();
        $expectedZone = new Offset(self::OFFSET_ABBR, self::OFFSET_TOTAL_SECONDS, self::OFFSET_DST);

        $this->assertTrue($expectedZone->equals($dateTime->getOffset()));
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $dateTime = $this->getDateTime();
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
            ZonedDateTime::of($this->getTimeZone(), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)
                ->equals(
                    $this->getDateTime()
                )
        );

        $this->assertTrue(
            ZonedDateTime::of($this->getTimeZone(), self::YEAR)
                ->equals(
                    ZonedDateTime::of(
                        $this->getTimeZone(),
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

    private function getDateTime(): ZonedDateTime
    {
        return $this->dateTime;
    }

    private function getTimeZone(): TimeZone
    {
        return $this->timeZone;
    }

    private function getDate(): Date
    {
        return $this->date;
    }

    private function getTime(): Time
    {
        return $this->time;
    }
}
