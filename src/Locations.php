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

use LitGroup\Time\Exception\LocationDoesNotExistException;

/**
 * Repository of locations.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Locations
{
    /**
     * @var array|null
     */
    private static $locationsMap;

    /**
     * Factory method for instantiation of LocationId.
     */
    public function createId(string $rawIdValue): LocationId
    {
        return new LocationId($rawIdValue);
    }

    /**
     * @throws LocationDoesNotExistException
     */
    public function getLocationOf(LocationId $locationId): Location
    {
        if (!self::locationExists($locationId)) {
            throw new LocationDoesNotExistException($locationId);
        }

        return self::getLocationsMap()[$locationId->getRawValue()];
    }

    /**
     * @return Location[]|array
     */
    public function getAllLocations(): array
    {
        return array_values(self::getLocationsMap());
    }

    private function locationExists(LocationId $id): bool
    {
        return \array_key_exists($id->getRawValue(), self::getLocationsMap());
    }

    private function getLocationsMap(): array
    {
        if (self::$locationsMap === null) {
            self::$locationsMap = [];
            foreach (\DateTimeZone::listIdentifiers() as $rawLocationId) {
                self::$locationsMap[$rawLocationId] = Location::ofId(new LocationId($rawLocationId));
            }
        }

        return self::$locationsMap;
    }
}