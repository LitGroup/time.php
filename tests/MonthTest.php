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

use LitGroup\Enumerable\Test\EnumerableTestCase;
use LitGroup\Equatable\Equatable;
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
}
