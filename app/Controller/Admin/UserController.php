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
use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class UserController extends AdminController
{
    #[Inject]
    protected UserDao $userDao;

    #[Inject]
    protected AuthService $authService;

    public function getUserInfo()
    {
        $userInfo = $this->userDao->getUserById($this->getUserId())->toArray();
        $userInfo['avatar'] = 'https://gw.alipayobjects.com/zos/antfincdn/aPkFc8Sj7n/method-draw-image.svg';
        return $this->success('ok', $userInfo);
    }

    public function getUserMenus()
    {
        $userInfo = $this->userDao->getUserById($this->getUserId());
        $list = $this->authService->getNodesByRid($userInfo->rid, $this->getAppCode());
        $data = [];
        foreach ($list as $key => $node) {
            if ($node->is_menu != 1) {
                continue;
            }
            $tmp = [
                'nid' => $node->nid,
                'parentid' => $node->parentid,
                'path' => $node->route,
                'name' => '',
                'component' => $node->component,
                'meta' => [
                    'title' => $node->title,
                ],
            ];

            if (! empty($node->icon)) {
                $tmp['meta']['icon'] = $node->icon;
            }
            $data[] = $tmp;
        }
        $treeData = ListToTreeRecursive($data, 0, 'nid', 'parentid', 'children');

        return $this->success('ok', $this->_setMenuName($treeData));
    }

    private function _setMenuName($treeData, $parent_name = '')
    {   
        foreach ($treeData as $key => $node) {
            $treeData[$key]['name'] = $parent_name . str_replace('/', '', $node['path']);
            if (isset($node['children']) && ! empty($node['children'])) {
                $treeData[$key]['children'] = $this->_setMenuName($node['children'], $treeData[$key]['name'] .'_');
            }
        }
        return $treeData;
    }
}
