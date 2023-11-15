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

use App\Dao\ConfigDao;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class ConfigController extends AdminController
{
    #[Inject]
    protected ConfigDao $configDao;

    public function save()
    {
    }

    public function list()
    {
        $list = ['system'];

        $data = $this->configDao->list('system', $this->getAppCode());
        $res = [];
        foreach ($data as $k => $v) {
            $res[$v->key] = $v->value;
        }
        return $this->success('success', $res);
    }

    public function update()
    {
        $data = $this->request->all();
        $keys = ['site_name'];
        $saveData = [];
        foreach ($data as $k => $value) {
            if (! in_array($k, $keys)) {
                continue;
            }
            $saveData[$k] = $value;
        }

        $this->configDao->setM($saveData, 'system', $this->getAppCode());
        return $this->success();
    }
}
