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

use LitGroup\Time\TimeZone;
use LitGroup\Time\TimeZoneId;
use LitGroup\Time\TimeZones;

class TimeZonesTest extends \PHPUnit_Framework_TestCase
{
    const TIMEZONE_ID = 'Europe/Moscow';

    /**
     * @var TimeZones
     */
    private $timeZones;

    protected function setUp()
    {
        $this->timeZones = new TimeZones();
    }

    /**
     * @test
     */
    public function itCreatesATimeZoneIdByRawValue()
    {
        $id = $this->getTimeZones()->createId(self::TIMEZONE_ID);
        $this->assertInstanceOf(TimeZoneId::class, $id);
        $this->assertSame(self::TIMEZONE_ID, $id->getRawValue());
    }

    /**
     * @test
     * @dataProvider getTimeZoneByIdExamples
     */
    public function itReturnsATimeZoneByTimeZoneId(TimeZoneId $timeZoneId)
    {
        $timeZone = $this->getTimeZones()->getTimeZoneOf($timeZoneId);
        $this->assertInstanceOf(TimeZone::class, $timeZone);
        $this->assertTrue($timeZoneId->equals($timeZone->getId()));
    }

    public function getTimeZoneByIdExamples(): \Generator
    {
        foreach (\DateTimeZone::listIdentifiers() as $rawId) {
            yield [new TimeZoneId($rawId)];
        }
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\TimeZoneDoesNotExistException
     */
    public function itThrowsAnExceptionWhenTimeZoneWithDefinedIdDoesNotExistDuringSearch()
    {
        $this->getTimeZones()->getTimeZoneOf(new TimeZoneId('Not/Existent'));
    }

    /**
     * @test
     */
    public function itProvidesListOfTimeZOne()
    {
        $expectedRawIds = \DateTimeZone::listIdentifiers();
        $returnedRawIds = array_map(
            function (TimeZone $timeZone): string {
                return $timeZone->getId()->getRawValue();
            },
            $this->getTimeZones()->getAllTimeZones()
        );

        $this->assertSame($expectedRawIds, $returnedRawIds);
    }

    private function getTimeZones(): TimeZones
    {
        return $this->timeZones;
    }
}
