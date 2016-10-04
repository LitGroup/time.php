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
    const MESSAGE = 'Some exception message.';

    /**
     * @var FormatException
     */
    private $exception;

    protected function setUp()
    {
        $this->exception = new FormatException(self::MESSAGE);
    }

    /**
     * @test
     */
    public function itIsASubtypeOfException()
    {
        $this->assertInstanceOf(\Exception::class, $this->getFormatException());
    }

    /**
     * @test
     */
    public function itHasAMessage()
    {
        $this->assertSame(self::MESSAGE, $this->getFormatException()->getMessage());
    }

    private function getFormatException(): FormatException
    {
        return $this->exception;
    }
}
