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

namespace App\Service;

use App\Dao\NodeDao;
use App\Dao\RoleDao;
use App\Dao\UserDao;
use App\Exception\AuthException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

class AuthService extends Service
{
    #[Inject]
    protected UserDao $userDao;

    #[Inject]
    protected NodeDao $nodeDao;

    #[Inject]
    protected RoleDao $roleDao;

    #[Inject]
    protected Redis $redis;

    /**
     * @param mixed $appCode
     * @return mixed
     */
    public function checkPassword(string $username, string $password, $appCode = 0)
    {
        $data = $this->userDao->getUserByUsername($username, $appCode);

        if (empty($data)) {
            throw new AuthException(AuthException::PASSWORD_ERROR);
        }
        if ($data['password'] != $this->passwordEncode($password)) {
            throw new AuthException(AuthException::PASSWORD_ERROR);
        }
        return $data;
    }

    /**
     * @description 加密用户密码
     * @param mixed $password
     * @param mixed $salt
     * @return string
     */
    public function passwordEncode($password, $salt = 'salt999')
    {
        return md5(md5($password) . $salt);
    }

    /**
     * @description 获取token对应的redis key
     */
    public function getTokenKey(string $token): string
    {
        return 'token_' . $token;
    }

    /**
     * @return array|mixed
     * @description 通过token 获取用户数据
     */
    public function getUserInfoByToken(string $token)
    {
        $data = $this->redis->get($this->getTokenKey($token));
        $this->redis->expire($this->getTokenKey($token), 60 * 15);
        if (empty($data)) {
            return [];
        }
        return unserialize($data);
    }

    /**
     * @description 给用户生成token
     */
    public function createToken(int $userid): string
    {
        $data = $this->userDao->getUserById($userid);
        if (empty($data)) {
            throw new AuthException(AuthException::USER_NOT_FOUND);
        }
        $token = md5($userid . '_' . uniqid((string) microtime(true), true));
        $this->redis->SETNX($this->getTokenKey($token), serialize($data));
        $this->redis->expire($this->getTokenKey($token), 3600);
        return $token;
    }

    public function getNodesByRid($rid, $appCode)
    {
        if ($rid == 0) {
            $where = [];
        } else {
            $role = $this->roleDao->get($rid);
            if (empty($role)) {
                throw new AuthException(AuthException::ROLE_NOT_FOUND);
            }
            $where['nid'] = explode(',', $role->nodes);
        }
        return $this->nodeDao->list($where, $appCode);
    }
}
