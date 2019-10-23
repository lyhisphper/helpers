<?php


namespace Service;


class QueryWhereService
{
    /**
     * @param $param
     * @param $whereArray
     * $where = QueryWhereService::where($param, [
     * '='  => ['t.user_id', 't.cash_type', 't.dealer_id', 't.status'],
     * '>=' => ['t.createtime_start', 't.money_start'],
     * '<=' => ['t.createtime_end', 't.money_end'],
     * ]);
     */
    public static function where($param, $whereArray, $where = [])
    {
        foreach ($whereArray as $whereType => $nameArr) {
            $tmpNameArr = [];
            $alias      = [];
            foreach ($nameArr as $item) {
                $item = str_replace('_end', '', $item);
                $item = str_replace('_start', '', $item);
                $item = explode('.', $item);
                if (count($item) == 1) {
                    $tmpNameArr[]    = $item[0];
                    $alias[$item[0]] = '';
                } else {
                    $tmpNameArr[]    = $item[1];
                    $alias[$item[1]] = $item[0];
                }
            }
            if ($whereType == 'like') {
                foreach ($param as $k => $v) {
                    if (in_array($k, $tmpNameArr) && $v != '' && $v != null) {
                        $where[] = [self::getAlias($k, $alias), 'like', trim($v) . '%'];
                    } else {
                        continue;
                    }
                }
            }

            if ($whereType == '=') {
                foreach ($param as $k => $v) {
                    if (in_array($k, $tmpNameArr) && $v != '' && $v != null) {
                        $where[] = [self::getAlias($k, $alias), '=', $v];
                    } else {
                        continue;
                    }
                }

            }
            if ($whereType == '>=') {
                foreach ($param as $k => $v) {
                    $k = str_replace('_start', '', $k);
                    if (in_array($k, $tmpNameArr) && $v != '' && $v != null) {
                        $where[] = [self::getAlias($k, $alias), '>=', $v];
                    } else {
                        continue;
                    }
                }
            }
            if ($whereType == '<=') {
                foreach ($param as $k => $v) {
                    $k = str_replace('_end', '', $k);
                    if (in_array($k, $tmpNameArr) && $v != '' && $v != null) {
                        $where[] = [self::getAlias($k, $alias), '<=', $v];
                    } else {
                        continue;
                    }
                }
            }
            if ($whereType == 'in') {
                foreach ($param as $k => $v) {
                    if (in_array($k, $tmpNameArr) && $v != '' && $v != null) {
                        $k       = str_replace('_end', '', $k);
                        $where[] = ['in' => [self::getAlias($k, $alias) => is_string($v) ? explode(',', $v) : $v]];
                    } else {
                        continue;
                    }
                }
            }
        }
        return $where;
    }

    private static function getAlias($k, $alias)
    {
        $aliasStr = $alias[$k];
        if ($alias[$k] != '') {
            $aliasStr = $aliasStr . '.' . $k;
        } else {
            $aliasStr = $k;
        }
        return $aliasStr;
    }
}