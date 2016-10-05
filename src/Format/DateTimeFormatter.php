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

use LitGroup\Time\LocalDateTime;
use LitGroup\Time\ZonedDateTime;

/**
 * Interface of date and time formatter.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface DateTimeFormatter
{
    /**
     * Returns string representation of the zoned date and time.
     */
    public function formatZoned(ZonedDateTime $dateTime): string;

    /**
     * Returns string representation of the date and time.
     *
     * If format contains timezone name or offset than UTC offset will be used.
     */
    public function formatLocal(LocalDateTime $dateTime): string;
}