<?php

require __DIR__ . "/../vo/UserInfoVO.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 7:48
 *
 * 有关用户好友请求的逻辑处理与数据存取
 */
class FriendModel {

    //数据库连接
    private $conn;

    //查询用户好友列表SQL语句
    private $friendSql;

    //搜索特定用户的SQL语句
    private $searchSql;

    public function __construct() {
        $this->conn = Connection::getConnection();

        $this->friendSql = $this->conn->prepare(
            "SELECT friend AS friend FROM friends " .
            "WHERE user = :user ;"
        );

        $this->searchSql = $this->conn->prepare(
            "SELECT name FROM user " .
            "WHERE name LIKE '%' || :key || '%' ;"
        );
    }

    /**
     * 获取用户的好友列表
     *
     * @param $user string 用户名
     * @return array 好友列表
     */
    public function getFriends($user) {
        $this->friendSql->execute(
            array(':user' => $user)
        );

        $list = array();
        foreach ($this->friendSql->fetchAll() as $row) {
            $vo = new UserInfoVO($row['friend']);
            array_push($list, $vo->toMap());
        }

        return $list;
    }

    /**
     * 模糊搜索与用户输入用户名匹配的用户
     *
     * @param $name string 用户名
     * @return array 用户列表
     */
    public function findUserByName($name) {
        $this->searchSql->execute(
            array(':key' => $name)
        );

        $list = array();
        foreach ($this->searchSql->fetchAll() as $row) {
            $vo = new UserInfoVO($row['name']);
            array_push($list, $vo->toMap());
        }
        return $list;
    }
}