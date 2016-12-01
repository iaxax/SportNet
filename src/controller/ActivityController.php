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

    /**
     * 获得所有未到期的活动
     */
    public function getAllActivities() {
        $list = $this->model->getAllActivities();
        return $this->toJson($list);
    }

    /**
     * 参与一个活动
     */
    public function joinActivity() {
        return $this->model->joinActivity(
            $this->request->getParam('user'),
            $this->request->getParam('activity')
        )->toJson();
    }

    /**
     * 检测系统是否存在该活动名
     */
    public function isNameExist() {
        $name = $this->request->getParam("name");
        $result = $this->model->isNameExist($name);
        return json_encode(array("same" => $result));
    }

    /**
     * 创建一个活动
     */
    public function createActivity() {
        return $this->model->createActivity(
            $this->request->getParam('name'),
            $_SESSION['LoginUser'],
            $this->request->getParam('time'),
            $this->request->getParam('location'),
            $this->request->getParam('type')
        )->toJson();
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