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

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    public const SERVER_ERROR = 500;

    /**
     * @Message("unauthorized！")
     */
    public const UNAUTHORIZED = 401;

    /**
     * @Message("Permission denied！")
     */
    public const PERMISSION_DENIED = 403;

    /**
     * @Message("NOT FOUND")
     */
    public const NOT_FOUND = 404;

    /**
     * @Message("Password error")
     */
    public const PASSWORD_ERROR = 700;
}
