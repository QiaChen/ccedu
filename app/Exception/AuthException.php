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

class AuthException extends ServerException
{
    public const PASSWORD_ERROR = 700;

    public const UNAUTHORIZED = 401;

    public const PERMISSION_DENIED = 403;

    public const USER_NOT_FOUND = 404;

    public const ROLE_NOT_FOUND = 405;

    public function __construct(int $code = 0, $message = '')
    {
        if ($message == '') {
            $message = $this->getMsg($code);
        }
        parent::__construct($message, $code, null);
    }

    public function getMsg($code)
    {
        $msg = [
            self::PASSWORD_ERROR => __('auth.passowrd_error'),
            self::UNAUTHORIZED => __('auth.unauthorized'),
            self::PERMISSION_DENIED => __('auth.Permission_denied'),
            self::USER_NOT_FOUND => __('auth.user_not_found'),
            self::ROLE_NOT_FOUND => '没找到用户角色',
        ];
        return $msg[$code] ?? '';
    }
}
