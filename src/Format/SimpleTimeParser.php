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
use LitGroup\Time\Time;

/**
 * Parses time from a string representation of frequently used formats: `HH:mm` and `HH:mm:ss`.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class SimpleTimeParser implements TimeParser
{
    public function parseTime(string $str): Time
    {
        try {
            $matches = [];
            if (preg_match('/^(?<hour>\d{2}):(?<minute>\d{2})(?::(?<second>\d{2}))?$/Ds', $str, $matches) === 1) {
                return Time::of(
                    intval($matches['hour'], 10),
                    intval($matches['minute'], 10),
                    array_key_exists('second', $matches) ? intval($matches['second'], 10) : 0
                );
            }
        } catch (DateTimeException $e) {
            // Nothing to do here.
        }

        throw FormatException::invalidTimeFormat($str);
    }
}