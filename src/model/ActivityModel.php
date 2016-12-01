<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 13:59
 */
class ActivityModel {

    //数据库链接
    private $conn;

    //活动历史查询SQL
    private $historySql;

    public function __construct() {
        $this->conn = Connection::getConnection();

        $this->historySql = $this->conn->prepare(
            "SELECT a.*, aj.participant AS p FROM activity AS a, activity_join AS aj " .
            "WHERE (strftime('%s', 'now') - strftime('%s', a.startTime)) > 0 " .
            "AND a.name = aj.activity AND " .
            "(a.creator = ':user' or aj.participant = :user);"
        );

    }

    /**
     * 获得当前登录用户所创建的未过期活动
     *
     * @param $user string 用户名
     * @return array 创建活动列表
     */
    public function getCreated($user) {

        $result = $this->conn->query(
            "SELECT * FROM activity a " .
            "WHERE a.creator = '$user' AND " .
            "(strftime('%s','now') - strftime('%s', a.startTime)) < 0;"
        );

        return $this->createActivityList($result);
    }

    /**
     * 获得当前登录用户所参与的未过期活动
     *
     * @param $user string 用户名
     * @return array 参与活动列表
     */
    public function getInvolved($user) {

        $result = $this->conn->query(
            "SELECT a.* FROM activity AS a, activity_join AS aj " .
            "WHERE (strftime('%s', 'now') - strftime('%s', a.startTime)) < 0 " .
            "AND a.name = aj.activity AND aj.participant = '$user' ;"
        );

        return $this->createActivityList($result);
    }

    /**
     * 获得当前登录用户的活动历史
     *
     * @param $user string 用户名
     * @return array 历史活动列表
     */
    public function getHistory($user) {

        $result = $this->conn->query(
            "SELECT DISTINCT creator,  name, startTime, location, type FROM activity AS a, activity_join AS aj " .
            "WHERE (strftime('%s', 'now') - strftime('%s', a.startTime)) > 0 " .
            "AND a.name = aj.activity AND " .
            "(a.creator = '$user' or aj.participant = '$user');"
        );

        return $this->createActivityList($result);
    }

    /**
     * 获得所有未到期的活动
     *
     * @return array 活动列表
     */
    public function getAllActivities() {

        $result = $this->conn->query(
            "SELECT * FROM activity " .
            "WHERE (strftime('%s', 'now') - strftime('%s', startTime)) < 0;"
        );

        return $this->createActivityList($result);
    }

    /**
     * 参与一个活动
     *
     * @param $user string 用户名
     * @param $activity string 活动名
     * @return ResultVO 添加结果，参见ResultVO的定义
     */
    public function joinActivity($user, $activity) {

        $result = $this->conn->exec(
            "insert into activity_join " .
            "values('$activity', '$user');"
        );

        if($result == 1) {
            return new ResultVO(true, "添加活动成功");
        }
        else {
            return new ResultVO(false, "添加活动失败");
        }
    }

    /**
     * 检测系统是否存在该活动名
     *
     * @param $name string 活动名称
     * @return bool 是否存在该活动名称
     */
    public function isNameExist($name) {
        $result = $this->conn->query(
            "select * from activity " .
            "where name = '$name';"
        );

        return $result->fetch();
    }

    /**
     * 创建一个活动
     *
     * @param $name string 活动名称
     * @param $creator string 创建者
     * @param $time string 活动开始时间
     * @param $location string 活动地点
     * @param $type string 活动类型
     * @return ResultVO 创建结果，参见ResultVO的定义
     */
    public function createActivity(
        $name, $creator, $time, $location, $type
    ) {

        $result = $this->conn->exec(
            "insert into activity values" .
            "('$name', '$creator', '$time', '$location', '$type');"
        );

        if($result == 1) {
            return new ResultVO(true, "活动创建成功");
        }
        else {
            return new ResultVO(false, "活动创建失败");
        }
    }

    /**
     * 由结果集创建活动列表
     *
     * @param PDOStatement $result 结果集
     * @return array 活动列表
     */
    private function createActivityList(PDOStatement $result) {
        $list = array();

        foreach ($result as $row) {
            $name = $row['name'];
            $participants = $this->conn->query(
                "select participant from activity_join " .
                "where activity = '$name';"
            );

            $p_arr = array();
            foreach ($participants as $p) {
                array_push($p_arr, new UserInfoVO($p['participant']));
            }

            array_push($list, new ActivityVO(
                $name, $row['creator'], $p_arr,
                $row['startTime'], $row['location'], $row['type']
            ));
        }

        return $list;
    }
}