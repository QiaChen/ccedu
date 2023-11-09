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
class AppCode extends AbstractConstants
{
    /**
     * @Message("管理后台")
     */
    public const ADMIN = 0;

    /**
     * @Message("前台API")
     */
    public const FRONT = 1;

    public static function ALL()
    {
        return [
            self::ADMIN => self::getMessage(self::ADMIN),
            self::FRONT => self::getMessage(self::FRONT),
        ];
    }

    public static function ROUTES()
    {
        return [
            self::ADMIN => 'admin',
            self::FRONT => 'front',
        ];
    }
}
