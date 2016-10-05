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
use LitGroup\Time\Year;

class YearTest extends \PHPUnit_Framework_TestCase
{
    const RAW_VALUE = 2016;

    /**
     * @test
     */
    public function itHasARawValue()
    {
        $this->assertSame(self::RAW_VALUE, $this->createYear()->getRawValue());
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
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $year = $this->createYear(self::RAW_VALUE);
        $this->assertInstanceOf(Equatable::class, $year);
        $this->assertSame($equal, $year->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, Year::of(self::RAW_VALUE)],
            [false, Year::of(self::RAW_VALUE - 1)],
            [false, Year::of(self::RAW_VALUE + 1)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    private function createYear(int $value = self::RAW_VALUE): Year
    {
        return Year::of($value);
    }
}
