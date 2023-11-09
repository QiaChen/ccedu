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

use App\Constants\AppCode;
use App\Model\NodeModel;
use Hyperf\Di\Annotation\Inject;

class NodeDao extends Dao
{
    #[Inject]
    protected NodeModel $nodeModel;

    public function getList($appCode = 0)
    {
        $apps = AppCode::ROUTES();
        return $this->nodeModel->newQuery()
            ->where('app', 'index')
            ->orWhere('app', $apps[$appCode])
            ->orderBy('parentid', 'ASC')
            ->orderBy('sort', 'ASC')
            ->get();
    }

    public function getTree(int $appCode = 0)
    {
        return ListToTreeRecursive($this->getList($appCode), 0, 'nid', 'parentid', 'children');
    }

    public function create($data, $appCode = 0)
    {
        $apps = AppCode::ROUTES();
        $data['app'] = $apps[$appCode];
        $newNode = new NodeModel();
        foreach ($data as $k => $v) {
            $newNode->{$k} = $v;
        }
        return $newNode->save();
    }

    public function update($nid, $data, $appCode = 0)
    {
        $apps = AppCode::ROUTES();
        return $this->nodeModel->where2query([
            'nid' => $nid, 'app' => $apps[$appCode]])
            ->update($data);
    }
}
