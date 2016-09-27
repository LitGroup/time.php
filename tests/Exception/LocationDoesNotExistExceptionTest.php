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
use LitGroup\Time\Exception\LocationDoesNotExistException;
use LitGroup\Time\LocationId;

class LocationDoesNotExistExceptionTest extends \PHPUnit_Framework_TestCase
{
    const LOCATION_ID = 'Non/Existent';
    const MESSAGE = 'Location with id "Non/Existent" does not exist.';

    /**
     * @var LocationDoesNotExistException
     */
    private $exception;

    private $locationId;

    protected function setUp()
    {
        $this->locationId = new LocationId(self::LOCATION_ID);
        $this->exception = new LocationDoesNotExistException($this->locationId);
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
    public function itHasAnIdOfLocationWhichCannotBeFound()
    {
        $this->assertSame($this->getLocationId(), $this->getException()->getIdOfSoughtLocation());
    }

    private function getException(): LocationDoesNotExistException
    {
        return $this->exception;
    }

    private function getLocationId(): LocationId
    {
        return $this->locationId;
    }
}
