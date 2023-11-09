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

namespace App\Controller\Admin;

use App\Dao\UserDao;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class UserController extends AdminController
{
    #[Inject]
    protected UserDao $userDao;

    public function getUserInfo()
    {
        $userInfo = $this->userDao->getUserById($this->getUserId())->toArray();
        $userInfo['avatar'] = 'https://gw.alipayobjects.com/zos/antfincdn/aPkFc8Sj7n/method-draw-image.svg';
        return $this->success('ok', $userInfo);
    }

    public function getUserMenus()
    {
        $data = [
            [
                'path' => '/dashboard',
                'name' => 'Dashboard',
                'component' => 'LAYOUT',
                'redirect' => '/dashboard/console',
                'meta' => [
                    'icon' => 'DashboardOutlined',
                    'title' => 'Dashboard',
                ],
                'children' => [
                    [
                        'path' => 'console',
                        'name' => 'dashboard_console',
                        'component' => '/dashboard/console/console',
                        'meta' => [
                            'title' => '主控台',
                        ],
                    ],
                    [
                        'path' => 'monitor',
                        'name' => 'dashboard_monitor',
                        'component' => '/dashboard/monitor/monitor',
                        'meta' => [
                            'title' => '监控页',
                        ],
                    ],
                    [
                        'path' => 'workplace',
                        'name' => 'dashboard_workplace',
                        'component' => '/dashboard/workplace/workplace',
                        'meta' => [
                            'title' => '工作台',
                        ],
                    ],
                ],
            ],
            [
                'path' => '/system',
                'name' => '系统管理',
                'component' => 'LAYOUT',
                'redirect' => '/system/set',
                'meta' => [
                    'icon' => 'ControlOutlined',
                    'title' => '系统管理',
                ],
                'children' => [
                    [
                        'path' => 'role',
                        'name' => 'system_role',
                        'component' => '/system/role/role',
                        'meta' => [
                            'title' => '角色管理',
                        ],
                    ], [
                        'path' => 'menu',
                        'name' => 'system_menu',
                        'component' => '/system/menu/menu',
                        'meta' => [
                            'title' => '菜单权限',
                        ],
                    ],
                ],
            ],
        ];
        return $this->success('ok', $data);
    }
}
