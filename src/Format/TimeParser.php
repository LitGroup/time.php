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

use LitGroup\Time\Exception\FormatException;
use LitGroup\Time\Time;

/**
 * Interface of a local time parser.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface TimeParser
{
    /**
     * @throws FormatException
     */
    public function parseTime(string $str): Time;
}