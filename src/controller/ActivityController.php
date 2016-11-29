<?php

require __DIR__ . "/../model/ActivityModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 13:59
 */
class ActivityController extends Controller {

    private $model;

    public function __construct($request, $response) {
        parent::__construct($request, $response);
        $this->model = new ActivityModel();
    }

    /**
     * 获得当前登录用户所创建的未过期活动
     */
    public function getCreated() {
        $user = $_SESSION['LoginUser'];
        $list = $this->model->getCreated($user);
        return $this->toJson($list);
    }

    /**
     * 获得当前登录用户所参与的未过期活动
     */
    public function getInvolved() {
        $user = $_SESSION['LoginUser'];
        $list = $this->model->getInvolved($user);
        return $this->toJson($list);
    }

    /**
     * 获得当前登录用户的活动历史
     */
    public function getHistory() {
        $user = $_SESSION['LoginUser'];
        $list = $this->model->getHistory($user);
        return $this->toJson($list);
    }

    private function toJson($list) {
        $arr = array();
        foreach ($list as $vo) {
            if($vo instanceof ActivityVO) {
                array_push($arr, $vo->toMap());
            }
        }
        return urldecode(json_encode($arr));
    }
}