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

namespace App\Middleware;

use App\Constants\ErrorCode;
use App\Exception\AuthException;
use App\Service\AuthService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected AuthService $authService;

    /**
     * 未登录能访问的path.
     */
    protected $_allows = [
        '/',
        '/page/info',
        '/auth/login'
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = '';
        if (is_array($request->getHeader('Authorization')) && isset($request->getHeader('Authorization')[0])) {
            $token = $request->getHeader('Authorization')[0];
        }
        if (! empty($token)) {
            $tokenInfo = $this->authService->getUserInfoByToken($token);

            if (! empty($tokenInfo)) {
                $request = Context::get(ServerRequestInterface::class);
                $request = $request->withAttribute('userid', $tokenInfo['userid']);
                Context::set(ServerRequestInterface::class, $request);
            }
        }

        /* 如果没有登录，且没有在允许访问的path列表中，直接提示 */
        if (empty($request->getAttribute('userid')) && ! in_array($request->getUri()->getPath(), $this->_allows)) {
           // throw new AuthException(ErrorCode::UNAUTHORIZED,'请先登陆');
        }

        return $handler->handle($request);
    }
}
