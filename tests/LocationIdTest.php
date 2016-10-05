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

namespace Test\LitGroup\Time;

use LitGroup\Equatable\Equatable;
use LitGroup\Time\LocationId;

class LocationIdTest extends \PHPUnit_Framework_TestCase
{
    const RAW_VALUE = 'Europe/Moscow';
    const ANOTHER_RAW_VALUE = 'UTC';

    /**
     * @test
     */
    public function itHasARawValue()
    {
        $id = $this->createLocationId();
        $this->assertSame(self::RAW_VALUE, $id->getRawValue());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getInvalidRawValueExamples
     */
    public function itThrowsAnExceptionWhenRawValueIsEmptyDuringInstantiation(string $rawValue)
    {
        $this->createLocationId($rawValue);
    }

    public function getInvalidRawValueExamples(): array
    {
        return [
            [''],
            ['  '],
        ];
    }

    /**
     * @test
     */
    public function itCanBeConvertedToString()
    {
        $id = $this->createLocationId();
        $this->assertSame(self::RAW_VALUE, (string) $id);
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $id = $this->createLocationId(self::RAW_VALUE);
        $this->assertInstanceOf(Equatable::class, $id);
        $this->assertSame($equal, $id->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, $this->createLocationId(self::RAW_VALUE)],
            [false, $this->createLocationId(self::ANOTHER_RAW_VALUE)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    private function createLocationId(string $rawValue = self::RAW_VALUE): LocationId
    {
        return new LocationId($rawValue);
    }
}
