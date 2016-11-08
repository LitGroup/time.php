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

namespace LitGroup\Time;

use LitGroup\Equatable\Equatable;
use Serializable;

/**
 * Offset from UTC.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class Offset implements Equatable, Serializable
{
    /**
     * @var string
     */
    private $abbreviation;

    /**
     * @var int
     */
    private $totalSeconds;

    /**
     * @var bool
     */
    private $dst;

    public function __construct(string $abbreviation, int $totalSeconds, bool $dst)
    {
        $this->init($abbreviation, $totalSeconds, $dst);
    }

    /**
     * Return the normalized zone offset ID (ISO-8601).
     *
     * The ID is minor variation to the standard ISO-8601 formatted string for the offset. There are three formats:
     *   - Z - for UTC (ISO-8601)
     *   - +hh:mm or -hh:mm - if the seconds are zero (ISO-8601)
     *   - +hh:mm:ss or -hh:mm:ss - if the seconds are non-zero (not ISO-8601)
     */
    public function getId(): string
    {
        $absOffset = abs($this->getTotalSeconds());

        if ($absOffset === 0) {
            return 'Z';
        }

        $hour = (int) ($absOffset / 3600);
        $minute = (int) (($absOffset % 3600) / 60);
        $second = (int) (($absOffset % 3600) % 60);

        $result = ($second === 0)
            ? sprintf("%'02d:%'02d", $hour, $minute)
            : sprintf("%'02d:%'02d:%'02d", $hour, $minute, $second);

        return $this->getTotalSeconds() < 0 ? "-$result" : "+$result";
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function getTotalSeconds(): int
    {
        return $this->totalSeconds;
    }

    public function isDst(): bool
    {
        return $this->dst;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Offset &&
            $another->getTotalSeconds() === $this->getTotalSeconds() &&
            $another->getAbbreviation() === $this->getAbbreviation() &&
            $another->isDst() === $this->isDst();
    }

    public function serialize()
    {
        return \serialize([$this->getAbbreviation(), $this->getTotalSeconds(), $this->isDst()]);
    }

    public function unserialize($serialized)
    {
        list ($abbr, $totalSeconds, $dst) = \unserialize($serialized);
        $this->init($abbr, $totalSeconds, $dst);
    }

    private function init(string $abbreviation, int $totalSeconds, bool $dst)
    {
        assert($this->abbreviation === null);
        assert($this->totalSeconds === null);
        assert($this->dst === null);

        if (strlen(trim($abbreviation)) === 0) {
            throw new \InvalidArgumentException('Abbreviation of time zone cannot be empty.');
        }

        $this->abbreviation = $abbreviation;
        $this->totalSeconds = $totalSeconds;
        $this->dst = $dst;
    }
}