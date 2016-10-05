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

use LitGroup\Time\Time;

/**
 * Makes formatting of time to the simple, but frequently used format: `HH:mm:ss`.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class SimpleTimeFormatter implements TimeFormatter
{
    public function formatTime(Time $time): string
    {
        return sprintf("%'02d:%'02d:%'02d", $time->getHour(), $time->getMinute(), $time->getSecond());
    }
}