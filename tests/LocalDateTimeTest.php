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
     * @var LocalDateTime
     */
    private $dateTime;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;

    protected function setUp()
    {
        $this->date = new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY);
        $this->time = Time::of(self::HOUR, self::MINUTE, self::SECOND);
        $this->dateTime = new LocalDateTime($this->date, $this->time);
    }

    /**
     * @test
     * @testdox It is a subtype of DateTime
     */
    public function itIsASubtypeOfDateTime()
    {
        $this->assertInstanceOf(DateTime::class, $this->getDateTime());
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodForInitializationByScalarValues()
    {
        $this->assertTrue(
            LocalDateTime::of(self::YEAR, self::MONTH, self::DAY, self::HOUR, self::MINUTE, self::SECOND)->equals(
                $this->getDateTime()
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
        $dateTime = $this->getDateTime();
        $this->assertTrue($dateTime->getDate()->equals($this->getDate()));
    }

    /**
     * @test
     */
    public function itHasATime()
    {
        $dateTime = $this->getDateTime();
        $this->assertTrue($dateTime->getTime()->equals($this->getTime()));
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $this->assertInstanceOf(Equatable::class, $this->getDateTime());
        $this->assertSame($equal, $this->getDateTime()->equals($another));
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
        $dateTime = $this->getDateTime();
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

    private function getDateTime(): LocalDateTime
    {
        return $this->dateTime;
    }

    private function getDate()
    {
        return $this->date;
    }

    private function getTime(): Time
    {
        return $this->time;
    }
}
