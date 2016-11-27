<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 11:16
 *
 * 获取数据库连接
 */
class Connection {

    private static $path = null;

    private static $conn = null;

    static function init() {
        Connection::$path = "sqlite:" . __DIR__ . '/../../data/sport_net.db';
        if(Connection::$conn == null) {
            Connection::$conn = new PDO(Connection::$path);
        }

    }

    public static function getConnection() : PDO {
        return Connection::$conn;
    }
}

Connection::init();
