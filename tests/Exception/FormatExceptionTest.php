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

namespace Test\LitGroup\Time\Exception;

use LitGroup\Time\Exception\FormatException;

class FormatExceptionTest extends \PHPUnit_Framework_TestCase
{
    const INVALID_STRING = 'some invalid string';

    const MESSAGE = 'Some message.';
    const INVALID_DATE_FORMAT_MESSAGE = 'Given string does not contain valid date: "some invalid string".';
    const INVALID_TIME_FORMAT_MESSAGE = 'Given string does not contain valid time: "some invalid string".';
    const INVALID_DATETIME_FORMAT_MESSAGE = 'Given string does not contain valid date and time: "some invalid string".';

    /**
     * @test
     */
    public function itIsASubtypeOfException()
    {
        $this->assertInstanceOf(\Exception::class, $this->createFormatException());
    }

    /**
     * @test
     */
    public function itHasAMessage()
    {
        $this->assertSame(self::MESSAGE, $this->createFormatException()->getMessage());
    }

    /**
     * @test
     */
    public function itHasAnInvalidString()
    {
        $this->assertSame(self::INVALID_STRING, $this->createFormatException()->getInvalidString());
    }

    /**
     * @test
     * @testdox It can be constructed through invalidDateFormat() factory
     */
    public function itCanBeConstructedThroughInvalidDateFormatFactory()
    {
        $exception = FormatException::invalidDateFormat(self::INVALID_STRING);
        $this->assertInstanceOf(FormatException::class, $exception);
        $this->assertSame(self::INVALID_DATE_FORMAT_MESSAGE, $exception->getMessage());
        $this->assertSame(self::INVALID_STRING, $exception->getInvalidString());
    }

    /**
     * @test
     * @testdox It can be constructed through invalidTimeFormat() factory
     */
    public function itCanBeConstructedThroughInvalidTimeFormatFactory()
    {
        $exception = FormatException::invalidTimeFormat(self::INVALID_STRING);
        $this->assertInstanceOf(FormatException::class, $exception);
        $this->assertSame(self::INVALID_TIME_FORMAT_MESSAGE, $exception->getMessage());
        $this->assertSame(self::INVALID_STRING, $exception->getInvalidString());
    }

    /**
     * @test
     * @testdox It can be constructed through invalidDateTimeFormat() factory
     */
    public function itCanBeConstructedThroughInvalidDateTimeFormatFactory()
    {
        $exception = FormatException::invalidDateTimeFormat(self::INVALID_STRING);
        $this->assertInstanceOf(FormatException::class, $exception);
        $this->assertSame(self::INVALID_DATETIME_FORMAT_MESSAGE, $exception->getMessage());
        $this->assertSame(self::INVALID_STRING, $exception->getInvalidString());
    }

    private function createFormatException(): FormatException
    {
        return new FormatException(self::MESSAGE, self::INVALID_STRING);
    }
}
