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
use LitGroup\Time\TimeZoneId;

class TimeZoneIdTest extends \PHPUnit_Framework_TestCase
{
    const RAW_VALUE = 'Europe/Moscow';
    const ANOTHER_RAW_VALUE = 'UTC';

    /**
     * @test
     */
    public function itHasARawValue()
    {
        $id = $this->createTimeZoneId();
        $this->assertSame(self::RAW_VALUE, $id->getRawValue());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getInvalidRawValueExamples
     */
    public function itThrowsAnExceptionWhenRawValueIsEmptyDuringInstantiation(string $rawValue)
    {
        $this->createTimeZoneId($rawValue);
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
        $id = $this->createTimeZoneId();
        $this->assertSame(self::RAW_VALUE, (string) $id);
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $id = $this->createTimeZoneId(self::RAW_VALUE);
        $this->assertInstanceOf(Equatable::class, $id);
        $this->assertSame($equal, $id->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, $this->createTimeZoneId(self::RAW_VALUE)],
            [false, $this->createTimeZoneId(self::ANOTHER_RAW_VALUE)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    private function createTimeZoneId(string $rawValue = self::RAW_VALUE): TimeZoneId
    {
        return new TimeZoneId($rawValue);
    }
}
