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

use LitGroup\Time\LocalDateTime;
use LitGroup\Time\Location;
use LitGroup\Time\ZonedDateTime;
use LitGroup\Time\Exception\FormatException;

/**
 * Interface of date and time parser.
 *
 * @author Roman Sahmritskiy <roman@litgroup.ru>
 */
interface Parser
{
    /**
     * Parses LocalDateTime from string.
     *
     * Information about time zone will be omitted.
     *
     * @throws FormatException
     */
    public function parseLocal(string $str): LocalDateTime;

    /**
     * Parses ZonedDateTime from string.
     *
     * @throws FormatException
     */
    public function parseZoned(Location $location, string $str): ZonedDateTime;
}