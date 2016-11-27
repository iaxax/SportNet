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

    private static $path;

    private static $conn;

    static function init() {
        Connection::$path = "sqlite:" . __DIR__ . '/../../data/db.sqlite3';
        if(Connection::$conn == null) {
            try {
                Connection::$conn = new PDO(Connection::$path);
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public static function getConnection() {
        return Connection::$conn;
    }
}

Connection::init();
