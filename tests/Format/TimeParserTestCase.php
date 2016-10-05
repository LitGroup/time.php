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

namespace Test\LitGroup\Time\Format;

use LitGroup\Time\Time;
use LitGroup\Time\Format\TimeParser;

abstract class TimeParserTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TimeParser
     */
    private $parser;

    abstract public function createParser(): TimeParser;

    abstract public function getParsingExamples(): array;

    abstract public function getParsingFailureExamples(): array;

    /**
     * @test
     */
    final public function itIsASubtypeOfTimeParser()
    {
        $this->assertInstanceOf(TimeParser::class, $this->getParser());
    }

    /**
     * @test
     * @dataProvider getParsingExamples
     */
    final public function itParsesTimeFromAStringRepresentation(string $string, Time $expectedTime)
    {
        $this->assertTrue(
            $expectedTime->equals(
                $this->getParser()->parseTime($string)
            )
        );
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\FormatException
     * @dataProvider getParsingFailureExamples
     */
    final public function itThrowsAnExceptionWhenStringDoesNotContainValidTimeDuringParsing(string $string)
    {
        $this->getParser()->parseTime($string);
    }

    final protected function getParser(): TimeParser
    {
        return $this->parser;
    }

    final protected function setUp()
    {
        $this->parser = $this->createParser();
    }
}