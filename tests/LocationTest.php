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
use LitGroup\Time\Location;
use LitGroup\Time\LocationId;
use LitGroup\Time\Month;
use LitGroup\Time\Time;
use LitGroup\Time\Year;
use LitGroup\Time\Zone;
use LitGroup\Time\ZonedDateTime;

class LocationTest extends \PHPUnit_Framework_TestCase
{
    const ID = 'Europe/Moscow';
    const ANOTHER_ID = 'UTC';

    const ZONE_OFFSET = 10800;
    const ZONE_ABBR = 'MSK';
    const ZONE_DST = false;

    const YEAR = 2016;
    const MONTH = 8;
    const DAY = 4;

    const HOUR = 3;
    const MINUTE = 5;
    const SECOND = 7;

    const TIMESTAMP = 1470269107;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var LocationId
     */
    private $locationId;

    protected function setUp()
    {
        $this->locationId = new LocationId(self::ID);
        $this->location = Location::of($this->locationId);
    }

    /**
     * @test
     */
    public function itHasAnId()
    {
        $this->assertSame($this->getLocationId(), $this->getLocation()->getId());
    }

    /**
     * @test
     */
    public function itCanBeConvertedToString()
    {
        $this->assertSame(self::ID, (string) $this->getLocation());
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $location = $this->getLocation();
        $this->assertInstanceOf(Equatable::class, $location);
        $this->assertSame($equal, $location->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, Location::of(new LocationId(self::ID))],
            [false, Location::of(new LocationId(self::ANOTHER_ID))],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    /**
     * @test
     */
    public function itProvidesATimeZone()
    {
        $location = $this->getLocation();
        $dateTime = $this->createDateTime($location);
        $expectedZone = new Zone(self::ZONE_ABBR, self::ZONE_OFFSET, self::ZONE_DST);

        $this->assertTrue($expectedZone->equals($location->getZone($dateTime)));
    }

    private function getLocation(): Location
    {
        return $this->location;
    }

    private function getLocationId(): LocationId
    {
        return $this->locationId;
    }

    private function createDateTime(Location $location): ZonedDateTime
    {
        return ZonedDateTime::of(
            $location,
            Date::of(
                Year::of(self::YEAR),
                Month::getValueOf(self::MONTH),
                self::DAY
            ),
            Time::of(
                self::HOUR,
                self::MINUTE,
                self::SECOND
            )
        );
    }
}
