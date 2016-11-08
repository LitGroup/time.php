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

use LitGroup\Equatable\Equatable;
use Serializable;

/**
 * Identifier of time zone. For example: Europe/Moscow.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class TimeZoneId implements Equatable, Serializable
{
    /**
     * @var string
     */
    private $rawValue;

    public function __construct(string $rawValue)
    {
        $this->init($rawValue);
    }

    public function getRawValue(): string
    {
        return $this->rawValue;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof TimeZoneId &&
            $another->getRawValue() === $this->getRawValue();
    }

    public function __toString(): string
    {
        return $this->getRawValue();
    }

    public function serialize()
    {
        return \serialize($this->getRawValue());
    }

    public function unserialize($serialized)
    {
        $this->init(\unserialize($serialized));
    }

    private function init(string $rawValue)
    {
        if (strlen(trim($rawValue)) === 0) {
            throw new \InvalidArgumentException('Raw value of TimeZoneId cannot be empty.');
        }

        $this->rawValue = $rawValue;
    }
}