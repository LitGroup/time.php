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

namespace LitGroup\Time\Exception;

use LitGroup\Time\TimeZoneId;

/**
 * TimeZoneDoesNotExistException
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class TimeZoneDoesNotExistException extends DateTimeException
{
    /**
     * @var TimeZoneId
     */
    private $timeZoneId;

    public function __construct(TimeZoneId $timeZoneId)
    {
        parent::__construct(sprintf('Time zone with id "%s" does not exist.', (string) $timeZoneId));
        $this->timeZoneId = $timeZoneId;
    }

    public function getIdOfSoughtTimeZone(): TimeZoneId
    {
        return $this->timeZoneId;
    }
}