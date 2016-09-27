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

namespace Test\LitGroup\Time;

use LitGroup\Equatable\Equatable;
use LitGroup\Time\ZoneId;

class ZoneIdTest extends \PHPUnit_Framework_TestCase
{
    const RAW_VALUE = 'MSK';
    const ANOTHER_RAW_VALUE = 'GMT';

    /**
     * @test
     */
    public function itHasARawValue()
    {
        $id = $this->createZoneId();
        $this->assertSame(self::RAW_VALUE,$id->getRawValue());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getEmptyRawValueExamples
     */
    public function itThrowsAnExceptionWhenRawValueIsEmptyDuringInstantiation(string $rawValue)
    {
        $this->createZoneId($rawValue);
    }

    public function getEmptyRawValueExamples(): array
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
        $this->assertSame(self::RAW_VALUE, (string) $this->createZoneId());
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $id = $this->createZoneId();
        $this->assertInstanceOf(Equatable::class, $id);
        $this->assertSame($equal, $id->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, $this->createZoneId(self::RAW_VALUE)],
            [false, $this->createZoneId(self::ANOTHER_RAW_VALUE)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    private function createZoneId(string $rawValue = self::RAW_VALUE): ZoneId
    {
        return new ZoneId($rawValue);
    }
}
