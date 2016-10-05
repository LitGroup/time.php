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

namespace LitGroup\Time\Format;

use LitGroup\Time\Exception\DateTimeException;
use LitGroup\Time\Exception\FormatException;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\Location;
use LitGroup\Time\ZonedDateTime;

/**
 * Parses date from a string of frequently used format: `YYYY-MM-DD HH:mm:ss`.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class SimpleDateTimeParser implements DateTimeParser
{
    public function parseLocal(string $str): LocalDateTime
    {
        try {
            $matches = [];
            if (
                preg_match(
                    '/^(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2}) (?<hour>\d{2}):(?<minute>\d{2}):(?<second>\d{2})$/Ds',
                    $str,
                    $matches
                ) === 1
            ) {
                return LocalDateTime::of(
                    intval($matches['year'], 10),
                    intval($matches['month'], 10),
                    intval($matches['day'], 10),
                    intval($matches['hour'], 10),
                    intval($matches['minute'], 10),
                    intval($matches['second'], 10)
                );
            }
        } catch (DateTimeException $e) {
            // Nothing to do here.
        }

        throw FormatException::invalidDateTimeFormat($str);
    }

    public function parseZoned(Location $location, string $str): ZonedDateTime
    {
        $localDateTime = $this->parseLocal($str);

        return ZonedDateTime::ofDateAndTime($location, $localDateTime->getDate(), $localDateTime->getTime());
    }
}