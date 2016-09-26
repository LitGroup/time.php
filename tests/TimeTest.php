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
use LitGroup\Time\Exception\DateTimeException;
use LitGroup\Time\Time;

class TimeTest extends \PHPUnit_Framework_TestCase
{
    const HOUR = 5;
    const MINUTE = 6;
    const SECOND = 7;

    const MIN_HOUR = 0;
    const MAX_HOUR = 23;
    const MIN_MINUTE = 0;
    const MAX_MINUTE = 59;
    const MIN_SECOND = 0;
    const MAX_SECOND = 59;

    /**
     * @test
     */
    public function itIsInitializable()
    {
        $this->assertInstanceOf(Time::class, $this->createTime());
    }

    /**
     * @test
     */
    public function itHasAnHour()
    {
        foreach (range(self::MIN_HOUR, self::MAX_HOUR) as $hour) {
            $time = $this->createTime($hour);
            $this->assertSame($hour, $time->getHour());
        }
    }

    /**
     * @test
     * @dataProvider getInvalidHourExamples
     */
    public function itThrowsAnExceptionWhenHourHasAnInvalidValueDuringInstantiation(int $hour)
    {
        $this->expectException(DateTimeException::class);
        $this->expectExceptionMessage("Hour has an invalid value: $hour");

        $this->createTime($hour);
    }

    public function getInvalidHourExamples(): array
    {
        return [
            [self::MIN_HOUR - 1],
            [self::MAX_HOUR + 1],
        ];
    }

    /**
     * @test
     */
    public function itHasAMinute()
    {
        foreach (range(self::MIN_MINUTE, self::MAX_MINUTE) as $minute) {
            $time = $this->createTime(self::HOUR, $minute);
            $this->assertSame($minute, $time->getMinute());
        }
    }

    /**
     * @test
     * @dataProvider getInvalidMinuteExamples
     */
    public function itThrowsAnExceptionWhenMinuteHasAnInvalidValueDuringInstantiation(int $minute)
    {
        $this->expectException(DateTimeException::class);
        $this->expectExceptionMessage("Minute has an invalid value: $minute");

        $this->createTime(self::HOUR, $minute);
    }

    public function getInvalidMinuteExamples(): array
    {
        return [
            [self::MIN_MINUTE - 1],
            [self::MAX_MINUTE + 1],
        ];
    }

    /**
     * @test
     */
    public function itHasASecond()
    {
        foreach (range(self::MIN_SECOND, self::MAX_SECOND) as $second) {
            $time = $this->createTime(self::HOUR, self::MINUTE, $second);
            $this->assertSame($second, $time->getSecond());
        }
    }

    /**
     * @test
     * @dataProvider getInvalidSecondExamples
     */
    public function itThrowsAnExceptionWhenSecondHasAnInvalidValueDuringInstantiation(int $second)
    {
        $this->expectException(DateTimeException::class);
        $this->expectExceptionMessage("Second has an invalid value: $second");

        $this->createTime(self::HOUR, self::MINUTE, $second);
    }

    public function getInvalidSecondExamples(): array
    {
        return [
            [self::MIN_SECOND - 1],
            [self::MAX_SECOND + 1],
        ];
    }

    /**
     * @test
     */
    public function itCanBeEqualToAnotherOne()    {
        $time = $this->createTime();
        $this->assertInstanceOf(Equatable::class, $time);

        $this->assertTrue($time->equals($this->createTime()));
        $this->assertFalse($time->equals($this->createTime(self::HOUR + 1)));
        $this->assertFalse($time->equals($this->createTime(self::HOUR, self::MINUTE + 1)));
        $this->assertFalse($time->equals($this->createTime(self::HOUR, self::MINUTE, self::SECOND + 1)));

        $this->assertFalse($time->equals($this->createMock(Equatable::class)));
    }

    private function createTime(int $hour = self::HOUR, int $minute = self::MINUTE, int $second = self::SECOND): Time
    {
        return Time::of($hour, $minute, $second);
    }
}
