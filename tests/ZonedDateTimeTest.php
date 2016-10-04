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

namespace Test\LitGroup\Time;

use LitGroup\Equatable\Equatable;
use LitGroup\Time\Date;
use LitGroup\Time\DateTime;
use LitGroup\Time\Location;
use LitGroup\Time\LocationId;
use LitGroup\Time\Month;
use LitGroup\Time\Time;
use LitGroup\Time\Year;
use LitGroup\Time\Zone;
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

    const LOCATION = "Europe/Moscow";
    const UTC_LOCATION = "UTC";

    const ZONE_ABBR = 'MSK';
    const ZONE_OFFSET = 10800;
    const ZONE_DST = false;

    /**
     * @var ZonedDateTime
     */
    private $dateTime;

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

    protected function setUp()
    {
        $this->location = Location::ofId(new LocationId(self::LOCATION));
        $this->date = new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY);
        $this->time = Time::of(self::HOUR, self::MINUTE, self::SECOND);
        $this->dateTime = ZonedDateTime::ofDateAndTime($this->location, $this->date, $this->time);
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
    public function itHasALocation()
    {
        $dateTime = $this->getDateTime();
        $expectedLocation = $this->getLocation();
        $this->assertTrue($expectedLocation->equals($dateTime->getLocation()));
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
    public function itHasATimeZone()
    {
        $dateTime = $this->getDateTime();
        $expectedZone = new Zone(self::ZONE_ABBR, self::ZONE_OFFSET, self::ZONE_DST);

        $this->assertTrue($expectedZone->equals($dateTime->getZone()));
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
                    Location::of(self::LOCATION),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                true,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::UTC_LOCATION),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR - 3, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::LOCATION),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND + 1)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::LOCATION),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR, self::MINUTE + 1, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::LOCATION),
                    Date::of(self::YEAR, self::MONTH, self::DAY),
                    Time::of(self::HOUR + 1, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::LOCATION),
                    Date::of(self::YEAR, self::MONTH, self::DAY + 1),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::LOCATION),
                    Date::of(self::YEAR, self::MONTH + 1, self::DAY),
                    Time::of(self::HOUR, self::MINUTE, self::SECOND)
                )
            ],
            [
                false,
                ZonedDateTime::ofDateAndTime(
                    Location::of(self::LOCATION),
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
    public function itHasAFactoryMethodWithInitializationByScalarValues()
    {
        $this->assertTrue(
            ZonedDateTime::of($this->getLocation(), self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)
                ->equals(
                    $this->getDateTime()
                )
        );

        $this->assertTrue(
            ZonedDateTime::of($this->getLocation(), self::YEAR)
                ->equals(
                    ZonedDateTime::of(
                        $this->getLocation(),
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

    private function getDateTime(): ZonedDateTime
    {
        return $this->dateTime;
    }

    private function getLocation(): Location
    {
        return $this->location;
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
