<?php
/**
 * This file is part of the "litgroup/datetime" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * This file is part of the "litgroup/datetime" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types = 1);

namespace Test\LitGroup\Time\Format;

use LitGroup\Time\Format\TimeFormatter;
use LitGroup\Time\Time;

abstract class TimeFormatterTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TimeFormatter
     */
    private $formatter;

    abstract public function createFormatter(): TimeFormatter;

    abstract public function getFormattingExamples(): array;

    /**
     * @test
     * @testdox It is a subtype of TimeFormatter
     */
    final public function itIsASubtypeOfTimeFormatter()
    {
        $this->assertInstanceOf(TimeFormatter::class, $this->getFormatter());
    }

    /**
     * @test
     * @dataProvider getFormattingExamples
     */
    final public function itCreatesStringRepresentationOfTime(Time $date, string $expectedString)
    {
        $this->assertSame($expectedString, $this->getFormatter()->formatTime($date));
    }

    final protected function getFormatter(): TimeFormatter
    {
        return $this->formatter;
    }

    final protected function setUp()
    {
        $this->formatter = $this->createFormatter();
    }
}