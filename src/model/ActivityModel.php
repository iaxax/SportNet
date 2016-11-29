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
            "SELECT a.* FROM activity AS a, activity_join AS aj " .
            "WHERE (strftime('%s', 'now') - strftime('%s', a.startTime)) > 0 " .
            "AND a.name = aj.activity AND " .
            "(a.creator = '$user' or aj.participant = '$user');"
        );

        return $this->createActivityList($result);
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