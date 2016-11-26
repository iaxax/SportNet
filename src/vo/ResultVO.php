<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 1:01
 *
 * 返回结果信息
 */
class ResultVO {

    private $success;

    private $message;

    public function __construct($success, $message) {
        $this->success = $success;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSuccess() {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }
}