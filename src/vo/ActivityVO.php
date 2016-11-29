<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 14:13
 *
 * 活动信息值对象
 */
class ActivityVO {

    //活动名称
    private $name;

    //活动创建者
    private $creator;

    //活动参与者
    private $participants;

    //活动开始时间

    private $startTime;
    //活动地点

    private $location;

    //活动类型
    private $type;

    public function __construct(
        $name, $creator, $participants,
        $startTime, $location, $type
    ) {
        $this->name = $name;
        $this->creator = $creator;
        $this->participants = $participants;
        $this->startTime = $startTime;
        $this->location = $location;
        $this->type = $type;
    }

    /**
     * 把对象转为关联数组
     * 字符串经过url encode转换
     *
     * @return array
     */
    public function toMap() {
        $p = array();
        foreach ($this->participants as $item) {
            if ($item instanceof UserInfoVO) {
                array_push($p, $item->toMap());
            }
        }

        return array(
            "name" => urlencode($this->name),
            "creator" => urlencode($this->creator),
            "p" => $p,
            "startTime" => urlencode($this->startTime),
            "location" => urlencode($this->location),
            "type" => urlencode($this->type)
        );
    }

    /**
     * @return mixed
     */
    public function getCreator() {
        return $this->creator;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getParticipants() {
        return $this->participants;
    }

    /**
     * @return mixed
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }
}