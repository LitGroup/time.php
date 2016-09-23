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

namespace LitGroup\Time;

/**
 * This interface defines common methods for representation of time in the ISO-8601 calendar system.
 *
 * @author Roman Shamritskiy <rman@litgroup.ru>
 */
interface Time
{
    public function getHour(): int;

    public function getMinute(): int;

    public function getSecond(): int;
}