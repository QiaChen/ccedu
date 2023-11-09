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

namespace App\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;

abstract class Model extends BaseModel implements CacheableInterface
{
    use Cacheable;

    public function where2query($where, $query = null)
    {
        $query = $query ?? $this->newQuery();
        if (! $where) {
            return $query;
        }
        $boolean = strtolower($where['__logic'] ?? 'and');
        unset($where['__logic']);
        foreach ($where as $key => $item) {
            if (is_numeric($key) && is_array($item)) {
                $query->where(function ($query) use ($item) {
                    return $this->where2query($item, $query);
                }, null, null, $boolean);
                continue;
            }
            if (! is_array($item)) {
                $query->where($key, '=', $item, $boolean);
                continue;
            }
            if (\is_real_array($item)) {
                $query->whereIn($key, $item, $boolean);
                continue;
            }
            foreach ($item as $op => $val) {
                if ($op == 'not in' || $op == 'not_in') {
                    $query->whereNotIn($key, $val, $boolean);
                    continue;
                }
                if ($op == 'like') {
                    $query->where($key, 'like', $val, $boolean);
                    continue;
                }
                if ($op == 'between') {
                    $query->whereBetween($key, $val, $boolean);
                    continue;
                }
                if ($op == 'find_in_set') { // and or
                    $query->where(function ($q) use ($val, $key) {
                        if (! is_array($val)) {
                            $val = ['values' => $val, 'operator' => 'and'];
                        }
                        $operator = $val['operator'];
                        $method = ($operator === 'or' ? 'or' : '') . 'whereRaw';
                        foreach ($val['values'] as $set_val) {
                            $q->{$method}("find_in_set({$set_val}, {$key})");
                        }
                    });
                    continue;
                }
                $query->where($key, $op, $val, $boolean);
            }
        }
        return $query;
    }
}
