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

namespace LitGroup\Time\Format;

use LitGroup\Time\Date;
use LitGroup\Time\Exception\DateTimeException;
use LitGroup\Time\Exception\FormatException;

/**
 * Parses date from a string of frequently used format: `YYYY-MM-DD`.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class SimpleDateParser implements DateParser
{
    public function parseDate(string $str): Date
    {
        $matches = [];
        try {
            if (preg_match('/^(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})$/Ds', $str, $matches) === 1) {
                return Date::of(
                    intval($matches['year'], 10),
                    intval($matches['month'], 10),
                    intval($matches['day'], 10)
                );
            }
        } catch (DateTimeException $e) {
            // Nothing to do here.
        }

        throw FormatException::invalidDateFormat($str);
    }
}