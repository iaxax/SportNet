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

    public function toJson() {
        $msg = urlencode($this->message);
        $json = array(
            "success" => $this->success,
            "message" => $msg
        );
        return urldecode(json_encode($json));
    }
}