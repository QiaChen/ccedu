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

use App\Constants\ErrorCode;
use App\Exception\AuthException;
use App\Exception\ValidationException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    /**
     * 获取登录用户id.
     */
    public function getUserId()
    {
        $userid = $this->request->getAttribute('userid');
        if (empty($userid)) {
            throw new AuthException(AuthException::UNAUTHORIZED);
        }
        return $userid;
    }

    /**
     * 获取当前系统
     */
    public function getAppCode()
    {
        return intval($this->request->getAttribute('appcode', 0));
    }

    /**
     * 获取请求参数.
     * @param mixed $rules
     * @param mixed $errorMsg
     */
    public function getRequestData($rules, $errorMsg = [])
    {
        $data = $this->request->all();
        if (empty($errorMsg)) {
            $errorMsg = [
                'required' => 'The :attribute field is required.',
                'integer' =>  'The :attribute field is integer.',
            ];
        }
        $validator = $this->validationFactory->make($data,$rules,$errorMsg);
        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->first());
        }
        return $data;
    }

    public function success(string $msg = 'success', $data = [], $code = 200)
    {
        return $this->response->json([
            'code' => $code,
            'message' => $msg,
            'result' => $data,
        ]);
    }

    public function error(string $message = '', int $code = ErrorCode::SERVER_ERROR)
    {
        return $this->response->json([
            'code' => $code,
            'message' => $message,
            'result' => [],
        ]);
    }
}
