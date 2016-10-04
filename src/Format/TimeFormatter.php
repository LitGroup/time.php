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
 * Interface of a local time formatter.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface TimeFormatter
{
    public function formatTime(Time $time): string;
}