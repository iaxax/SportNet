<?php

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
        $loginUser = $_SESSION['LoginUser'];

        $this->conn = Connection::getConnection();

        $this->friendSql = $this->conn->prepare(
            "SELECT friend AS friend FROM friends " .
            "WHERE user = :user ;"
        );

        $this->searchSql = $this->conn->prepare(
            "SELECT name FROM user " .
            "WHERE name LIKE '%' || :key || '%'" .
            "AND name != '$loginUser' ;"
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
     * 模糊搜索与用户输入用户名匹配的用户,不包括用户本人
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


    /**
     * 为当前用户添加好友
     *
     * @param $user string 发出添加请求的用户
     * @param $friend string 待添加用户的用户名
     * @return ResultVO 添加结果，参见ResultVO的定义
     */
    public function addFriend($user, $friend) {
        $count = $this->conn->exec(
            "INSERT INTO friends VALUES " .
            "('$user', '$friend');"
        );

        if($count == 1) {
            return new ResultVO(true, "添加成功");
        }
        else {
            return new ResultVO(false, "添加失败");
        }
    }

    /**
     * 删除好友
     * @param $user string 发出删除请求的用户
     * @param $friend string 待删除用户的用户名
     * @return ResultVO 删除结果，参见ResultVO的定义
     */
    public function removeFriend($user, $friend) {
        $count = $this->conn->exec(
            "delete from friends " .
            "where user = '$user' and friend = '$friend';"
        );

        if($count == 1) {
            return new ResultVO(true, "删除成功");
        }
        else {
            return new ResultVO(false, "删除失败");
        }
    }
}