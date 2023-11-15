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

use App\Model\ConfigModel;
use Hyperf\Di\Annotation\Inject;

class ConfigDao extends Dao
{
    #[Inject]
    protected ConfigModel $configModel;

    public function get($key, $default = '', $list = 'system', $appCode = 0)
    {
        $info = $this->configModel->where2query([
            'key' => $key,
            'list' => $list,
            'appcode' => $appCode,
        ])->first();
        if (empty($info)) {
            return $default;
        }
        return $info->value;
    }

    public function set($key, $value, $list = 'system', $appCode = 0)
    {   
        if($this->get($key, null, $list, $appCode) === null){
            $config = new ConfigModel;
            $config->key = $key;
            $config->value = $value;
            $config->list = $list;
            $config->appCode = $appCode;
            return $config->save();
        }else{
            return $this->configModel->where2query([
                'key' => $key,
                'list' => $list,
                'appcode' => $appCode,
            ])->update(['value' => $value]);
        }
        
    }

    public function setM($data, $list = 'system', $appCode = 0)
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value, $list, $appCode);
        }
        return true;
    }

    public function list($list = '', $appCode = 0)
    {
        $where = ['appcode' => $appCode];
        if (! empty($list)) {
            $where['list'] = $list;
        }
        return $this->configModel->where2query($where)->get();
    }
}
