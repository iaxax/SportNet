<?php

require __DIR__ . "/../model/ExerciseModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/28
 * Time: 18:42
 *
 * 获取当前用户运动信息
 */
class ExerciseController extends Controller {

    private $model;

    public function __construct($request, $response) {
        parent::__construct($request, $response);
        $this->model = new ExerciseModel();
    }

    /**
     * 获取当前用户的运动统计信息
     */
    public function getExerciseStatInfo() {
        $user = $_SESSION['LoginUser'];
        return $this->model->getExerciseStatInfo($user)->toJson();
    }

    /**
     * 获取用户运动类型的统计数据
     */
    public function getExerciseTypeStat() {
        return $this->model->getExerciseTypeStat()->toJson();
    }

    /**
     * 获取用户运动时间的统计数据
     */
    public function getExerciseTimeStat() {
        return $this->model->getExerciseTimeStat()->toJson();
    }

    /**
     * 添加运动信息
     *
     * @param $user string 用户
     */
    public function createExerciseInfo($user) {
        $this->model->createExerciseInfo($user,
            $this->request->getParam('type'),
            $this->request->getParam('start_time'),
            $this->request->getParam('end_time'),
            $this->request->getParam('heart_rate'),
            $this->request->getParam('steps'),
            $this->request->getParam('distance'),
            $this->request->getParam('calories')
        );
    }

}