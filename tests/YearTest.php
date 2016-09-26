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
use LitGroup\Time\Year;

class YearTest extends \PHPUnit_Framework_TestCase
{
    const VALUE = 2016;

    /**
     * @test
     */
    public function itHasAValue()
    {
        $this->assertSame(self::VALUE, $this->createYear()->getValue());
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\DateTimeException
     * @dataProvider getIllegalValueExamples
     */
    public function itThrowsAnExceptionIfValueIsIllegalDuringInstantiationFromIsoNumberOfYear(int $value)
    {
        Year::of($value);
    }

    public function getIllegalValueExamples(): array
    {
        return [
            [Year::MIN_VALUE - 1],
            [Year::MAX_VALUE + 1],
        ];
    }

    /**
     * @test
     */
    public function itIsEqualToAnotherOne()
    {
        $year = $this->createYear(self::VALUE);
        $this->assertInstanceOf(Equatable::class, $year);

        $this->assertTrue($year->equals($this->createYear(self::VALUE)));
        $this->assertFalse($year->equals($this->createYear(self::VALUE - 1)));
        $this->assertFalse($year->equals($this->createYear(self::VALUE + 1)));

        $anotherEquatable = $this->createMock(Equatable::class);
        $this->assertFalse($year->equals($anotherEquatable));
    }

    private function createYear(int $value = self::VALUE): Year
    {
        return Year::of($value);
    }
}
