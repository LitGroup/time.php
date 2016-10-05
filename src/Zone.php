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

/**
 * Time zone with zone-related offset from UTC.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class Zone implements Equatable
{
    /**
     * @var string
     */
    private $abbreviation;

    /**
     * @var int
     */
    private $offsetInSeconds;

    /**
     * @var bool
     */
    private $dst;

    public function __construct(string $abbreviation, int $offsetInSeconds, bool $dst)
    {
        if (strlen(trim($abbreviation)) === 0) {
            throw new \InvalidArgumentException('Abbreviation of time zone cannot be empty.');
        }
        $this->abbreviation = $abbreviation;
        $this->offsetInSeconds = $offsetInSeconds;
        $this->dst = $dst;
    }

    /**
     * Return zone offset ID (ISO-8601).
     *
     * Example: +00:00 or -01:00 or +03:00
     */
    public function getOffsetId(): string
    {
        $offset = abs($this->getOffsetInSeconds());
        $hour = (int) ($offset / 3600);
        $minute = (int) (($offset % 3600) / 60);

        return sprintf("%s%'02d:%'02d", $this->getOffsetInSeconds() < 0 ? '-' : '+', $hour, $minute);
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function getOffsetInSeconds(): int
    {
        return $this->offsetInSeconds;
    }

    public function isDst(): bool
    {
        return $this->dst;
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Zone &&
            $another->getOffsetInSeconds() === $this->getOffsetInSeconds() &&
            $another->getAbbreviation() === $this->getAbbreviation() &&
            $another->isDst() === $this->isDst();
    }
}