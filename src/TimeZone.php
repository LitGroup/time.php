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
use DateTimeZone as NativeTimeZone;
use Serializable;

/**
 * Time zone (ISO-8601).
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
final class TimeZone implements Equatable, Serializable
{
    /**
     * @var TimeZone
     */
    private static $utc;

    /**
     * @var TimeZoneId
     */
    private $id;

    public static function of(string $rawId): TimeZone
    {
        return self::ofId(new TimeZoneId($rawId));
    }

    public static function ofId(TimeZoneId $id): TimeZone
    {
        return new self($id);
    }

    public static function utc(): TimeZone
    {
        if (self::$utc === null) {
            self::$utc = self::of('UTC');
        }

        return self::$utc;
    }

    public function getId(): TimeZoneId
    {
        return $this->id;
    }

    public function getOffsetAt(int $secondSinceEpoch): Offset
    {
        $data = $this->getNativeTimeZone()->getTransitions($secondSinceEpoch, $secondSinceEpoch)[0];

        return new Offset($data['abbr'], $data['offset'], $data['isdst']);
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof TimeZone &&
            $another->getId()->equals($this->getId());
    }

    public function __toString(): string
    {
        return $this->getId()->getRawValue();
    }

    public function serialize()
    {
        return \serialize($this->getId());
    }

    public function unserialize($serialized)
    {
        $this->init(\unserialize($serialized));
    }

    private function __construct(TimeZoneId $id)
    {
        $this->init($id);
    }

    private function getNativeTimeZone(): NativeTimeZone
    {
        return new NativeTimeZone($this->getId()->getRawValue());
    }

    private function init(TimeZoneId $id)
    {
        assert($this->id === null);

        $this->id = $id;
    }
}