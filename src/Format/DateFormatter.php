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
 * Interface of a local date formatter.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface DateFormatter
{
    public function formatDate(Date $date): string;
}