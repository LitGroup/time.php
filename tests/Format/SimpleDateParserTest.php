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
use LitGroup\Time\Format\DateParser;
use LitGroup\Time\Format\SimpleDateParser;

class SimpleDateParserTest extends DateParserTestCase
{
    public function createParser(): DateParser
    {
        return new SimpleDateParser();
    }

    public function getParsingExamples(): array
    {
        return [
            ['0001-02-03', Date::of(1, 2, 3)],
            ['2016-02-29', Date::of(2016, 2, 29)],
            ['2016-12-31', Date::of(2016, 12, 31)],
        ];
    }

    public function getParsingFailureExamples(): array
    {
        return [
            [''],
            ['some text'],
            [' 2016-12-31'],
            ['2016-12-31 '],
            ['16-01-01'],
            ['2016-1-01'],
            ['2016-01-1'],
            ['2016/12/31'],
            ['2016.12.31'],
            ['0000-01-01'],
            ['0001-00-01'],
            ['0001-01-00'],
            ['2016-13-31'],
            ['2016-12-33'],
            ['2015-02-29'],
        ];
    }

}
