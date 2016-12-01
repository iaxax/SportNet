<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 22:23
 *
 * 用户动态信息的逻辑处理和数据UC你去
 */
class TrackModel {

    private $conn;

    public function __construct(){
        $this->conn = Connection::getConnection();
    }

    /**
     * 获得当前登录用户今天的动态
     *
     * @param $user string 用户名
     * @return array 动态列表
     */
    public function getTodayTracks($user) {

        $result = $this->conn->query(
            "SELECT * FROM track " .
            "WHERE publisher = '$user' AND " .
            "julianday('now') - julianday(publish_time) < 1;"
        );

        return $this->createTrackList($result);
    }

    /**
     * 获得一周内所有动态内容
     *
     * @return array 动态内容列表
     */
    public function getAllTracks() {

        $result = $this->conn->query(
            "SELECT * FROM track " .
            "WHERE julianday('now') - julianday(publish_time) <= 7 " .
            "ORDER BY publish_time desc"
        );

        return $this->createTrackList($result);
    }

    /**
     * 获得当前登录用户的历史动态
     *
     * @param $user string 用户名
     * @return array 历史动态列表
     */
    public function getHistoryTracks($user) {

        $result = $this->conn->query(
            "SELECT * FROM track " .
            "WHERE publisher = '$user' AND " .
            "julianday('now') - julianday(publish_time) >= 1;"
        );

        return $this->createTrackList($result);
    }

    /**
     * 当前用户发表一条动态
     *
     * @param $publisher string 动态发布者
     * @param $content string 动态内容
     * @param 动态内容
     * @return mixed 发表动态结果，参见ResultVO的定义
     */
    public function createTrack($publisher, $content) {

        $time = date('Y-m-d H:i:s');

        $result = $this->conn->exec(
            "insert into track values " .
            "('$publisher', '$content', '$time')"
        );

        if($result == 1) {
            return new ResultVO(true, new TrackVO(
                $publisher, $content, $time
            ));
        }
        else {
            return new ResultVO(false, "动态发表失败");
        }
    }

    private function createTrackList(PDOStatement $result) {
        $list = array();

        foreach ($result->fetchAll() as $row) {
            array_push($list, new TrackVO(
                $row['publisher'],
                $row['content'],
                $row['publish_time']
            ));
        }

        return $list;
    }
}