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

class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'ccedu');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
