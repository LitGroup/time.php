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
use LitGroup\Time\Offset;

class OffsetTest extends \PHPUnit_Framework_TestCase
{
    const ABBREVIATION = 'MSK';
    const TOTAL_SECONDS = 10800;

    const ANOTHER_ABBREVIATION = 'MSD';
    const ANOTHER_TOTAL_SECONDS = 14400;

    /**
     * @test
     */
    public function itHasAnAbbreviation()
    {
        $zone = $this->createOffset();
        $this->assertSame(self::ABBREVIATION, $zone->getAbbreviation());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getEmptyAbbreviationExamples
     */
    public function itThrowsAnExceptionWhenAbbreviationIsEmptyDuringInstantiation(string $abbr)
    {
        $this->createOffset($abbr);
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
    public function itHasAValueOfTotalSeconds()
    {
        $zone = $this->createOffset();
        $this->assertSame(self::TOTAL_SECONDS, $zone->getTotalSeconds());
    }

    /**
     * @test
     * @dataProvider getIdExamples
     */
    public function itHasAnId(string $expectedId, int $offset)
    {
        $zone = $this->createOffset(self::ABBREVIATION, $offset);
        $this->assertSame($expectedId, $zone->getId());
    }

    public function getIdExamples(): array
    {
        return [
            ['Z', 0],
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
            ['+03:30:10', 12610],
            ['-03:30:10', -12610],
        ];
    }

    /**
     * @test
     */
    public function itCanRepresentDailySavingTimeOrNot()
    {
        $this->assertTrue($this->createOffset(self::ABBREVIATION, self::TOTAL_SECONDS, true)->isDst());
        $this->assertFalse($this->createOffset(self::ABBREVIATION, self::TOTAL_SECONDS, false)->isDst());
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $zone = $this->createOffset();
        $this->assertInstanceOf(Equatable::class, $zone);
        $this->assertSame($equal, $zone->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, $this->createOffset(self::ABBREVIATION, self::TOTAL_SECONDS, false)],
            [false, $this->createOffset(self::ANOTHER_ABBREVIATION)],
            [false, $this->createOffset(self::ABBREVIATION, self::ANOTHER_TOTAL_SECONDS)],
            [false, $this->createOffset(self::ABBREVIATION, self::TOTAL_SECONDS, true)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    /**
     * @test
     */
    public function itIsSerializable()
    {
        $offset = $this->createOffset();
        $this->assertInstanceOf(\Serializable::class, $offset);

        $serialized = \serialize($offset);
        $this->assertTrue($this->createOffset()->equals(\unserialize($serialized)));
    }

    private function createOffset(string $abbr = self::ABBREVIATION, int $offset = self::TOTAL_SECONDS, bool $dst = false): Offset
    {
        return new Offset($abbr, $offset, $dst);
    }
}
