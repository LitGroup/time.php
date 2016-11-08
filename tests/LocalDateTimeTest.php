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
use LitGroup\Time\DateTime;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\Month;
use LitGroup\Time\Time;
use LitGroup\Time\Year;

class LocalDateTimeTest extends \PHPUnit_Framework_TestCase
{
    const YEAR = 2016;
    const MONTH = 8;
    const DAY = 10;

    const HOUR = 3;
    const MINUTE = 5;
    const SECOND = 7;

    const DEFAULT_MONTH = 1;
    const DEFAULT_DAY = 1;
    const DEFAULT_HOUR = 0;
    const DEFAULT_MINUTE = 0;
    const DEFAULT_SECOND = 0;

    /**
     * @test
     * @testdox It is a subtype of DateTime
     */
    public function itIsASubtypeOfDateTime()
    {
        $this->assertInstanceOf(DateTime::class, $this->createDateTime());
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodForInitializationByScalarValues()
    {
        $this->assertTrue(
            LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)->equals(
                $this->createDateTime()
            )
        );

        $this->assertTrue(
            LocalDateTime::of(self::YEAR)->equals(
                LocalDateTime::of(
                    self::YEAR, self::DEFAULT_MONTH, self::DEFAULT_DAY,
                    self::DEFAULT_HOUR, self::DEFAULT_MINUTE, self::DEFAULT_SECOND
                )
            )
        );
    }

    /**
     * @test
     */
    public function itHasADate()
    {
        $dateTime = $this->createDateTime();
        $this->assertTrue($dateTime->getDate()->equals($this->createDate()));
    }

    /**
     * @test
     */
    public function itHasATime()
    {
        $dateTime = $this->createDateTime();
        $this->assertTrue($dateTime->getTime()->equals($this->createTime()));
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $this->assertInstanceOf(Equatable::class, $this->createDateTime());
        $this->assertSame($equal, $this->createDateTime()->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND + 1))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND - 1))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE + 1, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE - 1, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR + 1, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR - 1, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY + 1),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY - 1),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH + 1), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH - 1), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR + 1), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, new LocalDateTime(
                new Date(Year::of(self::YEAR - 1), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, $this->createMock(Equatable::class)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    /**
     * @test
     * @dataProvider getComparisonExamples
     */
    public function itIsComparable(int $result, LocalDateTime $another)
    {
        $dateTime = $this->createDateTime();
        $this->assertSame($result, $dateTime->compare($another));
        $this->assertSame($result > 0, $dateTime->greaterThan($another));
        $this->assertSame($result >= 0, $dateTime->greaterThanOrEqual($another));
        $this->assertSame($result < 0, $dateTime->lessThan($another));
        $this->assertSame($result <= 0, $dateTime->lessThanOrEqual($another));
    }

    public function getComparisonExamples(): array
    {
        return [
            [ 0, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, LocalDateTime::of(self::YEAR - 1, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, LocalDateTime::of(self::YEAR, self::MONTH - 1, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY - 1, self::HOUR, self::MINUTE, self::SECOND)],
            [ 1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR - 1, self::MINUTE, self::SECOND)],
            [ 1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE - 1, self::SECOND)],
            [ 1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND - 1)],
            [-1, LocalDateTime::of(self::YEAR + 1, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [-1, LocalDateTime::of(self::YEAR, self::MONTH + 1, self::DAY, self::HOUR, self::MINUTE, self::SECOND)],
            [-1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY + 1, self::HOUR, self::MINUTE, self::SECOND)],
            [-1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR + 1, self::MINUTE, self::SECOND)],
            [-1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE + 1, self::SECOND)],
            [-1, LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND + 1)],
        ];
    }

    /**
     * @test
     */
    public function itIsSerializable()
    {
        $dateTime = $this->createDateTime();
        $this->assertInstanceOf(\Serializable::class, $dateTime);

        $serialized = \serialize($dateTime);
        $this->assertTrue(
            $this->createDateTime()
                ->equals(\unserialize($serialized))
        );
    }

    private function createDateTime(Date $date = null, Time $time = null): LocalDateTime
    {
        return new LocalDateTime($date ?? $this->createDate(), $time ?? $this->createTime());
    }

    private function createDate(int $year = self::YEAR, int $mont = self::MONTH, int $day = self::DAY): Date
    {
        return Date::of($year, $mont, $day);
    }

    private function createTime(int $hour = self::HOUR, int $minute = self::MINUTE, int $second = self::SECOND): Time
    {
        return Time::of($hour, $minute, $second);
    }
}
