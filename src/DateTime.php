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
 * Basic interface for value-object with date and time.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface DateTime
{
    public function getDate(): Date;

    public function getTime(): Time;
}