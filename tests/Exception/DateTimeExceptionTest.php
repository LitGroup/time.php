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

use LitGroup\Time\Exception\DateTimeException;

class DateTimeExceptionTest extends \PHPUnit_Framework_TestCase
{
    const MESSAGE = 'Some exception message';

    /**
     * @var DateTimeException
     */
    private $exception;

    protected function setUp()
    {
        $this->exception = new DateTimeException(self::MESSAGE);
    }

    /**
     * @test
     */
    public function itIsASubtypeOfRuntimeException()
    {
        $this->assertInstanceOf(\RuntimeException::class, $this->getDateTimeException());
    }

    /**
     * @test
     */
    public function itHasAMessage()
    {
        $this->assertSame(self::MESSAGE, $this->getDateTimeException()->getMessage());
    }

    private function getDateTimeException(): DateTimeException
    {
        return $this->exception;
    }
}
