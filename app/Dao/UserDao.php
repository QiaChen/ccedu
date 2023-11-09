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

use App\Model\UsersModel;
use Hyperf\Di\Annotation\Inject;

class UserDao extends Dao
{
    #[Inject]
    protected UsersModel $usersModel;

    public function getUserByUsername($username, $appCode = 0)
    {
        return $this->usersModel->where2query([
            'username' => $username,
        ])->first();
    }

    public function getUserById($userid, $appCode = 0){
        return $this->usersModel->where2query([
            'userid' => $userid,
        ])->first();
    }

    public function update($data, $where){
        return $this->usersModel->where2query($where)->update($data);
    }
}
