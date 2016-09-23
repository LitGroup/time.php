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
 * This is the common interface for date-objects in the ISO-8601 calendar system.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface Date
{
    public function getYear(): Year;

    public function getMonth(): Month;

    public function getDayOfMonth(): int;
}