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

use LitGroup\Time\Format\DateTimeFormatter;
use LitGroup\Time\Format\SimpleDateTimeFormatter;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\Location;
use LitGroup\Time\ZonedDateTime;

class SimpleDateTimeFormatterTest extends DateTimeFormatterTestCase
{
    public function createFormatter(): DateTimeFormatter
    {
        return new SimpleDateTimeFormatter();
    }

    public function getLocalFormattingExamples(): array
    {
        return [
            [LocalDateTime::of(1, 2, 3, 4, 5, 6), '0001-02-03 04:05:06'],
            [LocalDateTime::of(2016, 12, 31, 23, 59, 45), '2016-12-31 23:59:45'],
        ];
    }

    public function getZonedFormattingExamples(): array
    {
        return [
            [ZonedDateTime::of(Location::utc(), 1, 2, 3, 4, 5, 6), '0001-02-03 04:05:06'],
            [ZonedDateTime::of(Location::utc(), 2016, 12, 31, 23, 59, 45), '2016-12-31 23:59:45'],
            [ZonedDateTime::of(Location::of('Europe/Moscow'), 1, 2, 3, 4, 5, 6), '0001-02-03 04:05:06'],
            [ZonedDateTime::of(Location::of('Europe/Moscow'), 2016, 12, 31, 23, 59, 45), '2016-12-31 23:59:45'],
        ];
    }
}
