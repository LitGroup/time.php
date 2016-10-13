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

use LitGroup\Enumerable\Test\EnumerableTestCase;
use LitGroup\Time\Month;

class MonthTest extends EnumerableTestCase
{
    /**
     * @test
     */
    public function itIsInitializable()
    {
        $this->assertEnumHasRawValues([
            1 => Month::january(),
            2 => Month::february(),
            3 => Month::march(),
            4 => Month::april(),
            5 => Month::may(),
            6 => Month::june(),
            7 => Month::july(),
            8 => Month::august(),
            9 => Month::september(),
            10 => Month::october(),
            11 => Month::november(),
            12 => Month::december(),
        ]);
    }

    /**
     * @test
     * @dataProvider getComparisonExamples
     */
    public function itIsComparable(int $result, Month $one, Month $another)
    {
        $this->assertSame($result, $one->compare($another));
        $this->assertSame($result > 0, $one->greaterThan($another));
        $this->assertSame($result >= 0, $one->greaterThanOrEqual($another));
        $this->assertSame($result < 0, $one->lessThan($another));
        $this->assertSame($result <= 0, $one->lessThanOrEqual($another));
    }

    public function getComparisonExamples(): array
    {
        return [
            [0, Month::january(), Month::january()],
            [1, Month::march(), Month::february()],
            [-1, Month::march(), Month::april()],
        ];
    }
}
