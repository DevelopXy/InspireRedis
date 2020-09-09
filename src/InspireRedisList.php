<?php


namespace InspireRedis;

/**
 * redis列表
 * */
class InspireRedisList
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
    protected $time;

    /**
     * 连接redis
     * param: $db:选择redis库
     * */
    public function __construct($db ='')
    {
        $this->time = microtime(true);
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
     * 返回redis原生操作
     * */
    public function redis()
    {
        return $this->redis;
    }

    /**
     * list头进入队操作
     * */
    public function setHead($key,$value)
    {
        return $this->redis->lpush($key,$value);
    }

    /**
     * list尾进入队操作
     * */
    public function setLast($key,$value)
    {
       return $this->redis->rPush($key,$value);
    }


    /**
     * list头出队操作
     * */
    public function getHead($key)
    {
        return $this->redis->lPop($key);
    }

    /**
     * list尾出队操作
     * */
    public function getLast($key)
    {
        return $this->redis->rPop($key);
    }

    /**
     * list获取队列长度
     * */
    public function getLen($key)
    {
        return $this->redis->lLen($key);
    }

    /**
     * list索引获取队列值
     * */
    public function getKey($list,$key)
    {
        return $this->redis->lindex($list,$key);
    }

    /**
     * list获取所有值
     * */
    public function getList($list, $len = -1)
    {
        return $this->redis->lrange($list, 0 ,$len);
    }

    /**
     * 关闭redis连接
     * */
    public function __destruct()
    {
        $etime=microtime(true);//获取程序执行结束的时间
        $total=$etime-$this->time;   //计算差值
        echo "当前页面执行时间为：{$total} 秒<br />";
        $this->redis->close();
    }
}