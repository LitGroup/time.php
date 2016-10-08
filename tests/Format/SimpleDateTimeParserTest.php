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

use LitGroup\Time\Format\DateTimeParser;
use LitGroup\Time\Format\SimpleDateTimeParser;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\TimeZone;
use LitGroup\Time\ZonedDateTime;

class SimpleDateTimeParserTest extends DateTimeParserTestCase
{
    public function createParser(): DateTimeParser
    {
        return new SimpleDateTimeParser();
    }

    public function getLocalParsingExamples(): array
    {
        return [
            ['0001-02-03 00:00:00', LocalDateTime::of(1, 2, 3)],
            ['0001-02-03 04:05:06', LocalDateTime::of(1, 2, 3, 4, 5, 6)],
            ['2016-11-24 19:37:14', LocalDateTime::of(2016, 11, 24, 19, 37, 14)],
        ];
    }

    public function getZonedParsingExamples(): array
    {
        return [
            [TimeZone::utc(), '0001-02-03 00:00:00', ZonedDateTime::of(TimeZone::utc(), 1, 2, 3)],
            [TimeZone::utc(), '0001-02-03 04:05:06', ZonedDateTime::of(TimeZone::utc(), 1, 2, 3, 4, 5, 6)],
            [TimeZone::utc(), '2016-11-24 19:37:14', ZonedDateTime::of(TimeZone::utc(), 2016, 11, 24, 19, 37, 14)],
            [TimeZone::of('Europe/Moscow'), '0001-02-03 00:00:00', ZonedDateTime::of(TimeZone::of('Europe/Moscow'), 1, 2, 3)],
            [TimeZone::of('Europe/Moscow'), '0001-02-03 04:05:06', ZonedDateTime::of(TimeZone::of('Europe/Moscow'), 1, 2, 3, 4, 5, 6)],
            [TimeZone::of('Europe/Moscow'), '2016-11-24 19:37:14', ZonedDateTime::of(TimeZone::of('Europe/Moscow'), 2016, 11, 24, 19, 37, 14)],
        ];
    }

    public function getParsingFailureExamples(): array
    {
        return [
            [''],
            ['some text'],
            [' 2016-11-24 19:37:14'],
            ['2016-11-24 19:37:14 '],
            ['1-01-01 00:00:00'],
            ['01-1-01 00:00:00'],
            ['01-01-1 00:00:00'],
            ['01-01-01 0:00:00'],
            ['01-01-01 00:0:00'],
            ['01-01-01 00:00:0'],
        ];
    }

}
