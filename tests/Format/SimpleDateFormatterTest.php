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

namespace Test\LitGroup\Time\Format;

use LitGroup\Time\Date;
use LitGroup\Time\Format\DateFormatter;
use LitGroup\Time\Format\SimpleDateFormatter;

class SimpleDateFormatterTest extends DateFormatterTestCase
{
    public function createFormatter(): DateFormatter
    {
        return new SimpleDateFormatter();
    }

    public function getFormattingExamples(): array
    {
        return [
            [Date::of(1, 2, 3),      '0001-02-03'],
            [Date::of(12, 11, 12),   '0012-11-12'],
            [Date::of(123, 10, 20),  '0123-10-20'],
            [Date::of(1234, 12, 31), '1234-12-31']
        ];
    }
}
