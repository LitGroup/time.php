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

use LitGroup\Time\Date;
use LitGroup\Time\Format\DateFormatter;

abstract class DateFormatterTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateFormatter
     */
    private $formatter;

    abstract public function createFormatter(): DateFormatter;

    abstract public function getFormattingExamples(): array;

    /**
     * @test
     * @testdox It is a subtype of DateFormatter
     */
    final public function itIsASubtypeOfDateFormatter()
    {
        $this->assertInstanceOf(DateFormatter::class, $this->getFormatter());
    }

    /**
     * @test
     * @dataProvider getFormattingExamples
     */
    final public function itCreatesStringRepresentationOfDate(Date $date, string $expectedString)
    {
        $this->assertSame($expectedString, $this->getFormatter()->formatDate($date));
    }

    final protected function getFormatter(): DateFormatter
    {
        return $this->formatter;
    }

    final protected function setUp()
    {
        $this->formatter = $this->createFormatter();
    }
}