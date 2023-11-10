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

namespace App\Dao;

use App\Model\RoleModel;
use Hyperf\Di\Annotation\Inject;

class RoleDao extends Dao
{
    #[Inject]
    protected RoleModel $roleModel;

    public function list($appCode = 0)
    {
        $data = $this->roleModel->where2query([
            'appcode' => $appCode,
        ])->get()->toArray();
        return array_merge([[
            'rid' => 0,
            'name' => '超级管理员',
            'description' => '系统内置管理，具有全部权限，不允许修改',
            'appcode' => $appCode,
            'created_at' => '2023-11-11 12:00:00',
        ]], $data);
    }

    public function create($name, $description, $appCode = 0)
    {
        $role = new RoleModel();
        $role->name = $name;
        $role->nodes = '';
        $role->description = $description;
        $role->appcode = $appCode;
        return $role->save();
    }

    public function update($rid, $name, $description, $appCode)
    {
        return $this->roleModel->where2query([
            'appcode' => $appCode,
            'rid' => $rid,
        ])->update([
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function updateNodes($rid, $nodes, $appCode = 0)
    {
        return $this->roleModel->where2query([
            'appcode' => $appCode,
            'rid' => $rid,
        ])->update([
            'nodes' => $nodes,
        ]);
    }

    public function delete($rid, $appCode = 0)
    {
        return $this->roleModel->where2query([
            'rid' => $rid,
            'appcode' => $appCode,
        ])->delete();
    }

    public function get($rid, $appCode){
        return $this->roleModel->where2query([
            'rid' => $rid,
            'appcode' => $appCode,
        ])->first();
    }
}
