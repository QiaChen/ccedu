<?php

declare(strict_types=1);
/**
 * This file is part of CcEdu.
 *
 * @link     https://ccedu.cqq.me
 * @document https://github.com/qiachen/ccedu
 * @contact  i@cqq.me
 * @license  https://github.com/qiachen/ccedu/blob/master/LICENSE
 */

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class ValidationException extends ServerException
{
    public function __construct($message)
    {
        parent::__construct($message, 701, null);
    }
}
