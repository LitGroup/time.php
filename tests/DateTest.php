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
use LitGroup\Time\Month;
use LitGroup\Time\Year;

class DateTest extends \PHPUnit_Framework_TestCase
{
    const YEAR = 2016;
    const MONTH = 8;
    const DAY_OF_MONTH = 10;

    const DEFAULT_MONTH = 1;
    const DEFAULT_DAY_OF_MONTH = 1;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var Year
     */
    private $year;

    /**
     * @var Month
     */
    private $month;

    protected function setUp()
    {
        $this->year = Year::of(self::YEAR);
        $this->month = Month::getValueOf(8);
        $this->date = new Date($this->year, $this->month, self::DAY_OF_MONTH);
    }

    /**
     * @test
     */
    public function itHasAYear()
    {
        $this->assertSame($this->getYear(), $this->getDate()->getYear());
    }

    /**
     * @test
     */
    public function itHasAMonth()
    {
        $this->assertSame($this->getMonth(), $this->getDate()->getMonth());
    }

    /**
     * @test
     */
    public function itHasADayOfMonth()
    {
        $this->assertSame(self::DAY_OF_MONTH, $this->getDate()->getDayOfMonth());
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\DateTimeException
     * @dataProvider getInvalidDateExamples
     */
    public function itThrowsAnExceptionWhenDayOfMonthIsInvalidDuringInstantiation(Year $year, Month $month, int $day)
    {
        new Date($year, $month, $day);
    }

    public function getInvalidDateExamples(): array
    {
        return [
            [Year::of(2016), Month::december(), -1],
            [Year::of(2016), Month::december(), 0],
            [Year::of(2016), Month::december(), 32],
            [Year::of(2015), Month::february(), 29],
        ];
    }

    /**
     * @test
     * @dataProvider getEqualityExamples
     */
    public function itIsEqualToAnotherOne(bool $equal, Equatable $another)
    {
        $this->assertInstanceOf(Equatable::class, $this->getDate());
        $this->assertSame($equal, $this->getDate()->equals($another));
    }

    public function getEqualityExamples(): array
    {
        return [
            [true, new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY_OF_MONTH)],
            [false, new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY_OF_MONTH - 1)],
            [false, new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH), self::DAY_OF_MONTH + 1)],
            [false, new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH - 1), self::DAY_OF_MONTH)],
            [false, new Date(Year::of(self::YEAR), Month::getValueOf(self::MONTH + 1), self::DAY_OF_MONTH)],
            [false, new Date(Year::of(self::YEAR - 1), Month::getValueOf(self::MONTH), self::DAY_OF_MONTH)],
            [false, new Date(Year::of(self::YEAR + 1), Month::getValueOf(self::MONTH), self::DAY_OF_MONTH)],
            [false, $this->createMock(Equatable::class)],
        ];
    }

    /**
     * @test
     */
    public function itHasAFactoryMethodForInitializationByScalarValues()
    {
        $this->assertTrue(
            Date::of(self::YEAR, self::MONTH, self::DAY_OF_MONTH)->equals(
                $this->getDate()
            )
        );
        $this->assertTrue(
            Date::of(self::YEAR)->equals(
                Date::of(self::YEAR, self::DEFAULT_MONTH, self::DEFAULT_DAY_OF_MONTH)
            )
        );
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\DateTimeException
     * @dataProvider getInvalidScalarValuesExamples
     */
    public function itThrowsAnExceptionWhenDateIsInvalidDuringInstantiationByScalarValues(int $year, int $month, int $day)
    {
        Date::of($year, $month, $day);
    }

    public function getInvalidScalarValuesExamples(): array
    {
        return [
            [Year::MIN_VALUE - 1, 1, 1],
            [Year::MAX_VALUE + 1, 1, 1],
            [Year::MIN_VALUE, 0, 1],
            [Year::MIN_VALUE, 13, 1],
            [2016, 12, 32],
        ];
    }

    private function getDate(): Date
    {
        return $this->date;
    }

    private function getYear(): Year
    {
        return $this->year;
    }

    private function getMonth(): Month
    {
        return $this->month;
    }
}
