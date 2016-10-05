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

use LitGroup\Time\Date;
use LitGroup\Time\Format\DateParser;

abstract class DateParserTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateParser
     */
    private $parser;

    abstract public function createParser(): DateParser;

    abstract public function getParsingExamples(): array;

    abstract public function getParsingFailureExamples(): array;

    /**
     * @test
     * @testdox It is a subtype of DateParser
     */
    final public function itIsASubtypeOfDateParser()
    {
        $this->assertInstanceOf(DateParser::class, $this->getParser());
    }

    /**
     * @test
     * @dataProvider getParsingExamples
     */
    final public function itParsesDateFromAStringRepresentation(string $string, Date $expectedDate)
    {
        $this->assertTrue(
            $expectedDate->equals(
                $this->getParser()->parseDate($string)
            )
        );
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\FormatException
     * @dataProvider getParsingFailureExamples
     */
    final public function itThrowsAnExceptionWhenStringDoesNotContainValidDateDuringParsing(string $string)
    {
        $this->getParser()->parseDate($string);
    }

    final protected function getParser(): DateParser
    {
        return $this->parser;
    }

    final protected function setUp()
    {
        $this->parser = $this->createParser();
    }
}