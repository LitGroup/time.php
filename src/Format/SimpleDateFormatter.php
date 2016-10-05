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

use LitGroup\Time\Date;

/**
 * Makes formatting of date to the simple, but frequently used format: `YYYY-MM-DD`.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class SimpleDateFormatter implements DateFormatter
{
    public function formatDate(Date $date): string
    {
        return sprintf(
            "%'04d-%'02d-%'02d",
            $date->getYear()->getRawValue(),
            $date->getMonth()->getRawValue(),
            $date->getDayOfMonth()
        );
    }
}