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
use LitGroup\Time\TimeZone;
use LitGroup\Time\TimeZoneId;
use LitGroup\Time\Offset;

class TimeZoneTest extends \PHPUnit_Framework_TestCase
{
    const ID = 'Europe/Moscow';
    const ANOTHER_ID = 'UTC';

    const OFFSET_SECONDS = 10800;
    const OFFSET_ABBR = 'MSK';
    const OFFSET_DST = false;

    const TIMESTAMP = 1470269107;

    /**
     * @test
     */
    public function itHasAnId()
    {
        $this->assertTrue(
            $this->createTimeZoneId()->equals(
                $this->createTimeZone()->getId()
            )
        );
    }

    /**
     * @test
     */
    public function itCanBeConvertedToString()
    {
        $this->assertSame(self::ID, (string) $this->createTimeZone());
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $timeZone = $this->createTimeZone();
        $this->assertInstanceOf(Equatable::class, $timeZone);
        $this->assertSame($equal, $timeZone->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, $this->createTimeZone(self::ID)],
            [false, $this->createTimeZone(self::ANOTHER_ID)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    /**
     * @test
     */
    public function itProvidesAnOffset()
    {
        $timeZone = $this->createTimeZone();
        $expectedZone = new Offset(self::OFFSET_ABBR, self::OFFSET_SECONDS, self::OFFSET_DST);

        $this->assertTrue($expectedZone->equals($timeZone->getOffsetAt(self::TIMESTAMP)));
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodWithInitializationByRawId()
    {
        $this->assertTrue(
            $this->createTimeZone()->equals(TimeZone::of(self::ID))
        );
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodForInstantiationOfUtcTimeZone()
    {
        $timeZone = TimeZone::utc();

        $this->assertInstanceOf(TimeZone::class, $timeZone);
        $this->assertTrue(TimeZone::of('UTC')->equals($timeZone));
    }

    /**
     * @test
     */
    public function itIsSerializable()
    {
        $timeZone = $this->createTimeZone();
        $this->assertInstanceOf(\Serializable::class, $timeZone);

        $serialized = \serialize($timeZone);
        $this->assertTrue(
            $this->createTimeZone()
                ->equals(
                    \unserialize($serialized)
                )
        );
    }

    private function createTimeZone(string $rawId = self::ID): TimeZone
    {
        return TimeZone::ofId($this->createTimeZoneId($rawId));
    }

    private function createTimeZoneId(string $rawId = self::ID): TimeZoneId
    {
        return new TimeZoneId($rawId);
    }
}
