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

use LitGroup\Time\DateTime;
use LitGroup\Time\Format\DateTimeParser;
use LitGroup\Time\LocalDateTime;
use LitGroup\Time\Location;
use LitGroup\Time\ZonedDateTime;

abstract class DateTimeParserTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateTimeParser
     */
    private $parser;

    abstract public function createParser(): DateTimeParser;

    abstract public function getLocalParsingExamples(): array;

    abstract public function getZonedParsingExamples(): array;

    abstract public function getParsingFailureExamples(): array;

    /**
     * @test
     */
    final public function itIsASubtypeOfDateTimeParser()
    {
        $this->assertInstanceOf(DateTimeParser::class, $this->getParser());
    }

    /**
     * @test
     * @dataProvider getLocalParsingExamples
     */
    final public function itParsesLocalDateAndTimeFromString(string $string, LocalDateTime $dateTime)
    {
        $this->assertTrue(
            $dateTime->equals(
                $this->getParser()->parseLocal($string)
            )
        );
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\FormatException
     * @dataProvider getParsingFailureExamples
     */
    final public function itThrowsAnExceptionWhenStringHasInvalidFormatDuringParsingOfLocalDateAndTime($string)
    {
        $this->getParser()->parseLocal($string);
    }

    /**
     * @test
     * @dataProvider getZonedParsingExamples
     */
    final public function itParsesZonedDateAndTimeFromString(Location $location, string $string, ZonedDateTime $dateTime)
    {
        $parsed = $this->getParser()->parseZoned($location, $string);

        $this->assertTrue($dateTime->equals($parsed));
        $this->assertTrue($location->equals($parsed->getLocation()));
    }

    /**
     * @test
     * @expectedException \LitGroup\Time\Exception\FormatException
     * @dataProvider getParsingFailureExamples
     */
    final public function itThrowsAnExceptionWhenStringHasInvalidFormatDuringParsingOfZonedDateAndTime(string $string)
    {
        $this->getParser()->parseZoned(Location::utc(), $string);
    }

    final protected function getParser(): DateTimeParser
    {
        return $this->parser;
    }

    final protected function setUp()
    {
        $this->parser = $this->createParser();
    }
}