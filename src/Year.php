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
use LitGroup\Time\Exception\DateTimeException;

final class Year implements Equatable
{
    const MIN_VALUE = 0;
    const MAX_VALUE = 9999;

    /**
     * @var int
     */
    private $value;

    public static function of(int $isoYear): Year
    {
        return new self($isoYear);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Year &&
            $another->getValue() === $this->getValue();
    }

    private function __construct(int $value)
    {
        $this->setValue($value);
    }

    private function setValue(int $value)
    {
        assert($this->value === null, 'Cannot be initialized twice.');

        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE) {
            throw new DateTimeException(sprintf(
                'Year cannot be less than %d or greater than %d, but %d given.',
                self::MIN_VALUE,
                self::MAX_VALUE,
                $value
            ));
        }

        $this->value = $value;
    }
}