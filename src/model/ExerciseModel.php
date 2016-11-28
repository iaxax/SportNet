<?php

require __DIR__ . "/../vo/ExerciseStat.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/28
 * Time: 18:54
 *
 * 处理用户运动信息的逻辑处理
 */
class ExerciseModel {

    //数据库连接
    private $conn;

    //查询所有运动数据统计的SQL语句
    private $allSql;

    //查询今天运动数据统计的SQL语句
    private $todaySql;

    public function __construct() {
        $this->conn = Connection::getConnection();

        $this->allSql = $this->conn->prepare(
            "SELECT (sum(strftime('%M', end_time) - strftime('%M', start_time))) AS t, sum(steps) AS s FROM exercise WHERE user = :user; "
        );

        $this->todaySql = $this->conn->prepare(
            "SELECT (sum(strftime('%M', end_time) - strftime('%M', start_time))) AS t, sum(steps) AS s FROM exercise WHERE user = :user AND (julianday('now') - julianday(start_time)) < 1 ;"
        );
    }

    /**
     * 获取当前用户的运动统计信息
     *
     * @param $user string 用户名
     * @return ExerciseStat 用户运动的统计信息，参见ExerciseStat
     */
    public function getExerciseStatInfo($user) {
        //获取今日运动统计数据
        $this->todaySql->execute(
            array(':user' => $user)
        );
        $today = $this->todaySql->fetchAll();
        if($today != null) {
            $todaySportTime = $today[0]['t'];
            $todaySportSteps = $today[0]['s'];
        }
        else {
            $todaySportTime = 0;
            $todaySportSteps = 0;
        }

        //获取所有运动统计数据
        $this->allSql->execute(
            array(':user' => $user)
        );
        $total = $this->allSql->fetchAll();
        if($total != null) {
            $allSportTime = $total[0]['t'];
            $allSportSteps = $total[0]['s'];
        }
        else {
            $allSportTime = 0;
            $allSportSteps = 0;
        }

        return new ExerciseStat(
            $todaySportTime,
            $todaySportSteps,
            $allSportTime,
            $allSportSteps
        );
    }
}