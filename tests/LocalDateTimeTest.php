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
        $this->dateTime = LocalDateTime::of($this->date, $this->time);
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
            [true, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND + 1))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND - 1))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE + 1, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE - 1, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR + 1, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR - 1, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY + 1),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY - 1),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH + 1), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH - 1), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR + 1), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, LocalDateTime::of(
                new Date(Year::of(self::YEAR - 1), Month::getValueOf(self::MONTH), self::DAY),
                Time::of(self::HOUR, self::MINUTE, self::SECOND))],
            [false, $this->createMock(Equatable::class)],
            [false, $this->createMock(Equatable::class)],
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
