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

use LitGroup\Time\LocationId;

class LocationDoesNotExistException extends DateTimeException
{
    /**
     * @var LocationId
     */
    private $locationId;

    public function __construct(LocationId $locationId)
    {
        parent::__construct(sprintf('Location with id "%s" does not exist.', (string) $locationId));
        $this->locationId = $locationId;
    }

    public function getIdOfSoughtLocation(): LocationId
    {
        return $this->locationId;
    }
}