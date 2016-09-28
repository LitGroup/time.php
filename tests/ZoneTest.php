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
use LitGroup\Time\Zone;

class ZoneTest extends \PHPUnit_Framework_TestCase
{
    const ABBREVIATION = 'MSK';
    const OFFSET_IN_SECONDS = 10800;

    const ANOTHER_ABBREVIATION = 'MSD';
    const ANOTHER_OFFSET_IN_SECOND = 14400;

    /**
     * @test
     */
    public function itHasAnAbbreviation()
    {
        $zone = $this->createZone();
        $this->assertSame(self::ABBREVIATION, $zone->getAbbreviation());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getEmptyAbbreviationExamples
     */
    public function itThrowsAnExceptionWhenAbbreviationIsEmptyDuringInstantiation(string $abbr)
    {
        $this->createZone($abbr);
    }

    public function getEmptyAbbreviationExamples(): array
    {
        return [
            [''],
            ['  '],
        ];
    }

    /**
     * @test
     */
    public function itHasAnOffsetInSeconds()
    {
        $zone = $this->createZone();
        $this->assertSame(self::OFFSET_IN_SECONDS, $zone->getOffsetInSeconds());
    }

    /**
     * @test
     * @dataProvider getOffsetIdExamples
     */
    public function itHasAnOffsetId(string $expectedId, int $offset)
    {
        $zone = $this->createZone(self::ABBREVIATION, $offset);
        $this->assertSame($expectedId, $zone->getOffsetId());
    }

    public function getOffsetIdExamples(): array
    {
        return [
            ['+00:00', 0],
            ['+00:01', 60],
            ['-00:01', -60],
            ['+00:10', 600],
            ['-00:10', -600],
            ['+01:00', 3600],
            ['-01:00', -3600],
            ['+10:00', 36000],
            ['-10:00', -36000],
            ['+03:00', 10800],
            ['-03:00', -10800],
            ['+03:30', 12600],
            ['-03:30', -12600],
        ];
    }

    /**
     * @test
     */
    public function itCanRepresentDailySavingTimeOrNot()
    {
        $this->assertTrue($this->createZone(self::ABBREVIATION, self::OFFSET_IN_SECONDS, true)->isDst());
        $this->assertFalse($this->createZone(self::ABBREVIATION, self::OFFSET_IN_SECONDS, false)->isDst());
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $zone = $this->createZone();
        $this->assertInstanceOf(Equatable::class, $zone);
        $this->assertSame($equal, $zone->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, $this->createZone(self::ABBREVIATION, self::OFFSET_IN_SECONDS, false)],
            [false, $this->createZone(self::ANOTHER_ABBREVIATION)],
            [false, $this->createZone(self::ABBREVIATION, self::ANOTHER_OFFSET_IN_SECOND)],
            [false, $this->createZone(self::ABBREVIATION, self::OFFSET_IN_SECONDS, true)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    private function createZone(string $abbr = self::ABBREVIATION, int $offset = self::OFFSET_IN_SECONDS, bool $dst = false): Zone
    {
        return new Zone($abbr, $offset, $dst);
    }
}
