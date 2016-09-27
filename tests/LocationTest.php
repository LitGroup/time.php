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
use LitGroup\Time\Location;
use LitGroup\Time\LocationId;

class LocationTest extends \PHPUnit_Framework_TestCase
{
    const LOCATION_ID_RAW_VALUE = 'Europe/Moscow';
    const ANOTHER_LOCATION_ID_RAW_VALUE = 'UTC';

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
        $this->locationId = new LocationId(self::LOCATION_ID_RAW_VALUE);
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
        $this->assertSame(self::LOCATION_ID_RAW_VALUE, (string) $this->getLocation());
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
            [true, Location::of(new LocationId(self::LOCATION_ID_RAW_VALUE))],
            [false, Location::of(new LocationId(self::ANOTHER_LOCATION_ID_RAW_VALUE))],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    private function getLocation(): Location
    {
        return $this->location;
    }

    private function getLocationId(): LocationId
    {
        return $this->locationId;
    }
}
