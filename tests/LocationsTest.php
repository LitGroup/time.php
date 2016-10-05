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

use LitGroup\Time\Location;
use LitGroup\Time\LocationId;
use LitGroup\Time\Locations;

class LocationsTest extends \PHPUnit_Framework_TestCase
{
    const LOCATION_ID = 'Europe/Moscow';

    /**
     * @var Locations
     */
    private $locations;

    protected function setUp()
    {
        $this->locations = new Locations();
    }

    /**
     * @test
     */
    public function itCreatesALocationIdByRawValue()
    {
        $id = $this->getLocations()->createId(self::LOCATION_ID);
        $this->assertInstanceOf(LocationId::class, $id);
        $this->assertSame(self::LOCATION_ID, $id->getRawValue());
    }

    /**
     * @test
     * @dataProvider getLocationByIdExamples
     */
    public function itReturnsALocationByLocationId(LocationId $locationId)
    {
        $location = $this->getLocations()->getLocationOf($locationId);
        $this->assertInstanceOf(Location::class, $location);
        $this->assertTrue($locationId->equals($location->getId()));
    }

    public function getLocationByIdExamples(): \Generator
    {
        foreach (\DateTimeZone::listIdentifiers() as $rawId) {
            yield [new LocationId($rawId)];
        }
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\LocationDoesNotExistException
     */
    public function itThrowsAnExceptionWhenLocationWithDefinedIdDoesNotExistDuringSearch()
    {
        $this->getLocations()->getLocationOf(new LocationId('Not/Existent'));
    }

    /**
     * @test
     */
    public function itProvidesListOfLocations()
    {
        $expectedRawIds = \DateTimeZone::listIdentifiers();
        $returnedRawIds = array_map(
            function (Location $location): string {
                return $location->getId()->getRawValue();
            },
            $this->getLocations()->getAllLocations()
        );

        $this->assertSame($expectedRawIds, $returnedRawIds);
    }

    private function getLocations(): Locations
    {
        return $this->locations;
    }
}
