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
use LitGroup\Time\Exception\DateTimeException;
use Serializable;

/**
 * A year in the ISO-8601 calendar system, such as 2007.
 *
 * Year is an immutable date-time object that represents a year.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class Year implements Equatable, Serializable
{
    const MIN_VALUE = 1;
    const MAX_VALUE = 9999;

    /**
     * @var int
     */
    private $rawValue;

    public static function of(int $isoYear): Year
    {
        return new self($isoYear);
    }

    public function getRawValue(): int
    {
        return $this->rawValue;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Year &&
            $another->getRawValue() === $this->getRawValue();
    }

    public function compare(Year $another): int
    {
        return $this->getRawValue() <=> $another->getRawValue();
    }

    public function greaterThan(Year $another): bool
    {
        return $this->compare($another) > 0;
    }

    public function greaterThanOrEqual(Year $another): bool
    {
        return $this->compare($another) >= 0;
    }

    public function lessThan(Year $another): bool
    {
        return $this->compare($another) < 0;
    }

    public function lessThanOrEqual(Year $another): bool
    {
        return $this->compare($another) <= 0;
    }

    private function __construct(int $rawValue)
    {
        $this->init($rawValue);
    }

    public function serialize()
    {
        return serialize($this->rawValue);
    }

    public function unserialize($serialized)
    {
        $this->init(unserialize($serialized));
    }

    private function init(int $rawValue)
    {
        assert($this->rawValue === null);

        if ($rawValue < self::MIN_VALUE || $rawValue > self::MAX_VALUE) {
            throw new DateTimeException(sprintf(
                'Year cannot be less than %d or greater than %d, but %d given.',
                self::MIN_VALUE,
                self::MAX_VALUE,
                $rawValue
            ));
        }

        $this->rawValue = $rawValue;
    }
}