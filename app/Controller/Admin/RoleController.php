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

use App\Dao\RoleDao;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class RoleController extends AdminController
{
    #[Inject]
    protected RoleDao $roleDao;

    public function list()
    {
        return $this->success('success', [
            'list' => $this->roleDao->list($this->getAppCode()),
            'page' => 1,
            'pageSize' => 10000,
            'pageCount' => 1,
        ]);
    }

    public function create()
    {
        $data = $this->getRequestData([
            'name' => 'required',
            'description' => 'required',
        ]);
        $this->roleDao->create($data['name'], $data['description'], $this->getAppCode());
        return $this->success();
    }

    public function updateNodes()
    {
        $data = $this->getRequestData([
            'rid' => 'required',
            'nodes' => 'required',
        ]);
        $this->roleDao->updateNodes($data['rid'], $data['nodes'], $this->getAppCode());
        return $this->success();
    }

    public function update()
    {
        $data = $this->getRequestData([
            'rid' => 'required|integer',
            'name' => 'required',
            'description' => 'required',
        ]);
        $this->roleDao->update($data['rid'], $data['name'], $data['description'], $this->getAppCode());
        return $this->success();
    }

    public function delete()
    {
        $data = $this->getRequestData([
            'rid' => 'required|integer',
        ]);
        $this->roleDao->delete($data['rid'], $this->getAppCode());
        return $this->success();
    }
}
