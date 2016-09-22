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

namespace LitGroup\Time\Exception;

use RuntimeException;

/**
 * This exception is used to indicate problems with creating, querying and
 * manipulating date-time objects.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class DateTimeException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}