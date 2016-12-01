<?php

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
            "SELECT (sum(strftime('%H', end_time) - strftime('%H', start_time))) AS t, sum(steps) AS s FROM exercise WHERE user = :user; "
        );

        $this->todaySql = $this->conn->prepare(
            "SELECT (sum(strftime('%H', end_time) - strftime('%H', start_time))) AS t, sum(steps) AS s FROM exercise WHERE user = :user AND (julianday('now') - julianday(start_time)) < 1 ;"
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

    /**
     * 获取用户运动类型的统计数据
     */
    public function getExerciseTypeStat() {

        $result = $this->conn->query(
            "SELECT type, count(*) AS cnt FROM exercise " .
            "GROUP BY type; "
        );

        $arr = array();
        foreach ($result->fetchAll() as $row) {
            $arr[$row['type']] = $row['cnt'];
        }

        return new ExerciseTypeStat($arr);
    }

    /**
     * 获取用户运动时间的统计数据
     */
    public function getExerciseTimeStat() {

        $result = $this->conn->query(
            "select sum(strftime('%H',end_time) - strftime('%H',start_time)) AS t from exercise ".
            "group by user;"
        );

        $arr = array(
            "<450小时" => 0,
            "450-1000小时" => 0,
            ">1000小时" => 0
        );
        foreach ($result->fetchAll() as $row) {
            $t = $row['t'];
            if($t < 450) {
                $arr['<450小时'] += $t;
            }
            else if($t < 1000) {
                $arr['450-1000小时'] += $t;
            }
            else {
                $arr['>1000小时'] += $t;
            }
        }

        return new ExerciseTimeStat($arr);
    }

    /**
     * 添加运动信息
     *
     * @param $user string 用户名
     * @param $type string 运动类型
     * @param $start_time string 开始时间
     * @param $end_time string 结束时间
     * @param $heart_rate int 心率
     * @param $steps int 步数
     * @param $distance int 距离
     * @param $calories int 消耗能量
     */
    public function createExerciseInfo(
        $user, $type, $start_time, $end_time,
        $heart_rate, $steps, $distance, $calories
    ) {
        $this->conn->exec(
            "insert into exercise values(" .
            "'$user', '$type', '$start_time', '$end_time'," .
            "$heart_rate, $steps, $distance, $calories);"
        );
    }
}