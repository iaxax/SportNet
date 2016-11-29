<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 23:12
 *
 * 动态值对象
 */
class TrackVO {

    //发布者
    private $publisher;

    //动态内容
    private $content;

    //发布时间
    private $time;

    public function __construct(
        $publisher, $content, $time
    ) {
        $this->publisher = $publisher;
        $this->content = $content;
        $this->time = $time;
    }

    public function toMap() {
        return array(
            "publisher" => urlencode($this->publisher),
            "content" => urlencode($this->content),
            "time" => urlencode($this->time)
        );
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getPublisher() {
        return $this->publisher;
    }

    /**
     * @return mixed
     */
    public function getTime() {
        return $this->time;
    }

}
