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

namespace Test\LitGroup\Time\Format;

use LitGroup\Time\Format\DateTimeFormatter;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\ZonedDateTime;

abstract class DateTimeFormatterTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateTimeFormatter
     */
    private $formatter;

    abstract public function createFormatter(): DateTimeFormatter;

    abstract public function getLocalFormattingExamples(): array;

    abstract public function getZonedFormattingExamples(): array;

    /**
     * @test
     * @testdox It is a subtype of DateTimeFormatter
     */
    final public function itIsASubtypeOfDateTimeFormatter()
    {
        $this->assertInstanceOf(DateTimeFormatter::class, $this->getFormatter());
    }

    /**
     * @test
     * @dataProvider getLocalFormattingExamples
     */
    final public function itCreatesStringRepresentationOfLocalDateTime(LocalDateTime $dateTime, string $expectedString)
    {
        $this->assertSame($expectedString, $this->getFormatter()->formatLocal($dateTime));
    }

    /**
     * @test
     * @dataProvider getZonedFormattingExamples
     */
    final public function itCreatesStringRepresentationOfZonedDateTime(ZonedDateTime $dateTime, string $expectedString)
    {
        $this->assertSame($expectedString, $this->getFormatter()->formatZoned($dateTime));
    }

    final protected function getFormatter(): DateTimeFormatter
    {
        return $this->formatter;
    }

    final protected function setUp()
    {
        $this->formatter = $this->createFormatter();
    }
}