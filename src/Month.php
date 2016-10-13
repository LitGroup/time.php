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

use LitGroup\Enumerable\Enumerable;

/**
 * A month-of-year, such as "August".
 *
 * Month is an enum representing the 12 months of the year - January, February,
 * March, April, May, June, July, August, September, October, November and December.
 *
 * In addition to the textual enum name, each month-of-year has an int value.
 * The int value follows normal usage and the ISO-8601 standard, from 1 (January) to 12 (December).
 * It is recommended that applications use the enum rather than the int value to ensure code clarity.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class Month extends Enumerable
{
    public static function january(): Month
    {
        return self::createEnum(1);
    }

    public static function february(): Month
    {
        return self::createEnum(2);
    }

    public static function march(): Month
    {
        return self::createEnum(3);
    }

    public static function april(): Month
    {
        return self::createEnum(4);
    }

    public static function may(): Month
    {
        return self::createEnum(5);
    }

    public static function june(): Month
    {
        return self::createEnum(6);
    }

    public static function july(): Month
    {
        return self::createEnum(7);
    }

    public static function august(): Month
    {
        return self::createEnum(8);
    }

    public static function september(): Month
    {
        return self::createEnum(9);
    }

    public static function october(): Month
    {
        return self::createEnum(10);
    }

    public static function november(): Month
    {
        return self::createEnum(11);
    }

    public static function december(): Month
    {
        return self::createEnum(12);
    }

    public function compare(Month $another): int
    {
        return $this->getRawValue() <=> $another->getRawValue();
    }

    public function greaterThan(Month $another): bool
    {
        return $this->compare($another) > 0;
    }

    public function greaterThanOrEqual(Month $another): bool
    {
        return $this->compare($another) >= 0;
    }

    public function lessThan(Month $another): bool
    {
        return $this->compare($another) < 0;
    }

    public function lessThanOrEqual(Month $another): bool
    {
        return $this->compare($another) <= 0;
    }
}