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

/**
 * This is the common interface for datetime-objects in the ISO-8601 calendar system.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
interface DateTime extends Date, Time, Equatable
{

}