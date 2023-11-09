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

use App\Dao\NodeDao;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class NodeController extends AdminController
{
    #[Inject]
    protected NodeDao $nodeDao;

    public function getNodeList()
    {
    }

    public function create()
    {
        $data = $this->request->all();
        $validator = $this->validationFactory->make(
            $data,
            [
                'title' => 'required|alpha_dash|between:1,20',
            ],
            [
                'title.*' => __('node.node_title_required'),
            ]
        );
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $this->nodeDao->create($data, $this->getAppCode());
        return $this->success('添加成功');
    }

    public function list()
    {
        $nodeTree = $this->nodeDao->getTree($this->getAppCode());
        return $this->success('success', $nodeTree);
    }

    public function update()
    {
        $data = $this->getRequestData([
            'nid' => 'required',
        ]);
        
        if (isset($data['app'])) {
            unset($data['app']);
        }

        $this->nodeDao->update($data['nid'], $data, $this->getAppCode());
        return $this->success('success');
    }
}
