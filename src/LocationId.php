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

use LitGroup\Equatable\Equatable;

final class LocationId implements Equatable
{
    /**
     * @var string
     */
    private $rawValue;

    public function __construct(string $rawValue)
    {
        if (strlen(trim($rawValue)) === 0) {
            throw new \InvalidArgumentException('Raw value of LocationId cannot be empty.');
        }

        $this->rawValue = $rawValue;
    }

    public function getRawValue(): string
    {
        return $this->rawValue;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof LocationId &&
            $another->getRawValue() === $this->getRawValue();
    }


    public function __toString(): string
    {
        return $this->getRawValue();
    }
}