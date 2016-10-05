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

namespace LitGroup\Time\Exception;

use Exception;

class FormatException extends Exception
{
    /**
     * @var string
     */
    private $invalidString;

    public static function invalidDateFormat(string $invalidString): FormatException
    {
        return new self(
            self::createMessageFor('date', $invalidString),
            $invalidString
        );
    }

    public static function invalidTimeFormat(string $invalidString): FormatException
    {
        return new self(
            self::createMessageFor('time', $invalidString),
            $invalidString
        );
    }

    public static function invalidDateTimeFormat(string $invalidString): FormatException
    {
        return new self(
            self::createMessageFor('date and time', $invalidString),
            $invalidString
        );
    }

    public function __construct(string $message, string $invalidString)
    {
        parent::__construct($message);
        $this->invalidString = $invalidString;
    }

    public function getInvalidString(): string
    {
        return $this->invalidString;
    }

    private static function createMessageFor(string $temporalType, string $invalidString): string
    {
        return sprintf('Given string does not contain valid %s: "%s".', $temporalType, $invalidString);
    }
}