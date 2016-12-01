<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/12/1
 * Time: 12:37
 *
 * 用户运动时间统计数据
 */
class ExerciseTimeStat {

    private $stat;

    public function __construct(array $stat) {
        $this->stat = $stat;
    }

    public function toJson() {
        $arr = array();

        foreach ($this->stat as $key => $value) {
            $arr[urlencode($key)] = $value;
        }

        return urldecode(json_encode($arr));
    }
}