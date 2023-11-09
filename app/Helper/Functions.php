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
if (! function_exists('is_real_array')) {
    /**
     * 检测是否是一个真实的类C的索引数组.
     * @param mixed $arr
     */
    function is_real_array($arr)
    {
        if (! is_array($arr)) {
            return false;
        }
        $n = count($arr);
        for ($i = 0; $i < $n; ++$i) {
            if (! isset($arr[$i])) {
                return false;
            }
        }

        return true;
    }
}
if (! function_exists('number2chinese')) {
    function number2chinese($amount)
    {
        $amount = (string) $amount;
        $len = mb_strlen($amount);
        $str = '';
        switch ($len) {
            case 1:
                $str = $amount . '+';
                break;
            case 2:
                $str = substr($amount, 0, 1) . '0+';
                break;
            case 3:
                $str = substr($amount, 0, 1) . '00+';
                break;
            case 4:
                $str = substr($amount, 0, 1) . '000+';
                break;
            case 5:
                $str = substr($amount, 0, 1) . '万+';
                break;
            case 6:
                $str = substr($amount, 0, 2) . '万+';
                break;
            case 7:
                $str = substr($amount, 0, 3) . '万+';
                break;
            case 8:
                $str = substr($amount, 0, 4) . '万+';
                break;
        }
        return $str;
    }
}

if (! function_exists('ListToTreeRecursive')) {
    function ListToTreeRecursive($dataArr, $rootId = 0, $pkName = 'id', $pIdName = 'parentid', $childName = 'children'): array
    {
        $arr = [];
        foreach ($dataArr as $sorData) {
            if ($sorData[$pIdName] == $rootId) {
                $children = ListToTreeRecursive($dataArr, $sorData[$pkName], $pkName, $pIdName, $childName);
                if ($children) {
                    $sorData[$childName] = $children;
                }
                $arr[] = $sorData;
            }
        }
        return $arr;
    }
}
