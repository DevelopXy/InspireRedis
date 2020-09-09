<?php


namespace InspireRedis;


class InspireSet
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
     * 新增元素合集
     * */
    public function addSet($set,$content)
    {
       return $this->redis->sAdd($set,$content);
    }

    /**
     * 返回元素成员
     * */
    public function listSet($set)
    {
        return $this->redis->sMembers($set);
    }

    /**
     * 返回元素数量
     * */
    public function numSet($set)
    {
        return $this->redis->scard($set);
    }

    /**
     * 关闭redis连接
     * */
    public function __destruct()
    {
        $this->redis->close();
    }
}