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

namespace Test\LitGroup\Time\Exception;

use LitGroup\Time\Exception\DateTimeException;
use LitGroup\Time\Exception\TimeZoneDoesNotExistException;
use LitGroup\Time\TimeZoneId;

class TimeZoneDoesNotExistExceptionTest extends \PHPUnit_Framework_TestCase
{
    const TIMEZONE_ID = 'Non/Existent';
    const MESSAGE = 'Time zone with id "Non/Existent" does not exist.';

    /**
     * @var TimeZoneDoesNotExistException
     */
    private $exception;

    /**
     * @var TimeZoneId
     */
    private $timeZoneId;

    protected function setUp()
    {
        $this->timeZoneId = new TimeZoneId(self::TIMEZONE_ID);
        $this->exception = new TimeZoneDoesNotExistException($this->timeZoneId);
    }

    /**
     * @test
     * @testdox It s a subtype of DateTimeException
     */
    public function itIsASubtypeOfDateTimeException()
    {
        $this->assertInstanceOf(DateTimeException::class, $this->getException());
    }

    /**
     * @test
     */
    public function itHasAMessage()
    {
        $this->assertSame(self::MESSAGE, $this->getException()->getMessage());
    }

    /**
     * @test
     */
    public function itHasAnIdOfTimeZoneWhichCannotBeFound()
    {
        $this->assertSame($this->getTimeZoneId(), $this->getException()->getIdOfSoughtTimeZone());
    }

    private function getException(): TimeZoneDoesNotExistException
    {
        return $this->exception;
    }

    private function getTimeZoneId(): TimeZoneId
    {
        return $this->timeZoneId;
    }
}
