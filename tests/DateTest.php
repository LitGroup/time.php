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
     * @test
     */
    public function itHasAYear()
    {
        $date = $this->createDate();
        $this->assertTrue($this->createYear()->equals($date->getYear()));
    }

    /**
     * @test
     */
    public function itHasAMonth()
    {
        $date = $this->createDate();
        $this->assertTrue($this->createMonth()->equals($date->getMonth()));
    }

    /**
     * @test
     */
    public function itHasADayOfMonth()
    {
        $this->assertSame(self::DAY_OF_MONTH, $this->createDate()->getDayOfMonth());
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\DateTimeException
     * @dataProvider getInvalidDateExamples
     */
    public function itThrowsAnExceptionWhenDayOfMonthIsInvalidDuringInstantiation(Year $year, Month $month, int $day)
    {
        $this->createDate($year, $month, $day);
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
        $this->assertInstanceOf(Equatable::class, $this->createDate());
        $this->assertSame($equal, $this->createDate()->equals($another));
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
                $this->createDate()
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

    /**
     * @test
     * @dataProvider getComparisonExamples
     */
    public function itIsComparable(int $result, Date $another)
    {
        $date = $this->createDate();
        $this->assertSame($result, $date->compare($another));
        $this->assertSame($result > 0, $date->greaterThan($another));
        $this->assertSame($result >= 0, $date->greaterThanOrEqual($another));
        $this->assertSame($result < 0, $date->lessThan($another));
        $this->assertSame($result <= 0, $date->lessThanOrEqual($another));
    }

    public function getComparisonExamples(): array
    {
        return [
            [ 0, Date::of(self::YEAR, self::MONTH, self::DAY_OF_MONTH)],
            [ 1, Date::of(self::YEAR - 1, self::MONTH, self::DAY_OF_MONTH)],
            [ 1, Date::of(self::YEAR, self::MONTH - 1, self::DAY_OF_MONTH)],
            [ 1, Date::of(self::YEAR, self::MONTH, self::DAY_OF_MONTH - 1)],
            [-1, Date::of(self::YEAR + 1, self::MONTH, self::DAY_OF_MONTH)],
            [-1, Date::of(self::YEAR, self::MONTH + 1, self::DAY_OF_MONTH)],
            [-1, Date::of(self::YEAR, self::MONTH, self::DAY_OF_MONTH + 1)],
        ];
    }

    /**
     * @test
     */
    public function itIsSerializable()
    {
        $date = $this->createDate();
        $this->assertInstanceOf(\Serializable::class, $date);

        $serialized = serialize($date);
        $this->assertTrue(
            $this->createDate()
                ->equals(unserialize($serialized))
        );
    }

    private function createDate(Year $year = null, Month $month = null, int $dayOfMonth = self::DAY_OF_MONTH): Date
    {
        return new Date(
            $year ?? $this->createYear(),
            $month ?? $this->createMonth(),
            $dayOfMonth
        );
    }

    private function createYear(int $rawValue = self::YEAR): Year
    {
        return Year::of($rawValue);
    }

    private function createMonth(int $rawValue = self::MONTH): Month
    {
        return Month::getValueOf($rawValue);
    }
}
