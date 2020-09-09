<?php


namespace InspireRedis;


class InspireZset
{
    const HOST = '127.0.0.1';
    const PORT = 6379;
    const AUTH = '';
    const DB   = '0';
    const TIMEOUT = 5;

    protected $redis = null;
    protected $host;
    protected $auth;
    protected $db;
    protected $timeout;

    /**
     * 连接redis
     * param: $db:选择redis库
     * */
    public function __construct($db ='')
    {
        $this->redis = new \Redis();
        $this->redis->connect(self::HOST,self::PORT,self::TIMEOUT);
        $this->redis->auth(self::AUTH);
        if(!empty($db))
        {
            $this->redis->select($db);
        }else{
            $this->redis->select(self::DB);
        }
    }

    /**
     * redis原生操作
     * */
    public function redis()
    {
        return $this->redis;
    }

    /**
     * 新增集合
     * param: $set:集合名称 $key:key值 $value:value值
     * */
    public function addZset($set,$key,$value)
    {
        return  $this->redis->zAdd($set,$value,$key);
    }

    /**
     * 查找集合
     * param: $set:集合名称  $key:key值
     * */
    public function getZset($set,$key)
    {
        return $this->redis->zScore($set,$key);
    }

    /**
     *  修改集合值
     *  param： $set:集合名  $key:key值 $value:value值
     * */
    public function upZset($set,$key,$value)
    {
        return $this->redis->zIncrBy($set,$value,$key);
    }

    /**
     *  删除指定排名区间集合值
     *  param： $set:集合名  $key:key值 $value:value值
     * */
    public function delRankZset($set,$start,$end)
    {
        return $this->redis->zRemRangeByRank($set,$start,$end);
    }

    /**
     *  删除指定分数区间集合值
     *  param： $set:集合名  $key:key值 $value:value值
     * */
    public function delScoreZset($set,$start,$end)
    {
        return $this->redis->zRemRangeByScore($set,$start,$end);
    }



    /**
     * 关闭redis连接
     * */
    public function __destruct()
    {
        $this->redis->close();
    }

}