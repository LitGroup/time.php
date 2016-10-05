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

namespace Test\LitGroup\Time\Format;

use LitGroup\Time\Format\SimpleTimeParser;
use LitGroup\Time\Format\TimeParser;
use LitGroup\Time\Time;

class SimpleTimeParserTest extends TimeParserTestCase
{
    public function createParser(): TimeParser
    {
        return new SimpleTimeParser();
    }

    public function getParsingExamples(): array
    {
        return [
            ['00:00', Time::of(0, 0, 0)],
            ['01:02', Time::of(1, 2, 0)],
            ['23:59', Time::of(23, 59, 0)],
            ['00:00:00', Time::of(0, 0, 0)],
            ['01:02:03', Time::of(1, 2, 3)],
            ['23:59:45', Time::of(23, 59, 45)],
            ['23:59:59', Time::of(23, 59, 59)],
        ];
    }

    public function getParsingFailureExamples(): array
    {
        return [
            [''],
            ['some text'],
            ['0:0'],
            ['0:0:0'],
            [' 00:00:00'],
            ['00:00:00 '],
            ['00/00/00'],
            ['24:00:00'],
            ['23:60:00'],
            ['23:00:60'],
        ];
    }
}
