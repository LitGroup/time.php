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
use LitGroup\Time\Date;
use LitGroup\Time\TimeZone;
use LitGroup\Time\TimeZoneId;
use LitGroup\Time\Month;
use LitGroup\Time\Time;
use LitGroup\Time\Year;
use LitGroup\Time\Offset;
use LitGroup\Time\ZonedDateTime;

class TimeZoneTest extends \PHPUnit_Framework_TestCase
{
    const ID = 'Europe/Moscow';
    const ANOTHER_ID = 'UTC';

    const OFFSET_SECONDS = 10800;
    const OFFSET_ABBR = 'MSK';
    const OFFSET_DST = false;

    const TIMESTAMP = 1470269107;

    /**
     * @var TimeZone
     */
    private $timeZone;

    /**
     * @var TimeZoneId
     */
    private $timeZoneId;

    protected function setUp()
    {
        $this->timeZoneId = new TimeZoneId(self::ID);
        $this->timeZone = TimeZone::ofId($this->timeZoneId);
    }

    /**
     * @test
     */
    public function itHasAnId()
    {
        $this->assertSame($this->getTimeZoneId(), $this->getTimeZone()->getId());
    }

    /**
     * @test
     */
    public function itCanBeConvertedToString()
    {
        $this->assertSame(self::ID, (string) $this->getTimeZone());
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $timeZone = $this->getTimeZone();
        $this->assertInstanceOf(Equatable::class, $timeZone);
        $this->assertSame($equal, $timeZone->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, TimeZone::ofId(new TimeZoneId(self::ID))],
            [false, TimeZone::ofId(new TimeZoneId(self::ANOTHER_ID))],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    /**
     * @test
     */
    public function itProvidesAnOffset()
    {
        $timeZone = $this->getTimeZone();
        $expectedZone = new Offset(self::OFFSET_ABBR, self::OFFSET_SECONDS, self::OFFSET_DST);

        $this->assertTrue($expectedZone->equals($timeZone->getOffsetAt(self::TIMESTAMP)));
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodWithInitializationByRawId()
    {
        $this->assertTrue(
            $this->getTimeZone()->equals(TimeZone::of(self::ID))
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

    private function getTimeZone(): TimeZone
    {
        return $this->timeZone;
    }

    private function getTimeZoneId(): TimeZoneId
    {
        return $this->timeZoneId;
    }
}
