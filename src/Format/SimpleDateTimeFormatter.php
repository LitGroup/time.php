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

use LitGroup\Time\DateTime;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\ZonedDateTime;

/**
 * Makes formatting of date and time to the simple, but frequently used format: `YYYY-MM-DD HH:mm:ss`.
 *
 * This formatter omits time zone related information for ZonedDateTime.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class SimpleDateTimeFormatter implements DateTimeFormatter
{
    public function formatZoned(ZonedDateTime $dateTime): string
    {
        return $this->doFormatting($dateTime);
    }

    public function formatLocal(LocalDateTime $dateTime): string
    {
        return $this->doFormatting($dateTime);
    }

    private function doFormatting(DateTime $dateTime): string
    {
        $date = $dateTime->getDate();
        $time = $dateTime->getTime();

        return sprintf(
            "%'04d-%'02d-%'02d %'02d:%'02d:%'02d",
            $date->getYear()->getRawValue(),
            $date->getMonth()->getRawValue(),
            $date->getDayOfMonth(),
            $time->getHour(),
            $time->getMinute(),
            $time->getSecond()
        );
    }
}