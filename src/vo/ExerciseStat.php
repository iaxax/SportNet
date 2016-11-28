<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/28
 * Time: 18:49
 *
 * 用户运动统计信息
 */
class ExerciseStat {

    //当日运动时间（分）
    private $todaySportTime;

    //当日运动步数（步）
    private $todaySteps;

    //总共运动时间（分）
    private $allSportTime;

    //总共运动步数（步）
    private $allSteps;

    public function __construct(
        $todaySportTime,
        $todaySteps,
        $totalSportTime,
        $totalSteps
    ) {
        $this->todaySportTime = $todaySportTime;
        $this->todaySteps = $todaySteps;
        $this->allSportTime = $totalSportTime;
        $this->allSteps = $totalSteps;
    }

    public function toJson() {
        $json = array(
            "todaySportTime" => intval($this->todaySportTime),
            "todaySteps" => intval($this->todaySportTime),
            "allSportTime" => intval($this->allSportTime),
            "allSteps" => intval($this->allSteps),
        );
        return json_encode($json);
    }

    /**
     * @return mixed
     */
    public function getTodaySportTime() {
        return $this->todaySportTime;
    }

    /**
     * @return mixed
     */
    public function getTodaySteps() {
        return $this->todaySteps;
    }

    /**
     * @return mixed
     */
    public function getAllSportTime() {
        return $this->allSportTime;
    }

    /**
     * @return mixed
     */
    public function getAllSteps() {
        return $this->allSteps;
    }

}