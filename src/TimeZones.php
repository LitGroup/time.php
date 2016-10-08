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

namespace LitGroup\Time;

use LitGroup\Time\Exception\TimeZoneDoesNotExistException;

/**
 * Repository of time zones.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class TimeZones
{
    /**
     * @var array|null
     */
    private static $zonesMap;

    /**
     * Factory method for instantiation of TimeZoneId.
     */
    public function createId(string $rawIdValue): TimeZoneId
    {
        return new TimeZoneId($rawIdValue);
    }

    /**
     * @throws TimeZoneDoesNotExistException
     */
    public function getTimeZoneOf(TimeZoneId $timeZoneId): TimeZone
    {
        if (!self::timeZoneExists($timeZoneId)) {
            throw new TimeZoneDoesNotExistException($timeZoneId);
        }

        return self::getTimeZonesMap()[$timeZoneId->getRawValue()];
    }

    /**
     * @return TimeZone[]|array
     */
    public function getAllTimeZones(): array
    {
        return array_values(self::getTimeZonesMap());
    }

    private function timeZoneExists(TimeZoneId $id): bool
    {
        return \array_key_exists($id->getRawValue(), self::getTimeZonesMap());
    }

    private function getTimeZonesMap(): array
    {
        if (self::$zonesMap === null) {
            self::$zonesMap = [];
            foreach (\DateTimeZone::listIdentifiers() as $rawId) {
                self::$zonesMap[$rawId] = TimeZone::ofId(new TimeZoneId($rawId));
            }
        }

        return self::$zonesMap;
    }
}