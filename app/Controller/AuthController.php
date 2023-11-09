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

namespace App\Controller;

use App\Dao\UserDao;
use App\Exception\AuthException;
use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;

#[AutoController]
class AuthController extends AbstractController
{
    #[Inject]
    protected AuthService $AuthService;

    #[Inject]
    protected UserDao $userDao;

    public function login(RequestInterface $request)
    {
        $data = $request->all();
        $validator = $this->validationFactory->make(
            $data,
            [
                'password' => 'required',
                'username' => 'required',
            ],
            [
                'username.*' => __('auth.username_error'),
                'password.*' => __('auth.password_empty'),
            ]
        );
        if ($validator->fails()) {
            throw new AuthException(AuthException::VALIDATION_FAILURE, $validator->errors()->first());
        }
        $userInfo = $this->AuthService->checkPassword($data['username'], $data['password'], $this->getAppCode());
        $token = $this->AuthService->createToken($userInfo->userid);

        $ip = $this->request->server('remote_addr');
        if (empty($ip) or $ip == '127.0.0.1') {
            $ip = $this->request->header('x-real-ip');
        }
        $this->userDao->update(['userid' => $userInfo->userid], [
            'last_login_time' => date('Y-m-d H:i:s', time()),
            'last_login_ip' => $ip,
        ]);
        return $this->success('登录成功', [
            'token' => $token,
            'expireAt' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'user' => [
                'name' => $userInfo['username'],
                'avatar' => 'https://gw.alipayobjects.com/zos/rmsportal/cnrhVkzwxjPwAaCfPbdc.png',
                'address' => 'address 测试地址',
                'position' => '开发管理员',
            ],
            'permissions' => [],
            'roles' => [],
        ]);
    }
}
