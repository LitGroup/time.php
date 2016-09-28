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

namespace LitGroup\Time;

use LitGroup\Equatable\Equatable;
use DateTimeZone as NativeTimeZone;

final class Location implements Equatable
{
    /**
     * @var LocationId
     */
    private $id;

    public static function of(LocationId $id): Location
    {
        return new self($id);
    }

    public function getId(): LocationId
    {
        return $this->id;
    }

    public function getZone(ZonedDateTime $at): Zone
    {
        $atTimestamp = $at->getSecondsSinceEpoch();
        $data = $this->getNativeTimeZone()->getTransitions($atTimestamp, $atTimestamp)[0];

        return new Zone($data['abbr'], $data['offset'], $data['isdst']);
    }

    public function equals(Equatable $another): bool
    {
        return
            $another instanceof Location &&
            $another->getId()->equals($this->getId());
    }

    public function __toString(): string
    {
        return $this->getId()->getRawValue();
    }

    private function __construct(LocationId $id)
    {
        $this->id = $id;
    }

    private function getNativeTimeZone(): NativeTimeZone
    {
        return new NativeTimeZone($this->getId()->getRawValue());
    }
}