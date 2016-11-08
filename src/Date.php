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
 * A date without a time-zone in the ISO-8601 calendar system, such as 2007-12-03.
 *
 * It is an immutable date-time object that represents a date, often viewed as year-month-day.
 *
 * This class does not store or represent a time or time-zone. Instead, it is a description of the date,
 * as used for birthdays. It cannot represent an instant on the time-line without additional
 * information such as an offset or time-zone.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class Date implements Equatable, Serializable
{
    /**
     * @var Year
     */
    private $year;

    /**
     * @var Month
     */
    private $month;

    /**
     * @var int
     */
    private $dayOfMonth;

    public static function of(int $year, int $month = 1, int $dayOfMonth = 1): Date
    {
        try {
            return new self(Year::of($year), Month::getValueOf($month), $dayOfMonth);
        } catch (\OutOfBoundsException $e) {
            throw new DateTimeException("Invalid number of month $month.");
        }
    }

    public function __construct(Year $year, Month $month, int $dayOfMonth)
    {
        $this->init($year, $month, $dayOfMonth);
    }

    public function getYear(): Year
    {
        return $this->year;
    }

    public function getMonth(): Month
    {
        return $this->month;
    }

    public function getDayOfMonth(): int
    {
        return $this->dayOfMonth;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Date &&
            $another->getYear()->equals($this->getYear()) &&
            $another->getMonth()->equals($this->getMonth()) &&
            $another->getDayOfMonth() === $this->getDayOfMonth();
    }

    public function compare(Date $another): int
    {
        if (!$this->getYear()->equals($another->getYear())) {
            return $this->getYear()->compare($another->getYear());
        } elseif (!$this->getMonth()->equals($another->getMonth())) {
            return $this->getMonth()->compare($another->getMonth());
        } else {
            return $this->getDayOfMonth() <=> $another->getDayOfMonth();
        }
    }

    public function greaterThan(Date $another): bool
    {
        return $this->compare($another) > 0;
    }

    public function greaterThanOrEqual(Date $another): bool
    {
        return $this->compare($another) >= 0;
    }

    public function lessThan(Date $another): bool
    {
        return $this->compare($another) < 0;
    }

    public function lessThanOrEqual(Date $another): bool
    {
        return $this->compare($another) <= 0;
    }

    public function serialize()
    {
        return \serialize([
            $this->getYear(),
            $this->getMonth()->getRawValue(),
            $this->getDayOfMonth()
        ]);
    }

    public function unserialize($serialized)
    {
        list ($year, $monthNumber, $dayOfMonth) = \unserialize($serialized);
        $this->init($year, Month::getValueOf($monthNumber), $dayOfMonth);
    }

    private function init(Year $year, Month $month, int $dayOfMonth)
    {
        assert($this->year === null);
        assert($this->month === null);
        assert($this->dayOfMonth === null);

        $this->year = $year;
        $this->month = $month;

        if (!checkdate((int) $month->getRawValue(), $dayOfMonth, $year->getRawValue())) {
            throw new DateTimeException(sprintf(
                'Invalid date (Y/m/d):', $year->getRawValue(), $month->getRawValue(), $dayOfMonth));
        }
        $this->dayOfMonth = $dayOfMonth;
    }
}