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

use LitGroup\Time\Format\SimpleTimeFormatter;
use LitGroup\Time\Format\TimeFormatter;
use LitGroup\Time\Time;

class SimpleTimeFormatterTest extends TimeFormatterTestCase
{
    public function createFormatter(): TimeFormatter
    {
        return new SimpleTimeFormatter();
    }

    public function getFormattingExamples(): array
    {
        return [
            [Time::of(0, 0, 0),    '00:00:00'],
            [Time::of(1, 2, 3),    '01:02:03'],
            [Time::of(23, 45, 59), '23:45:59'],
        ];
    }

}
