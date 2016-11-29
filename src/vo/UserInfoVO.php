<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/28
 * Time: 18:35
 *
 * 当前登录用户的信息
 */
class UserInfoVO {

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function toMap() {
        return array("name" => $this->name);
    }

    public function toJson() {
        return json_encode($this->toMap());
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }
}